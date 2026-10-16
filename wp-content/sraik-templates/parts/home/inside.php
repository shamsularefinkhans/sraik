<?php
/**
 * home/inside.php — six glossy cards with an orbit visual ("Use cases").
 *
 * $s = content/home.php ['inside']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="sec" id="inside">
  <div class="sec-in">
    <?php echo sraik_sh( array( 'eyebrow' => $s['eyebrow'], 'title' => $s['title'], 'sub' => $s['sub'] ) ); // phpcs:ignore ?>
    <div class="ucards">
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
