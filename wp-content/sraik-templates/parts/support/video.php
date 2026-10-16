<?php
/**
 * support/video.php — the enrolment + payment walkthrough (SRAIK Player
 * mounts on click). /faq/ links here as /support/#payment-video.
 *
 * $s = content/support.php ['video']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="hc-sec" id="payment-video" aria-labelledby="hc-video">
  <?php sraik_part( 'support/head.php', array( 's' => $s, 'hid' => 'hc-video' ) ); ?>
  <figure class="hc-vid" data-appear>
    <div class="hc-vid-box" data-sraik-video="<?php echo esc_attr( $s['id'] ); ?>" data-start="<?php echo (int) $s['start']; ?>" data-ratio="16:9">
      <img src="<?php echo esc_url( $s['poster'] ); ?>" alt="<?php echo esc_attr( $s['caption'] ); ?>" width="1280" height="720" loading="lazy" decoding="async">
      <button class="hc-play" type="button" aria-label="<?php echo esc_attr( 'ভিডিও চালাও: ' . $s['caption'] ); ?>"><?php sraik_i( 'play', 22, 2 ); ?></button>
    </div>
    <figcaption class="hc-vid-cap">
      <span><?php echo esc_html( $s['caption'] ); ?></span>
      <a href="<?php echo esc_url( $s['yt'] ); ?>" target="_blank" rel="noopener noreferrer">YouTube <?php sraik_i( 'arrow-up-right', 13, 2 ); ?></a>
    </figcaption>
  </figure>
</section>
