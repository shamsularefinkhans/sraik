<?php
/**
 * mbhsc/program.php — "What is Mission: Bypass HSC?" in the template's
 * split layout: copy left, the mentor's portrait with the live page's
 * editorial quote right.
 *
 * $s = content/mbhsc.php ['program']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="sec sec--split" id="program">
  <div class="split-glow" aria-hidden="true"></div>
  <div class="sec-in split">
    <div class="split-copy" data-appear>
      <?php echo sraik_eyebrow( $s['eyebrow'], 'sparkles' ); // phpcs:ignore ?>
      <h2 class="t-h2"><?php sraik_t( $s['title'] ); ?></h2>
      <div class="mb-paras">
        <?php foreach ( $s['paras'] as $p ) : ?><p class="split-text"><?php sraik_t( $p ); ?></p><?php endforeach; ?>
      </div>
      <a class="split-link" href="<?php echo esc_url( sraik_href( $s['link'][1] ) ); ?>"><?php echo esc_html( $s['link'][0] ); ?> →</a>
    </div>
    <figure class="split-vis card mb-quote" data-appear style="--ad:.1s">
      <img src="<?php echo esc_url( $s['image'] ); ?>" alt="<?php echo esc_attr( $s['cite'] ); ?>" width="1440" height="972" loading="lazy" decoding="async">
      <figcaption class="mb-quote-cap">
        <span class="gloss mb-quote-ic" aria-hidden="true"><?php sraik_i( 'quote', 16, 2 ); ?></span>
        <blockquote class="t-title-s"><?php sraik_t( $s['quote'] ); ?></blockquote>
        <span class="mb-quote-by"><b><?php echo esc_html( $s['cite'] ); ?></b><span><?php echo esc_html( $s['role'] ); ?></span></span>
      </figcaption>
    </figure>
  </div>
</section>
