<?php
/**
 * about/hero.php — eyebrow, headline, mission line, two buttons, then the
 * three-photo collage (short / tall / short frames, as in the template).
 * Phones show only the tall middle frame.
 *
 * $h = content/about.php ['hero']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="hero ab-hero" aria-labelledby="ab-title">
  <?php sraik_hero_bg( false ); ?>
  <div class="ab-hero-in">
    <?php echo sraik_eyebrow( $h['eyebrow'] ); // phpcs:ignore ?>
    <h1 class="t-display ab-title" id="ab-title" data-appear style="--ad:.1s"><?php sraik_t( $h['title'] ); ?></h1>
    <p class="ab-sub" data-appear style="--ad:.2s"><?php sraik_t( $h['sub'] ); ?></p>
    <div class="btn-row ab-btns" data-appear style="--ad:.3s">
      <?php echo sraik_btn( $h['primary'][0], $h['primary'][1], 'lime', 'arrow-right' ); // phpcs:ignore ?>
      <?php echo sraik_btn( $h['secondary'][0], $h['secondary'][1], 'dark' ); // phpcs:ignore ?>
    </div>
  </div>
</section>

<section class="sec" aria-label="<?php echo esc_attr( 'SRAIK in pictures' ); ?>">
  <div class="sec-in ab-sec">
    <div class="ab-photos" data-appear style="--ay:24px;--ad:.35s">
      <?php
      foreach ( $h['photos'] as $i => $p ) :
		/* The tall middle frame is the LCP image (preloaded by head.php). */
		$lcp = 1 === $i;
		?>
      <figure class="ab-ph ab-ph--<?php echo (int) $i; ?>">
        <img src="<?php echo esc_url( $p[0] ); ?>" alt="<?php echo esc_attr( $p[1] ); ?>" width="<?php echo (int) $p[2]; ?>" height="<?php echo (int) $p[3]; ?>" decoding="async"<?php echo $lcp ? ' fetchpriority="high"' : ' loading="lazy"'; ?>>
      </figure>
      <?php endforeach; ?>
    </div>
  </div>
</section>
