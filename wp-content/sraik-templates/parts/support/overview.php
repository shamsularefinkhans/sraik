<?php
/**
 * support/overview.php — breadcrumb, the "Help Center" hero card with the
 * orbit mark, and four quick-jump cards.
 *
 * $s = content/support.php ['overview']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="hc-sec hc-ov" id="overview" aria-labelledby="hc-title">
  <p class="hc-crumbs" data-appear><span><?php echo esc_html( $s['crumbs'][0] ); ?></span><?php sraik_i( 'chevron-right', 12, 2 ); ?><span class="is-here"><?php echo esc_html( $s['crumbs'][1] ); ?></span></p>
  <div class="card hc-hero" data-appear style="--ad:.08s">
    <div class="hc-hero-glow" aria-hidden="true"></div>
    <h1 class="t-h2 hc-hero-t" id="hc-title"><?php sraik_t( $s['title'] ); ?></h1>
    <p class="hc-hero-p"><?php sraik_t( $s['sub'] ); ?></p>
    <div class="btn-row hc-hero-btns">
      <?php echo sraik_btn( $s['primary'][0], $s['primary'][1], 'lime', 'arrow-right' ); // phpcs:ignore ?>
      <?php echo sraik_btn( $s['secondary'][0], $s['secondary'][1], 'dark' ); // phpcs:ignore ?>
    </div>
    <span class="hc-orb" aria-hidden="true">
      <i class="hc-orb-o"></i><i class="hc-orb-m"></i>
      <span class="hc-orb-r"><span class="hc-orb-c"><?php sraik_i( $s['icon'], 22, 1.9 ); ?></span></span>
      <b class="hc-orb-d hc-orb-d--t"></b><b class="hc-orb-d hc-orb-d--b"></b>
    </span>
  </div>
  <div class="hc-quick">
    <?php
    foreach ( $s['cards'] as $i => $q ) :
		$u = sraik_hc_href( $q[3] );
		?>
    <a class="hc-q" href="<?php echo esc_url( $u ); ?>"<?php echo sraik_link_attrs( $u ); // phpcs:ignore ?> data-appear style="--ad:<?php echo esc_attr( 0.1 + $i * 0.05 ); ?>s">
      <span class="hc-q-top"><span class="gloss hc-gloss" aria-hidden="true"><?php sraik_i( $q[0], 16, 2 ); ?></span><?php sraik_i( 'arrow-up-right', 16, 2 ); ?></span>
      <span class="hc-q-txt"><span class="hc-t6"><?php echo esc_html( $q[1] ); ?></span><span class="hc-q-p"><?php echo esc_html( $q[2] ); ?></span></span>
    </a>
    <?php endforeach; ?>
  </div>
</section>
