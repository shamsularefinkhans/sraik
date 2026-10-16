<?php
/**
 * support/help.php — four route cards ("Still have questions?").
 *
 * $s = content/support.php ['help']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="hc-sec" id="help" aria-labelledby="hc-help">
  <?php sraik_part( 'support/head.php', array( 's' => $s, 'hid' => 'hc-help' ) ); ?>
  <div class="hc-routes">
    <?php
    foreach ( $s['routes'] as $i => $r ) :
		$u = sraik_hc_href( $r[3] );
		?>
    <a class="hc-route" href="<?php echo esc_url( $u ); ?>"<?php echo sraik_link_attrs( $u ); // phpcs:ignore ?> data-appear style="--ad:<?php echo esc_attr( ( $i % 2 ) * 0.06 ); ?>s">
      <span class="gloss hc-route-i" aria-hidden="true"><?php sraik_i( $r[0], 18, 2 ); ?></span>
      <span class="hc-route-txt"><span class="hc-route-t"><?php echo esc_html( $r[1] ); ?></span><span class="hc-p"><?php echo esc_html( $r[2] ); ?></span></span>
      <?php sraik_i( 'chevron-right', 18, 2, 'hc-route-go' ); ?>
    </a>
    <?php endforeach; ?>
  </div>
</section>
