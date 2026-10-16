<?php
/**
 * about/contact.php — the closing card ("Open application" in the
 * template): reach Shams on WhatsApp, plus the company's registration.
 *
 * $s = content/about.php ['contact']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="sec" id="contact">
  <div class="sec-in ab-sec">
    <div class="ab-open" data-appear>
      <div class="ab-open-glow" aria-hidden="true"></div>
      <div class="ab-open-copy">
        <p class="ab-kicker"><?php echo esc_html( $s['kicker'] ); ?></p>
        <h2 class="t-h4b"><?php echo esc_html( $s['title'] ); ?></h2>
        <p class="ab-open-p"><?php echo esc_html( $s['text'] ); ?></p>
        <ul class="ab-tags ab-open-facts">
          <?php foreach ( $s['facts'] as $f ) : ?>
          <li class="ab-tag"><?php sraik_i( $f[0], 12, 2 ); ?><?php echo esc_html( $f[1] ); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="ab-open-act">
        <?php echo sraik_btn( $s['button'][0], sraik_url( $s['button'][1] ), 'dark' ); // phpcs:ignore ?>
      </div>
    </div>
  </div>
</section>
