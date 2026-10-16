<?php
/**
 * features/hero.php — eyebrow, headline, two buttons and the row of
 * pillar chips (the template's Generate / Understand / … links).
 *
 * $h = content/features.php ['hero']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="hero hero--feat" aria-labelledby="feat-title">
  <?php sraik_hero_bg( false ); ?>
  <div class="hero-in fh">
    <div data-appear style="--ay:12px"><?php echo sraik_eyebrow( $h['eyebrow'] ); // phpcs:ignore ?></div>
    <h1 class="t-display fh-title" id="feat-title" data-appear style="--ad:.15s"><?php sraik_t( $h['title'] ); ?></h1>
    <p class="fh-sub" data-appear style="--ad:.25s"><?php sraik_t( $h['sub'] ); ?></p>
    <div class="fh-btns" data-appear style="--ad:.35s">
      <?php echo sraik_btn( $h['primary'][0], $h['primary'][1], 'lime', 'arrow-right' ); // phpcs:ignore ?>
      <?php echo sraik_btn( $h['secondary'][0], $h['secondary'][1], 'dark' ); // phpcs:ignore ?>
    </div>
    <nav class="fh-chips" aria-label="<?php echo esc_attr( 'ট্রেনিংয়ের পিলার' ); ?>" data-appear style="--ad:.45s">
      <?php foreach ( $h['chips'] as $ch ) : ?>
      <a class="fpill" href="<?php echo esc_url( sraik_href( $ch[2] ) ); ?>"><?php sraik_i( $ch[0], 14, 2 ); ?><span><?php echo esc_html( $ch[1] ); ?></span></a>
      <?php endforeach; ?>
    </nav>
  </div>
</section>
