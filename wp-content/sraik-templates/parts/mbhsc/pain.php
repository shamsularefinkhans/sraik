<?php
/**
 * mbhsc/pain.php — "Is this your story?": four glossy note cards.
 *
 * $s = content/mbhsc.php ['pain']   cards: array( icon, text )
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="sec" id="pain">
  <div class="sec-in">
    <?php echo sraik_sh( array( 'eyebrow' => $s['eyebrow'], 'icon' => 'circle-alert', 'title' => $s['title'], 'sub' => $s['sub'] ) ); // phpcs:ignore ?>
    <div class="mb-notes">
      <?php foreach ( $s['cards'] as $i => $card ) : ?>
      <article class="card mb-note" data-appear style="--ad:<?php echo esc_attr( ( $i % 2 ) * 0.08 ); ?>s">
        <span class="gloss mb-note-ic" aria-hidden="true"><?php sraik_i( $card[0], 18, 1.9 ); ?></span>
        <p><?php sraik_t( $card[1] ); ?></p>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
