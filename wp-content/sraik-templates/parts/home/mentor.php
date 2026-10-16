<?php
/**
 * home/mentor.php — text left, hub illustration right ("Integrations"
 * in the template): the channels Shams mentors through.
 *
 * $s = content/home.php ['mentor']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="sec sec--split" id="mentorship">
  <div class="split-glow" aria-hidden="true"></div>
  <div class="sec-in split">
    <div class="split-copy" data-appear>
      <?php echo sraik_eyebrow( $s['eyebrow'], 'sparkles' ); // phpcs:ignore ?>
      <h2 class="t-h2"><?php sraik_t( $s['title'] ); ?></h2>
      <p class="split-text"><?php sraik_t( $s['text'] ); ?></p>
      <a class="split-link" href="<?php echo esc_url( sraik_href( $s['link'][1] ) ); ?>"><?php echo esc_html( $s['link'][0] ); ?> →</a>
    </div>
    <div class="split-vis" data-appear style="--ad:.1s">
      <?php echo sraik_hub( array( 'svg:whatsapp', 'video', 'svg:facebook', 'svg:youtube' ), $s['badge'], 'headphones' ); // phpcs:ignore ?>
    </div>
  </div>
</section>
