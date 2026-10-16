<?php
/**
 * home/steps.php — three step cards, each with its own illustration
 * ("Three Steps to Working Code" in the template).
 *
 * $s = content/home.php ['steps']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$it = $s['items'];
?>
<section class="sec" id="join">
  <div class="sec-in">
    <?php echo sraik_sh( array( 'eyebrow' => $s['eyebrow'], 'title' => $s['title'], 'sub' => $s['sub'] ) ); // phpcs:ignore ?>
    <div class="steps">
      <?php foreach ( $it as $i => $step ) : ?>
      <article class="card step" data-appear style="--ad:<?php echo esc_attr( $i * 0.08 ); ?>s">
        <div class="step-vis step-vis--<?php echo (int) $i + 1; ?>" aria-hidden="true">
          <?php if ( 0 === $i ) : ?>
          <span class="sv1-stem"><i></i><b></b></span>
          <span class="sv1-input"><span><?php echo esc_html( $step['ill']['input'] ); ?></span><span class="sv1-go"><?php sraik_i( 'arrow-up', 16, 2 ); ?></span></span>
          <span class="sv1-chips"><?php foreach ( $step['ill']['chips'] as $ch ) : ?><span><?php echo esc_html( $ch ); ?></span><?php endforeach; ?></span>
          <?php elseif ( 1 === $i ) : ?>
          <span class="sv2-line"></span>
          <span class="sv2-sat sv2-sat--l"><?php sraik_i( 'smartphone', 15, 1.9 ); ?></span>
          <span class="sv2-ring"><svg viewBox="0 0 132 132"><circle cx="66" cy="66" r="58" fill="none" stroke="rgba(255,255,255,.06)" stroke-width="9"/><circle cx="66" cy="66" r="58" fill="none" stroke="#5fd4bf" stroke-width="9" stroke-linecap="round" stroke-dasharray="<?php echo esc_attr( round( 2 * M_PI * 58 * $step['ill']['pct'] / 100, 1 ) ); ?> 400" transform="rotate(-90 66 66)"/></svg><i class="orb-dot orb-dot--l"></i></span>
          <span class="sv2-core"><?php sraik_i( 'sparkles', 26, 1.8 ); ?></span>
          <span class="sv2-sat sv2-sat--r"><?php sraik_i( 'credit-card', 15, 1.9 ); ?></span>
          <span class="status-chip sv-chip"><span class="dot"></span><?php echo esc_html( sraik_bn( $step['ill']['pct'] ) . '% · ' . $step['ill']['chip'] ); ?></span>
          <?php else : ?>
          <span class="sv3-tag"><?php echo esc_html( $step['ill']['tag'] ); ?></span>
          <span class="sv3-line"></span>
          <span class="sv3-pt sv3-pt--1"></span><span class="sv3-pt sv3-pt--2"></span>
          <span class="sv3-orb"><span class="orb-ring"><i class="orb-dot orb-dot--l"></i><i class="orb-dot orb-dot--r"></i></span><span class="orb-core"><?php sraik_i( 'check', 22, 2 ); ?></span></span>
          <span class="status-chip sv-chip sv-chip--r"><span class="dot"></span><?php echo esc_html( $step['ill']['chip'] ); ?></span>
          <?php endif; ?>
        </div>
        <div class="step-body">
          <div class="step-head">
            <span class="gloss step-ico"><?php sraik_i( $step['icon'], 16, 1.9 ); ?></span>
            <span class="step-n">STEP <?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
            <span class="step-rule"></span>
          </div>
          <h3 class="t-h5"><?php sraik_t( $step['title'] ); ?></h3>
          <p><?php sraik_t( $step['text'] ); ?></p>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
