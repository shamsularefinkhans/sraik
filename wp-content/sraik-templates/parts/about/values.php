<?php
/**
 * about/values.php — six glossy cards with the single-icon orb ("Benefits"
 * in the template): what SRAIK stands for.
 *
 * $s = content/about.php ['values']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="sec" id="values">
  <div class="sec-in ab-sec">
    <?php echo sraik_sh( array( 'eyebrow' => $s['eyebrow'], 'title' => $s['title'], 'sub' => $s['sub'] ) ); // phpcs:ignore ?>
    <div class="ab-values">
      <?php foreach ( $s['items'] as $i => $it ) : ?>
      <article class="card ab-value" data-appear style="--ad:<?php echo esc_attr( ( $i % 3 ) * 0.06 ); ?>s">
        <?php echo sraik_orb( $it[0] ); // phpcs:ignore ?>
        <h3 class="t-h5"><?php echo esc_html( $it[1] ); ?></h3>
        <p><?php echo esc_html( $it[2] ); ?></p>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
