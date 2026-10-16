<?php
/**
 * features/live.php — #live: the three special live sessions as the
 * template's step cards (illustration, numbered head, title, text).
 *
 * $s = content/features.php ['live']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="sec fsec-flush" id="live">
  <div class="sec-in">
    <?php echo sraik_sh( array( 'eyebrow' => $s['eyebrow'], 'icon' => 'video', 'title' => $s['title'], 'sub' => $s['sub'] ) ); // phpcs:ignore ?>
    <div class="steps flive">
      <?php foreach ( $s['sessions'] as $i => $ls ) : ?>
      <article class="card step" data-appear style="--ad:<?php echo esc_attr( $i * 0.08 ); ?>s">
        <div class="step-vis flive-vis" aria-hidden="true">
          <?php echo sraik_orb( $ls['orb'] ); // phpcs:ignore ?>
          <span class="status-chip sv-chip"><span class="dot"></span><?php echo esc_html( $ls['chip'] ); ?></span>
        </div>
        <div class="step-body">
          <div class="step-head">
            <span class="gloss step-ico"><?php sraik_i( $ls['icon'], 16, 1.9 ); ?></span>
            <span class="step-n">LIVE <?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
            <span class="step-rule"></span>
          </div>
          <h3 class="t-h5"><?php sraik_t( $ls['title'] ); ?></h3>
          <p><?php sraik_t( $ls['text'] ); ?></p>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
    <p class="fnote" data-appear><span class="dot dot--lime"></span><?php echo esc_html( $s['note'] ); ?></p>
  </div>
</section>
