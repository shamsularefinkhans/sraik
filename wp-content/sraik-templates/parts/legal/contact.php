<?php
/**
 * legal/contact.php — "Questions about …?" card: email (primary) and
 * WhatsApp, with the address spelled out underneath.
 *
 * $doc, $ui — see templates/page-legal.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$ct    = $doc['contact'];
$email = sraik_contact( 'email' );
?>
<section class="lg-contact" aria-labelledby="lg-contact-h">
  <div class="lg-contact-in">
    <div class="lg-ccard" data-appear>
      <div class="lg-ccard-glow" aria-hidden="true"></div>
      <div class="lg-ccard-copy">
        <span class="lg-ccard-k"><?php echo esc_html( $ui['contact'] ); ?></span>
        <h2 class="t-h4b" id="lg-contact-h"><?php echo esc_html( $ct['title'] ); ?></h2>
        <p><?php echo esc_html( $ct['text'] ); ?></p>
      </div>
      <div class="lg-ccard-act">
        <div class="lg-ccard-btns">
          <?php echo sraik_btn( $ct['btn'], 'mailto:' . $email, 'lime', 'arrow-right' ); // phpcs:ignore ?>
          <?php echo sraik_btn( $ui['wa'], sraik_url( 'whatsapp' ), 'dark' ); // phpcs:ignore ?>
        </div>
        <span class="lg-ccard-mail"><?php echo esc_html( $email ); ?></span>
      </div>
    </div>
  </div>
</section>
