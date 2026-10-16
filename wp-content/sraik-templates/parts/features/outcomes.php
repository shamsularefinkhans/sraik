<?php
/**
 * features/outcomes.php — six orb cards ("Enterprise-grade by default" in
 * the template): what changes after the training. Same card as the home
 * page's use-case cards.
 *
 * $s = content/features.php ['outcomes']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="sec" id="outcomes">
  <div class="sec-in">
    <?php echo sraik_sh( array( 'eyebrow' => $s['eyebrow'], 'icon' => 'trophy', 'title' => $s['title'], 'sub' => $s['sub'] ) ); // phpcs:ignore ?>
    <div class="ucards fout">
      <?php foreach ( $s['cards'] as $i => $card ) : ?>
      <article class="card ucard" data-appear style="--ad:<?php echo esc_attr( ( $i % 3 ) * 0.06 ); ?>s">
        <div class="ucard-vis"><?php echo sraik_orb( $card[0] ); // phpcs:ignore ?></div>
        <h3 class="t-h5"><?php sraik_t( $card[1] ); ?></h3>
        <p><?php sraik_t( $card[2] ); ?></p>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
