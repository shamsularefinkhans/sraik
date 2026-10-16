<?php
/**
 * home/love.php — "Wall of love": the WhatsApp screenshot wall.
 *
 * Screenshots are read from assets/wa-proof/ exactly as before (see
 * inc/wa-proof.php): drop files named 001.jpg, 002.jpg … into that folder
 * and they appear here in name order, 6 at a time, with a full-size viewer.
 * assets/js/wap.js drives "আরও দেখুন" and the viewer; this part only
 * dresses it in the template's testimonial-card styling.
 *
 * $s = content/home.php ['love']   Optional: 'set' => sub-folder name.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wap_set = sraik_wap_set( isset( $set ) ? $set : '' );
if ( null === $wap_set ) {
	return;
}
$wap_items = sraik_wap_items( $wap_set );
$wap_total = count( $wap_items );
if ( ! $wap_total ) {
	return; /* no screenshots on this server: no section */
}
$wap_per   = 6;
$wap_shown = min( $wap_per, $wap_total );
$wap_key   = sraik_wap_key( $wap_set );

if ( sraik_wap_once( 'data:' . $wap_key ) ) {
	echo '<script type="application/json" class="wap-data" data-wap-set="' . esc_attr( $wap_key ) . '">'
		. wp_json_encode( $wap_items, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP )
		. '</script>' . "\n";
}
sraik_page_js( array_merge( sraik_page_js(), array( 'js/wap.js' ) ) );
?>
<section class="sec love wap" id="testimonials" data-wap-set="<?php echo esc_attr( $wap_key ); ?>" data-wap-per="<?php echo (int) $wap_per; ?>">
  <div class="love-glow" aria-hidden="true"></div>
  <div class="sec-in">
    <div class="sh" data-appear>
      <?php echo sraik_eyebrow( $s['eyebrow'] ); // phpcs:ignore ?>
      <h2 class="t-h2"><?php sraik_t( $s['title'] ); ?></h2>
      <p class="sh-sub"><?php sraik_t( $s['sub'] ); ?></p>
      <div class="rating">
        <span class="rating-faces" aria-hidden="true">
          <?php for ( $i = 0; $i < min( 4, $wap_total ); $i++ ) : ?>
          <img src="<?php echo esc_url( $wap_items[ $i ][1] ); ?>" alt="" width="32" height="32" loading="lazy" decoding="async">
          <?php endfor; ?>
        </span>
        <span class="rating-stars" aria-hidden="true">★★★★★</span>
        <span class="rating-text"><b><?php echo esc_html( $s['rating'] ); ?></b> <?php echo esc_html( $s['reviews'] ); ?></span>
      </div>
    </div>
    <div class="wap-grid">
      <?php for ( $i = 0; $i < $wap_shown; $i++ ) : $n = sraik_bn( $i + 1 ); ?>
      <button type="button" class="wap-tile" data-i="<?php echo (int) $i; ?>" aria-label="<?php echo esc_attr( 'স্ক্রিনশট ' . $n . ' বড় করে দেখো' ); ?>" data-appear style="--ad:<?php echo esc_attr( ( $i % 3 ) * 0.06 ); ?>s">
        <img src="<?php echo esc_url( $wap_items[ $i ][1] ); ?>" data-full="<?php echo esc_url( $wap_items[ $i ][0] ); ?>" onerror="this.onerror=null;this.src=this.getAttribute('data-full')" alt="<?php echo esc_attr( 'WhatsApp-এ স্টুডেন্টের ফিডব্যাক — স্ক্রিনশট ' . $n ); ?>" width="<?php echo (int) SRAIK_WAP_SIZE; ?>" height="<?php echo (int) SRAIK_WAP_SIZE; ?>" loading="lazy" decoding="async">
      </button>
      <?php endfor; ?>
    </div>
    <?php if ( $wap_total > $wap_shown ) : ?>
    <div class="wap-actions"><button type="button" class="btn btn--dark wap-more"><span><?php echo esc_html( $s['more'] ); ?></span></button></div>
    <?php endif; ?>
  </div>
</section>
