<?php
/**
 * page-status.php — /status/, on the Code Craft status layout.
 *
 * Everything shown is real: component health, 90-day bars, uptime and the
 * 24-hour charts come from the monitor in inc/status.php (one option, filled
 * by WP-Cron every 5 minutes — no HTTP request happens while this renders).
 * Incidents are WordPress posts in the 'incidents' category:
 *   title          → incident title
 *   excerpt        → one-line summary
 *   content        → the update timeline (Heading 3 "Resolved · 14:48" +
 *                    a paragraph, newest first)
 *   custom fields  → severity (minor | major | maintenance — or a tag of
 *                    that name), affected ("vip.sraik.com · Payment gateway"),
 *                    duration ("43 min")
 *
 * Copy: inc/content/status-page.php · Styles: assets/css/status.css
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$c = sraik_content( 'status-page' );
$v = sraik_status_view();

$state = $v['overall'];
$tz    = 'BST';

/* "Subscribe": WhatsApp channel when configured, else the incidents feed. */
$inc_cat = get_category_by_slug( sraik_config( 'blog' )['incident_cat'] );
$sub_url = sraik_url( 'wa_channel', '' );
if ( '' === $sub_url ) {
	$sub_url = $inc_cat ? get_category_feed_link( $inc_cat->term_id ) : $c['subscribe'][1];
}

/* Summary line under the overall state. */
if ( $v['last'] ) {
	$sum = sprintf( '%d of %d components healthy · last check %s %s', $v['healthy'], $v['total'], sraik_status_date( time() - $v['last'] > DAY_IN_SECONDS ? 'M j, H:i' : 'H:i', $v['last'] ), $tz );
} else {
	$sum = 'Monitoring has just started — the first results appear within a few minutes.';
}

$stats = array(
	array(
		$v['uptime'] ? $v['uptime'] : '—',
		$v['days_n'] ? sprintf( 'Uptime · last %d %s', $v['days_n'], 1 === $v['days_n'] ? 'day' : 'days' ) : 'Uptime · no data yet',
	),
	array( $v['median'] ? sraik_status_ms( $v['median'] ) : '—', 'Median response · 24h' ),
	array( (string) $v['inc_count'], 'Incidents · last 90 days' ),
);

$pill_icon = array( 0 => 'check', 1 => 'triangle-alert', 2 => 'x', -1 => 'minus' );
$pill_cls  = array( 0 => 'up', 1 => 'deg', 2 => 'down', -1 => 'none' );

/* Live data: let page caches keep this view for minutes, not hours. */
if ( ! headers_sent() ) {
	header( 'Cache-Control: public, max-age=60' );
}
do_action( 'litespeed_control_set_ttl', 300 ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals -- LiteSpeed Cache API

sraik_page_css( array( 'css/status.css' ) );
sraik_part( 'head.php' );
sraik_part( 'nav.php' );
?>
<main id="main" class="page">
  <section class="hero st-hero st-hero--<?php echo esc_attr( $state ); ?>" aria-labelledby="st-title">
    <?php sraik_hero_bg( false ); ?>
    <div class="st-hero-in">
      <div class="st-head">
        <div class="st-head-l" data-appear>
          <?php echo sraik_eyebrow( $c['eyebrow'] ); // phpcs:ignore ?>
          <h1 id="st-title" class="t-display st-title"><?php echo esc_html( $c['titles'][ $state ][0] ); ?> <span class="hl"><?php echo esc_html( $c['titles'][ $state ][1] ); ?></span></h1>
        </div>
        <div class="st-head-r" data-appear>
          <div class="st-btns">
            <?php echo sraik_btn( $c['report'][0], $c['report'][1], 'dark' ); // phpcs:ignore ?>
            <?php echo sraik_btn( $c['subscribe'][0], $sub_url, 'lime', 'arrow-right' ); // phpcs:ignore ?>
          </div>
          <p class="st-note"><?php echo esc_html( $c['note'] ); ?></p>
        </div>
      </div>

      <div class="st-sum" data-appear>
        <div class="st-sum-glow" aria-hidden="true"></div>
        <div class="st-sum-main">
          <div class="st-sum-row">
            <span class="st-ind st-ind--<?php echo esc_attr( $state ); ?>" aria-hidden="true"><i></i><b></b></span>
            <h2 class="t-h5"><?php echo esc_html( $c['summary'][ $state ] ); ?></h2>
          </div>
          <p class="st-sum-sub"><?php echo esc_html( $sum ); ?></p>
        </div>
        <?php foreach ( $stats as $st ) : ?>
        <div class="st-stat">
          <p class="st-stat-v"><?php echo esc_html( $st[0] ); ?></p>
          <p class="st-stat-l"><?php echo esc_html( $st[1] ); ?></p>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="sec st-sec" aria-labelledby="st-comp">
    <div class="st-in st-in--comp">
      <div class="st-comp-head">
        <h2 id="st-comp" class="t-h4b"><?php echo esc_html( $c['components'] ); ?></h2>
        <ul class="st-legend">
          <?php foreach ( array( 'up', 'deg', 'down', 'maint', 'none' ) as $k ) : ?>
          <li><i class="st-sq st-sq--<?php echo esc_attr( $k ); ?>" aria-hidden="true"></i><?php echo esc_html( $c['legend'][ $k ] ); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <ul class="st-comps" data-appear>
        <?php foreach ( $v['rows'] as $key => $r ) : ?>
        <li class="st-comp">
          <div class="st-comp-top">
            <div class="st-comp-name">
              <h3><?php echo esc_html( $r['name'] ); ?></h3>
              <p><?php echo esc_html( $r['desc'] ); ?></p>
            </div>
            <span class="st-pill st-pill--<?php echo esc_attr( $pill_cls[ $r['state'] ] ); ?>"><?php sraik_i( $pill_icon[ $r['state'] ], 12, 2 ); ?><?php echo esc_html( $c['pill'][ $r['state'] ] ); ?></span>
          </div>
          <div class="st-days">
            <div class="st-bars" role="img" aria-label="<?php echo esc_attr( $r['name'] . ': ' . ( $r['uptime'] ? $r['uptime'] . ' uptime over the recorded days' : 'no data yet' ) ); ?>">
              <?php
              foreach ( $r['bars'] as $b ) :
                $ts  = strtotime( $b['day'] . ' 12:00:00' );
                $tip = gmdate( 'M j, Y', $ts ) . ' · ';
                if ( 'none' === $b['state'] ) {
                  $tip .= 'no data';
                } else {
                  $tip .= sraik_status_pct_label( $b['row']['c'] - $b['row']['x'], $b['row']['c'] ) . ' up · ' . (int) $b['row']['c'] . ' checks';
                  if ( $b['row']['n'] ) {
                    $tip .= ' · avg ' . sraik_status_ms( $b['row']['ms'] / $b['row']['n'] );
                  }
                }
                ?><i class="st-bar st-bar--<?php echo esc_attr( $b['state'] ); ?>" title="<?php echo esc_attr( $tip ); ?>"></i><?php
              endforeach;
              ?>
            </div>
            <div class="st-days-foot">
              <span>90 days ago</span><span class="st-rule"></span><span><?php echo esc_html( $r['uptime'] ? $r['uptime'] . ' uptime' : 'No data yet' ); ?></span><span class="st-rule"></span><span>Today</span>
            </div>
          </div>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>

  <section class="sec st-sec" aria-labelledby="st-perf">
    <div class="st-in st-in--perf">
      <h2 id="st-perf" class="t-h4b"><?php echo esc_html( $c['perf_title'] ); ?></h2>
      <div class="st-charts">
        <?php
        foreach ( $c['charts'] as $key => $label ) :
          $smp  = isset( $v['samples'][ $key ] ) ? $v['samples'][ $key ] : array();
          $vals  = array();
          $first = 0;
          foreach ( $smp as $s ) {
            if ( 2 !== (int) $s[1] && $s[2] > 0 ) {
              $vals[] = (int) $s[2];
              $first  = $first ? $first : (int) $s[0];
            }
          }
          $svg   = sraik_status_spark( $smp, $key );
          /* The line spans the samples we have: label its real start until a full day exists. */
          $from = ( ! $first || time() - $first > 23 * HOUR_IN_SECONDS ) ? '24h ago' : sraik_status_date( 'H:i', $first ) . ' ' . $tz;
          ?>
        <div class="st-chart" data-appear>
          <div class="st-chart-head">
            <div class="st-chart-t">
              <p class="st-chart-l"><?php echo esc_html( $label ); ?></p>
              <p class="st-chart-v"><?php echo esc_html( $vals ? sraik_status_ms( sraik_status_median( $vals ) ) : '—' ); ?></p>
            </div>
            <?php if ( $vals ) : ?>
            <span class="st-chart-pill">median · p95 <?php echo esc_html( sraik_status_ms( sraik_status_pct( $vals, 95 ) ) ); ?></span>
            <?php endif; ?>
          </div>
          <div class="st-chart-plot">
            <?php if ( $svg ) : ?>
              <?php echo $svg; // phpcs:ignore WordPress.Security.EscapeOutput -- built from numbers in sraik_status_spark() ?>
            <?php else : ?>
            <div class="st-chart-empty"><?php echo esc_html( $c['perf_empty'] ); ?></div>
            <?php endif; ?>
            <div class="st-chart-axis"><span><?php echo esc_html( $from ); ?></span><span>Now</span></div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="sec st-sec" aria-labelledby="st-inc">
    <div class="st-in st-in--inc">
      <div class="st-inc-head" data-appear>
        <div class="st-inc-hl">
          <p class="st-inc-eb"><?php echo esc_html( $c['inc_eyebrow'] ); ?></p>
          <h2 id="st-inc" class="t-h2"><?php echo esc_html( $c['inc_title'] ); ?></h2>
        </div>
        <p class="st-inc-sub"><?php echo esc_html( $c['inc_sub'] ); ?></p>
      </div>
      <ol class="st-incs">
        <?php if ( $v['incidents'] ) : ?>
          <?php
          foreach ( $v['incidents'] as $inc ) :
            $p       = $inc['post'];
            $sev     = $inc['severity'];
            $content = apply_filters( 'the_content', $p->post_content ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals
            ?>
        <li class="st-inc" data-appear>
          <div class="st-inc-meta">
            <time datetime="<?php echo esc_attr( sraik_status_date( 'c', $inc['time'] ) ); ?>"><?php echo esc_html( sraik_status_date( 'M j, Y', $inc['time'] ) ); ?></time>
            <span class="st-sev st-sev--<?php echo esc_attr( $sev ); ?>"><i aria-hidden="true"></i><?php echo esc_html( $c['severity'][ $sev ] ); ?></span>
            <?php if ( $inc['duration'] ) : ?>
            <span class="st-dur"><?php sraik_i( 'clock', 12, 2 ); ?><?php echo esc_html( $inc['duration'] ); ?></span>
            <?php endif; ?>
          </div>
          <div class="st-inc-body">
            <span class="st-inc-dot" aria-hidden="true"></span>
            <h3 class="t-h5"><?php echo esc_html( wp_strip_all_tags( get_the_title( $p ) ) ); ?></h3>
            <?php if ( $inc['affected'] ) : ?>
            <p class="st-aff"><span>Affected</span><span><?php echo esc_html( $inc['affected'] ); ?></span></p>
            <?php endif; ?>
            <?php if ( has_excerpt( $p ) ) : ?>
            <p class="st-inc-sum"><?php echo esc_html( get_the_excerpt( $p ) ); ?></p>
            <?php endif; ?>
            <?php if ( trim( wp_strip_all_tags( $content ) ) ) : ?>
            <div class="st-upd"><?php echo wp_kses_post( $content ); ?></div>
            <?php endif; ?>
          </div>
        </li>
          <?php endforeach; ?>
        <?php else : ?>
        <li class="st-inc st-inc--none" data-appear>
          <div class="st-inc-meta" aria-hidden="true"></div>
          <div class="st-inc-body">
            <span class="st-inc-dot" aria-hidden="true"></span>
            <h3 class="t-h5"><?php echo esc_html( $c['inc_none']['title'] ); ?></h3>
            <p class="st-inc-sum"><?php echo esc_html( $c['inc_none']['text'] ); ?></p>
          </div>
        </li>
        <?php endif; ?>
      </ol>
    </div>
  </section>
</main>
<?php
sraik_part( 'footer.php' );
sraik_part( 'foot.php' );
