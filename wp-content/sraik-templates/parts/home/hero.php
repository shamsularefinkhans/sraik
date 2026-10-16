<?php
/**
 * home/hero.php — badge (live countdown), headline, CTAs and the product
 * window. The window is the template's hero mockup rebuilt in HTML: the
 * left panel carries the program, the right panel the intro video
 * (SRAIK Player mounts on click).
 *
 * $h = content/home.php ['hero']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$win = $h['window'];
?>
<section class="hero hero--home" aria-labelledby="hero-title">
  <?php sraik_hero_bg(); ?>
  <div class="hero-in">
    <div class="hh">
      <a class="hbadge" href="<?php echo esc_url( sraik_href( $h['badge_href'] ) ); ?>" data-appear style="--ay:12px">
        <span class="hbadge-tag"><?php echo esc_html( $h['badge_tag'] ); ?></span>
        <?php if ( ! empty( $h['deadline'] ) ) : ?>
        <span class="hbadge-text" data-countdown="<?php echo esc_attr( $h['deadline'] ); ?>" data-over="<?php echo esc_attr( 'এনরোলমেন্ট চলছে — এখনই যুক্ত হও' ); ?>">
          <span data-cd-text><span class="cd-l">অফার শেষ হতে বাকি</span> <b data-d>০০</b>দি <b data-h>০০</b>ঘ <b data-m>০০</b>মি <b data-s>০০</b>সে</span>
        </span>
        <?php else : ?>
        <span class="hbadge-text"><?php echo esc_html( $h['badge_text'] ); ?></span>
        <?php endif; ?>
        <?php sraik_i( 'arrow-right', 14 ); ?>
      </a>
      <h1 class="t-display hero-title" id="hero-title" data-appear style="--ad:.15s"><?php sraik_t( $h['title'] ); ?></h1>
      <p class="hero-sub" data-appear style="--ad:.25s"><?php sraik_t( $h['sub'] ); ?></p>
      <div class="btn-row hero-btns" data-appear style="--ad:.35s">
        <?php echo sraik_btn( $h['primary'][0], $h['primary'][1], 'lime', 'arrow-right' ); // phpcs:ignore ?>
        <?php echo sraik_btn( $h['secondary'][0], $h['secondary'][1], 'dark', 'play', 'data-play-intro' ); // phpcs:ignore ?>
      </div>
      <p class="hero-note" data-appear style="--ad:.35s"><?php echo esc_html( $h['note'] ); ?></p>
    </div>

    <div class="hwin-wrap" id="intro" data-appear style="--ay:28px;--ad:.45s">
      <div class="hwin-glow" aria-hidden="true"></div>
      <div class="hwin">
        <div class="hwin-bar">
          <span class="hwin-dots" aria-hidden="true"><i></i><i></i><i></i></span>
          <span class="hwin-tab is-active"><?php sraik_i( 'video', 15, 1.8 ); ?><?php echo esc_html( $win['tab_1'] ); ?></span>
          <span class="hwin-tab"><?php sraik_i( 'file-text', 15, 1.8 ); ?><?php echo esc_html( $win['tab_2'] ); ?></span>
          <span class="hwin-status"><span class="dot"></span><?php echo esc_html( $win['status'] ); ?></span>
        </div>
        <div class="hwin-body">
          <div class="hwin-side">
            <p class="hwin-label"><?php echo esc_html( $win['prompt_l'] ); ?></p>
            <div class="hwin-prompt">
              <p><?php echo esc_html( $win['prompt'] ); ?></p>
              <div class="hwin-tools" aria-hidden="true">
                <?php sraik_i( 'plus', 18, 1.6 ); ?>
                <?php sraik_i( 'target', 18, 1.6 ); ?>
                <span class="hwin-toggle"><b><?php echo esc_html( $win['toggle'][0] ); ?></b><span><?php echo esc_html( $win['toggle'][1] ); ?></span></span>
                <?php sraik_i( 'mic', 18, 1.6 ); ?>
              </div>
            </div>
            <p class="hwin-label"><?php echo esc_html( $win['stack_l'] ); ?></p>
            <div class="hwin-chips">
              <?php foreach ( $win['stack'] as $s ) : ?><span><?php echo esc_html( $s ); ?></span><?php endforeach; ?>
            </div>
            <p class="hwin-label"><?php echo esc_html( $win['checks_l'] ); ?></p>
            <ul class="hwin-checks">
              <?php foreach ( $win['checks'] as $i => $s ) : ?>
              <li<?php echo 2 === $i ? ' class="is-dim"' : ''; ?>><span class="hwin-ck"><?php sraik_i( 'check', 12, 2.4 ); ?></span><?php echo esc_html( $s ); ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
          <div class="hwin-main">
            <div class="hwin-video" data-sraik-video="<?php echo esc_attr( $win['video'] ); ?>" data-start="<?php echo (int) $win['start']; ?>" data-ratio="16:9">
              <img src="<?php echo esc_url( $win['poster'] ); ?>" alt="<?php echo esc_attr( $win['caption'] ); ?>" width="1280" height="720" fetchpriority="high" decoding="async">
              <button class="hwin-play" type="button" aria-label="<?php echo esc_attr( 'ভিডিও চালাও: ' . $win['caption'] ); ?>"><?php sraik_i( 'play', 22, 2 ); ?></button>
            </div>
            <div class="hwin-cap">
              <span class="hwin-ln" aria-hidden="true">▶</span>
              <span><?php echo esc_html( $win['caption'] ); ?></span>
              <a href="<?php echo esc_url( $win['yt_link'] ); ?>" target="_blank" rel="noopener noreferrer">YouTube <?php sraik_i( 'arrow-up-right', 13 ); ?></a>
            </div>
          </div>
        </div>
      </div>
      <div class="hwin-fade" aria-hidden="true"></div>
    </div>
  </div>
</section>
