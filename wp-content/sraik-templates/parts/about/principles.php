<?php
/**
 * about/principles.php — three numbered principles ("How we work").
 *
 * $s = content/about.php ['principles']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="sec" id="how-we-work">
  <div class="sec-in ab-sec">
    <?php echo sraik_sh( array( 'eyebrow' => $s['eyebrow'], 'title' => $s['title'], 'sub' => $s['sub'] ) ); // phpcs:ignore ?>
    <ol class="ab-princ">
      <?php foreach ( $s['items'] as $i => $it ) : ?>
      <li class="ab-pr" data-appear style="--ad:<?php echo esc_attr( $i * 0.08 ); ?>s">
        <div class="ab-head">
          <span class="gloss ab-gloss" aria-hidden="true"><?php sraik_i( $it[0], 16, 2 ); ?></span>
          <span class="ab-num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
          <span class="ab-rule" aria-hidden="true"></span>
        </div>
        <h3 class="t-h5"><?php echo esc_html( $it[1] ); ?></h3>
        <p><?php echo esc_html( $it[2] ); ?></p>
      </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
