<?php
/**
 * mbhsc/outcomes.php — "Who you'll be after the training": the front
 * page's orb cards (parts/home/inside.php) in a two-column grid.
 *
 * $s = content/mbhsc.php ['outcomes']   cards: array( icon, title, text )
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="sec" id="outcomes">
  <div class="sec-in">
    <?php echo sraik_sh( array( 'eyebrow' => $s['eyebrow'], 'title' => $s['title'], 'sub' => $s['sub'] ) ); // phpcs:ignore ?>
    <div class="ucards mb-ucards">
      <?php foreach ( $s['cards'] as $i => $card ) : ?>
      <article class="card ucard" data-appear style="--ad:<?php echo esc_attr( ( $i % 2 ) * 0.08 ); ?>s">
        <div class="ucard-vis"><?php echo sraik_orb( $card[0] ); // phpcs:ignore ?></div>
        <h3 class="t-h5"><?php sraik_t( $card[1] ); ?></h3>
        <p><?php sraik_t( $card[2] ); ?></p>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
