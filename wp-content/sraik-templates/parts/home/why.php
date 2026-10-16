<?php
/**
 * home/why.php — the four-card bento ("Engineered for Code" in the template).
 * Card order and widths follow the template: wide, narrow / narrow, wide.
 *
 * $s = content/home.php ['why']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$k = $s['cards'];
?>
<section class="sec" id="why">
  <div class="sec-in">
    <?php echo sraik_sh( array( 'eyebrow' => $s['eyebrow'], 'title' => $s['title'], 'sub' => $s['sub'] ) ); // phpcs:ignore ?>
    <div class="bento">
      <article class="card bento-card bento-card--wide" data-appear>
        <?php echo sraik_eyebrow( $k[0]['tag'], $k[0]['icon'] ); // phpcs:ignore ?>
        <div class="bento-copy"><h3 class="t-h5"><?php sraik_t( $k[0]['title'] ); ?></h3><p><?php sraik_t( $k[0]['text'] ); ?></p></div>
        <div class="bento-vis bento-vis--orbit"><?php echo sraik_orbit_subjects( $k[0]['orbit'] ); // phpcs:ignore ?></div>
      </article>
      <article class="card bento-card" data-appear style="--ad:.08s">
        <?php echo sraik_eyebrow( $k[1]['tag'], $k[1]['icon'] ); // phpcs:ignore ?>
        <div class="bento-copy"><h3 class="t-h5"><?php sraik_t( $k[1]['title'] ); ?></h3><p><?php sraik_t( $k[1]['text'] ); ?></p></div>
        <div class="bento-vis bento-vis--gauge"><?php echo sraik_gauge( $k[1]['gauge'][0], $k[1]['gauge'][1] ); // phpcs:ignore ?></div>
        <span class="status-chip"><span class="dot"></span><?php echo esc_html( $k[1]['chip'] ); ?></span>
      </article>
      <article class="card bento-card" data-appear>
        <?php echo sraik_eyebrow( $k[2]['tag'], $k[2]['icon'] ); // phpcs:ignore ?>
        <div class="bento-vis bento-vis--shield"><?php echo sraik_shield( 'wallet', 'lock', 'infinity' ); // phpcs:ignore ?></div>
        <div class="bento-copy"><h3 class="t-h5"><?php sraik_t( $k[2]['title'] ); ?></h3><p><?php sraik_t( $k[2]['text'] ); ?></p></div>
        <div class="bento-chips">
          <?php foreach ( $k[2]['chips'] as $ch ) : ?><span class="chip"><?php sraik_i( $ch[0], 14, 2 ); ?><?php echo esc_html( $ch[1] ); ?></span><?php endforeach; ?>
        </div>
      </article>
      <article class="card bento-card bento-card--wide" data-appear style="--ad:.08s">
        <div class="bento-head">
          <?php echo sraik_eyebrow( $k[3]['tag'], $k[3]['icon'] ); // phpcs:ignore ?>
          <div class="bento-copy"><h3 class="t-h5"><?php sraik_t( $k[3]['title'] ); ?></h3><p><?php sraik_t( $k[3]['text'] ); ?></p></div>
        </div>
        <div class="bento-vis bento-vis--diff"><?php echo sraik_diff( $k[3]['diff'][0], $k[3]['diff'][1] ); // phpcs:ignore ?></div>
      </article>
    </div>
  </div>
</section>
