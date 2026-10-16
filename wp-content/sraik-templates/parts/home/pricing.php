<?php
/**
 * home/pricing.php — four plans with the offer / regular price toggle
 * (the template's Monthly / Yearly switch).
 *
 * Plan buttons accept a config URL key ('player', 'pro', 'whatsapp',
 * 'wa_live' — inc/config.php → urls) or a path / full URL.
 *
 * $s = content/home.php ['pricing']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$url = function ( $v ) {
	$known = sraik_config( 'urls' );
	return isset( $known[ $v ] ) ? $known[ $v ] : sraik_href( $v );
};
$keys = array_keys( $s['toggle'] );
?>
<section class="sec" id="pricing">
  <div class="sec-in">
    <?php echo sraik_sh( array( 'eyebrow' => $s['eyebrow'], 'title' => $s['title'], 'sub' => $s['sub'] ) ); // phpcs:ignore ?>
    <div class="pricing" id="pricing-plans">
      <div class="ptoggle" role="tablist" data-tabs="#pricing-plans" data-active="<?php echo esc_attr( $keys[0] ); ?>" data-appear>
        <?php foreach ( $s['toggle'] as $k => $label ) : ?>
        <button type="button" role="tab" data-tab="<?php echo esc_attr( $k ); ?>" class="<?php echo $k === $keys[0] ? 'is-active' : ''; ?>" aria-selected="<?php echo $k === $keys[0] ? 'true' : 'false'; ?>"><?php echo esc_html( $label ); ?></button>
        <?php endforeach; ?>
      </div>
      <div class="plans">
        <?php foreach ( $s['plans'] as $i => $p ) : $pop = ! empty( $p['popular'] ); ?>
        <article class="plan<?php echo $pop ? ' plan--pop' : ''; ?>" data-appear style="--ad:<?php echo esc_attr( $i * 0.06 ); ?>s">
          <div class="plan-top">
            <div class="plan-name"><h3 class="t-h4"><?php echo esc_html( $p['name'] ); ?></h3><?php if ( ! empty( $p['badge'] ) ) : ?><span class="plan-badge"><?php echo esc_html( $p['badge'] ); ?></span><?php endif; ?></div>
            <div class="plan-price">
              <span class="t-display plan-amt<?php echo preg_match( '/\d|[০-৯]/u', $p['price'][ $keys[0] ] ) ? '' : ' plan-amt--word'; ?>" data-price data-price-<?php echo esc_attr( $keys[0] ); ?>="<?php echo esc_attr( $p['price'][ $keys[0] ] ); ?>" data-price-<?php echo esc_attr( $keys[1] ); ?>="<?php echo esc_attr( $p['price'][ $keys[1] ] ); ?>"><?php echo esc_html( $p['price'][ $keys[0] ] ); ?></span>
              <?php if ( ! empty( $p['period'] ) ) : ?>
              <span class="plan-per"><?php foreach ( $p['period'] as $per ) : ?><span><?php echo esc_html( $per ); ?></span><?php endforeach; ?></span>
              <?php endif; ?>
            </div>
            <p class="plan-desc"><?php echo esc_html( $p['desc'] ); ?></p>
          </div>
          <div class="plan-btns">
            <?php $u1 = $url( $p['primary'][1] ); $u2 = $url( $p['second'][1] ); ?>
            <a class="btn btn--sq btn--block <?php echo $pop ? 'btn--lime' : 'btn--white'; ?>" href="<?php echo esc_url( $u1 ); ?>"<?php echo sraik_link_attrs( $u1 ); // phpcs:ignore ?>><?php echo esc_html( $p['primary'][0] ); ?></a>
            <a class="btn btn--sq btn--block <?php echo $pop ? 'btn--ghost' : 'btn--dark'; ?>" href="<?php echo esc_url( $u2 ); ?>"<?php echo sraik_link_attrs( $u2 ); // phpcs:ignore ?>><?php echo esc_html( $p['second'][0] ); ?></a>
          </div>
          <div class="plan-feats">
            <p class="plan-fl">Features</p>
            <p class="plan-fi"><?php echo esc_html( $p['feat_l'] ); ?></p>
            <ul>
              <?php foreach ( $p['features'] as $f ) : ?>
              <li><span class="plan-ck"><?php sraik_i( 'check', 11, 2.6 ); ?></span><span><?php echo esc_html( $f ); ?></span></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
      <?php if ( ! empty( $s['note'] ) ) : ?><p class="pricing-note"><?php echo esc_html( $s['note'] ); ?></p><?php endif; ?>
    </div>
  </div>
</section>
