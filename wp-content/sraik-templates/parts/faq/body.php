<?php
/**
 * faq/body.php — sticky topic sidebar ([data-toc] highlights the topic in
 * view) and every topic as a section: "§n slug ——— n answers" kicker,
 * gloss icon + heading, then its accordion (first question open, as in
 * the template). Deep links #q-<id> open their question (site.js).
 *
 * $c      = content/faq-page.php
 * $groups = FAQ groups (non-empty)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$sb = $c['sidebar'];
?>
<section class="fq-body" aria-label="<?php echo esc_attr( 'Questions by topic' ); ?>">
  <div class="fq-body-in">
    <aside class="fq-side">
      <nav class="fq-toc" data-toc aria-label="<?php echo esc_attr( $sb['topics_l'] ); ?>">
        <div class="fq-toc-grp">
          <span class="fq-toc-l"><?php echo esc_html( $sb['topics_l'] ); ?></span>
          <div class="fq-toc-list">
            <?php foreach ( $groups as $i => $g ) : ?>
            <a href="#<?php echo esc_attr( $g['slug'] ); ?>"<?php echo 0 === $i ? ' class="is-active"' : ''; ?>><?php echo esc_html( $g['title'] ); ?></a>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="fq-toc-grp">
          <span class="fq-toc-l"><?php echo esc_html( $sb['more_l'] ); ?></span>
          <div class="fq-toc-list">
            <?php foreach ( $sb['more'] as $m ) : ?>
            <a href="<?php echo esc_url( sraik_href( $m[1] ) ); ?>"><?php echo esc_html( $m[0] ); ?><?php sraik_i( 'arrow-up-right', 12, 2 ); ?></a>
            <?php endforeach; ?>
          </div>
        </div>
      </nav>
      <div class="fq-help">
        <p class="fq-help-t"><?php echo esc_html( $sb['card']['title'] ); ?></p>
        <p class="fq-help-p"><?php echo esc_html( $sb['card']['text'] ); ?></p>
        <a class="fq-help-a" href="<?php echo esc_url( sraik_url( $sb['card']['href'] ) ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $sb['card']['link'] ); ?><?php sraik_i( 'arrow-up-right', 14, 2 ); ?></a>
      </div>
    </aside>

    <div class="fq-topics">
      <?php foreach ( $groups as $i => $g ) : ?>
      <section class="fq-topic" id="<?php echo esc_attr( $g['slug'] ); ?>" aria-labelledby="<?php echo esc_attr( $g['slug'] . '-h' ); ?>">
        <div class="fq-kick">
          <span class="fq-kick-n">§<?php echo (int) ( $i + 1 ); ?></span>
          <span class="fq-kick-s"><?php echo esc_html( $g['slug'] ); ?></span>
          <span class="fq-kick-rule" aria-hidden="true"></span>
          <span class="fq-kick-c"><?php echo esc_html( count( $g['items'] ) . ' ' . $c['unit'] ); ?></span>
        </div>
        <div class="fq-topic-h">
          <span class="gloss fq-gloss" aria-hidden="true"><?php sraik_i( $g['icon'], 16, 2 ); ?></span>
          <h2 class="t-h4b" id="<?php echo esc_attr( $g['slug'] . '-h' ); ?>"><?php echo esc_html( $g['title'] ); ?></h2>
        </div>
        <div class="faq-list fq-list" data-acc>
          <?php echo sraik_tpl_faq_list( $g['items'], 0 ); // phpcs:ignore ?>
        </div>
      </section>
      <?php endforeach; ?>
    </div>
  </div>
</section>
