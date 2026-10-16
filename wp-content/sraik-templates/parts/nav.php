<?php
/**
 * nav.php — fixed top bar + the mobile / tablet drop-down menu.
 * Links come from inc/config.php ('nav', 'nav_mobile').
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sraik_cta_label = 'যুক্ত হও!';
$sraik_cta_href  = '/#pricing';
?>
<header class="nav" id="nav">
  <div class="nav-in">
    <?php sraik_brand(); ?>
    <nav class="nav-links" aria-label="Main">
      <?php foreach ( sraik_config( 'nav' ) as $sraik_l ) : ?>
      <a href="<?php echo esc_url( sraik_href( $sraik_l['href'] ) ); ?>"><?php echo esc_html( $sraik_l['label'] ); ?></a>
      <?php endforeach; ?>
    </nav>
    <div class="nav-right">
      <a class="nav-login" href="<?php echo esc_url( sraik_url( 'dashboard' ) ); ?>" target="_blank" rel="noopener noreferrer">Log In</a>
      <?php echo sraik_btn( $sraik_cta_label, $sraik_cta_href, 'dark' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
      <button class="nav-burger" type="button" aria-label="Open menu" aria-expanded="false" aria-controls="mnav">
        <?php sraik_i( 'menu', 18, 2, 'ico-menu' ); ?>
        <?php sraik_i( 'x', 18, 2, 'ico-x' ); ?>
      </button>
    </div>
  </div>
</header>
<div class="mnav" id="mnav" aria-label="Menu">
  <?php foreach ( sraik_config( 'nav_mobile' ) as $sraik_l ) : $sraik_u = sraik_href( $sraik_l['href'] ); ?>
  <a class="mnav-row" href="<?php echo esc_url( $sraik_u ); ?>"<?php echo sraik_link_attrs( $sraik_u ); // phpcs:ignore ?>><span><?php echo esc_html( $sraik_l['label'] ); ?></span><?php sraik_i( 'chevron-right', 16 ); ?></a>
  <?php endforeach; ?>
  <?php echo sraik_btn( $sraik_cta_label, $sraik_cta_href, 'lime', 'arrow-right' ); // phpcs:ignore ?>
</div>
