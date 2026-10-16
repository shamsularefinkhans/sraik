<?php
/**
 * features/deep.php — three alternating deep-dive rows (copy | panel,
 * panel | copy, copy | panel). Each panel frames a real screenshot from
 * the live site inside the template's illustration plate.
 *
 * $rows = content/features.php ['deep']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="sec" aria-label="<?php echo esc_attr( 'MATACE 3.0 — বিস্তারিত' ); ?>">
  <div class="sec-in fdd">
    <?php foreach ( $rows as $i => $r ) : $p = $r['panel']; ?>
    <div class="fdd-row<?php echo 1 === $i % 2 ? ' fdd-row--flip' : ''; ?>" id="<?php echo esc_attr( $r['id'] ); ?>">
      <div class="fdd-copy" data-appear>
        <div class="fdd-head">
          <span class="gloss fdd-ico"><?php sraik_i( $r['icon'], 16, 1.9 ); ?></span>
          <span class="fdd-n"><?php echo esc_html( $r['label'] ); ?></span>
          <span class="fdd-rule"></span>
        </div>
        <h2 class="t-h2"><?php sraik_t( $r['title'] ); ?></h2>
        <p class="fdd-text"><?php sraik_t( $r['text'] ); ?></p>
        <ul class="fdd-checks">
          <?php foreach ( $r['checks'] as $ck ) : ?>
          <li><span class="fdd-ck"><?php sraik_i( 'check', 12, 2.2 ); ?></span><span><?php echo esc_html( $ck ); ?></span></li>
          <?php endforeach; ?>
        </ul>
        <a class="fdd-link" href="<?php echo esc_url( sraik_href( $r['link'][1] ) ); ?>"><span><?php echo esc_html( $r['link'][0] ); ?></span><?php sraik_i( 'arrow-up-right', 16, 1.8 ); ?></a>
      </div>
      <div class="fdd-panel" data-appear style="--ad:.1s">
        <div class="fdd-plate">
          <span class="fdd-track fdd-track--o" aria-hidden="true"></span>
          <span class="fdd-track fdd-track--i" aria-hidden="true"></span>
          <span class="status-chip fdd-chip" aria-hidden="true"><span class="dot"></span><?php echo esc_html( $p['chip'] ); ?></span>
          <figure class="fdd-shot">
            <span class="fdd-bar" aria-hidden="true"><i></i><i></i><i></i></span>
            <img src="<?php echo esc_url( $p['img'] ); ?>" alt="<?php echo esc_attr( $p['alt'] ); ?>" width="<?php echo (int) $p['w']; ?>" height="<?php echo (int) $p['h']; ?>" loading="lazy" decoding="async">
          </figure>
          <span class="fv-tag fdd-tag fdd-tag--a" aria-hidden="true"><?php sraik_i( 'file-text', 13, 1.8 ); ?><?php echo esc_html( $p['tags'][0] ); ?></span>
          <span class="fv-tag fdd-tag fdd-tag--b" aria-hidden="true"><?php sraik_i( 'file-text', 13, 1.8 ); ?><?php echo esc_html( $p['tags'][1] ); ?></span>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>
