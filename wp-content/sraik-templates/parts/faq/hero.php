<?php
/**
 * faq/hero.php — eyebrow, headline, real counts, and the "help --topics"
 * terminal whose rows jump to each topic below.
 *
 * $h      = content/faq-page.php ['hero']
 * $groups = FAQ groups (non-empty)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$total = 0;
foreach ( $groups as $g ) {
	$total += count( $g['items'] );
}
$t = $h['term'];
?>
<section class="hero fq-hero" aria-labelledby="fq-title">
  <?php sraik_hero_bg( false ); ?>
  <div class="fq-hero-in">
    <div class="fq-copy">
      <?php echo sraik_eyebrow( $h['eyebrow'] ); // phpcs:ignore ?>
      <h1 class="t-display" id="fq-title" data-appear style="--ad:.1s"><?php sraik_t( $h['title'] ); ?></h1>
      <p class="fq-sub" data-appear style="--ad:.2s"><?php sraik_t( $h['sub'] ); ?></p>
      <p class="fq-meta" data-appear style="--ad:.25s"><?php echo esc_html( sprintf( $h['meta'], $total, count( $groups ) ) ); ?></p>
    </div>

    <div class="fq-term" data-appear style="--ad:.3s">
      <div class="fq-term-bar">
        <span class="fq-term-dots" aria-hidden="true"><i></i><i></i><i></i></span>
        <span class="fq-term-title"><?php echo esc_html( $t['title'] ); ?></span>
      </div>
      <div class="fq-term-body">
        <p class="fq-term-cmd"><span aria-hidden="true">$</span><span><?php echo esc_html( $t['cmd'] ); ?></span></p>
        <p class="fq-term-l"><?php echo esc_html( $t['label'] ); ?></p>
        <ul class="fq-term-list">
          <?php foreach ( $groups as $g ) : ?>
          <li>
            <a href="#<?php echo esc_attr( $g['slug'] ); ?>">
              <span class="fq-term-name"><?php sraik_i( $g['icon'], 14, 2 ); ?><span><?php echo esc_html( $g['slug'] ); ?></span></span>
              <span class="fq-term-n"><span><?php echo esc_html( count( $g['items'] ) . ' ' . $t['unit'] ); ?></span><?php sraik_i( 'arrow-right', 14, 2 ); ?></span>
            </a>
          </li>
          <?php endforeach; ?>
        </ul>
        <p class="fq-term-foot"><?php echo esc_html( $t['foot'] ); ?></p>
      </div>
    </div>
  </div>
</section>
