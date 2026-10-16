<?php
/**
 * support/payment.php — payment methods as the template's SDK cards (icon,
 * name, gateway, a mono line with the path to pay), then the SSLCOMMERZ
 * badge.
 *
 * $s = content/support.php ['payment']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="hc-sec" id="payment" aria-labelledby="hc-payment">
  <?php sraik_part( 'support/head.php', array( 's' => $s, 'hid' => 'hc-payment' ) ); ?>
  <div class="hc-pay">
    <div class="hc-sdks">
      <?php foreach ( $s['methods'] as $i => $m ) : ?>
      <div class="hc-sdk" data-appear style="--ad:<?php echo esc_attr( $i * 0.06 ); ?>s">
        <div class="hc-sdk-h">
          <span class="hc-sdk-n"><span class="hc-sdk-i" aria-hidden="true"><?php sraik_i( $m[0], 18, 2 ); ?></span><h3 class="hc-t6"><?php echo esc_html( $m[1] ); ?></h3></span>
          <span class="hc-sdk-v"><?php echo esc_html( $m[2] ); ?></span>
        </div>
        <p class="hc-sdk-cmd"><span aria-hidden="true">$</span><code><?php echo esc_html( $m[3] ); ?></code></p>
      </div>
      <?php endforeach; ?>
    </div>
    <a class="hc-ssl" href="<?php echo esc_url( sraik_url( 'sslcommerz' ) ); ?>" target="_blank" rel="noopener noreferrer" data-appear>
      <img src="<?php echo esc_url( sraik_img( $s['badge'][0] ) ); ?>" alt="<?php echo esc_attr( $s['badge'][1] ); ?>" width="1440" height="161" loading="lazy" decoding="async">
    </a>
  </div>
</section>
