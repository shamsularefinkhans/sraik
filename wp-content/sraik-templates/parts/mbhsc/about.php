<?php
/**
 * mbhsc/about.php — "Meet your mentor": portrait card left, bio right
 * (the template's split section, mirrored).
 *
 * $s = content/mbhsc.php ['about']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="sec sec--split" id="mentor">
  <div class="sec-in split mb-about">
    <figure class="card mb-portrait" data-appear>
      <img src="<?php echo esc_url( $s['image'] ); ?>" alt="<?php echo esc_attr( $s['name'] . ' — ' . $s['role'] ); ?>" width="1000" height="1000" loading="lazy" decoding="async">
      <figcaption class="status-chip mb-portrait-chip"><span class="dot"></span><?php echo esc_html( $s['role'] ); ?></figcaption>
    </figure>
    <div class="split-copy mb-about-copy" data-appear style="--ad:.1s">
      <?php echo sraik_eyebrow( $s['eyebrow'], 'sparkles' ); // phpcs:ignore ?>
      <h2 class="t-h2"><?php sraik_t( $s['title'] ); ?></h2>
      <div class="mb-about-who">
        <h3 class="t-h5"><?php echo esc_html( $s['name'] ); ?></h3>
        <p class="t-mono c-3"><?php echo esc_html( $s['role'] ); ?></p>
      </div>
      <div class="mb-paras">
        <?php foreach ( $s['paras'] as $p ) : ?><p class="split-text"><?php sraik_t( $p ); ?></p><?php endforeach; ?>
      </div>
      <div class="mb-about-foot">
        <a class="split-link" href="<?php echo esc_url( sraik_href( $s['link'][1] ) ); ?>"><?php echo esc_html( $s['link'][0] ); ?> →</a>
        <div class="socials">
          <?php foreach ( $s['socials'] as $so ) : ?>
          <a href="<?php echo esc_url( $so[2] ); ?>" aria-label="<?php echo esc_attr( $so[1] ); ?>"<?php echo sraik_link_attrs( $so[2] ); // phpcs:ignore ?>><?php echo sraik_social_svg( $so[0] ); // phpcs:ignore ?></a>
          <?php endforeach; ?>
        </div>
      </div>
      <img class="mb-sign" src="<?php echo esc_url( $s['signature'] ); ?>" alt="<?php echo esc_attr( $s['name'] . ' — signature' ); ?>" width="538" height="370" loading="lazy" decoding="async">
    </div>
  </div>
</section>
