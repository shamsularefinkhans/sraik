<?php
/**
 * mbhsc/pricing.php — the front page's plan cards (parts/home/pricing.php)
 * without the offer / regular toggle: Mission: Bypass HSC has one price per
 * plan. Under the plans, the live page's "watch before you join" checkout
 * walkthrough as a one-item accordion with the SRAIK Player inside.
 *
 * $s = content/mbhsc.php ['pricing']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$v = $s['video'];
?>
<section class="sec" id="pricing">
  <div class="sec-in">
    <?php echo sraik_sh( array( 'eyebrow' => $s['eyebrow'], 'title' => $s['title'], 'sub' => $s['sub'] ) ); // phpcs:ignore ?>
    <div class="pricing">
      <div class="plans mb-plans">
        <?php foreach ( $s['plans'] as $i => $p ) : $pop = ! empty( $p['popular'] ); ?>
        <article class="plan<?php echo $pop ? ' plan--pop' : ''; ?>" data-appear style="--ad:<?php echo esc_attr( $i * 0.06 ); ?>s">
          <div class="plan-top">
            <div class="plan-name"><h3 class="t-h4"><?php echo esc_html( $p['name'] ); ?></h3><?php if ( ! empty( $p['badge'] ) ) : ?><span class="plan-badge<?php echo $pop ? '' : ' mb-badge-dim'; ?>"><?php echo esc_html( $p['badge'] ); ?></span><?php endif; ?></div>
            <div class="plan-price">
              <span class="t-display plan-amt<?php echo preg_match( '/\d|[০-৯]/u', $p['price'] ) ? '' : ' plan-amt--word'; ?>"><?php echo esc_html( $p['price'] ); ?></span>
              <?php if ( ! empty( $p['period'] ) ) : ?>
              <span class="plan-per"><?php foreach ( $p['period'] as $per ) : ?><span><?php echo esc_html( $per ); ?></span><?php endforeach; ?></span>
              <?php endif; ?>
            </div>
            <p class="plan-desc"><?php echo esc_html( $p['desc'] ); ?></p>
          </div>
          <div class="plan-btns">
            <?php $u1 = sraik_href( $p['primary'][1] ); $u2 = sraik_href( $p['second'][1] ); ?>
            <a class="btn btn--sq btn--block <?php echo $pop ? 'btn--lime' : 'btn--white'; ?>" href="<?php echo esc_url( $u1 ); ?>"<?php echo sraik_link_attrs( $u1 ); // phpcs:ignore ?>><?php echo esc_html( $p['primary'][0] ); ?></a>
            <a class="btn btn--sq btn--block <?php echo $pop ? 'btn--ghost' : 'btn--dark'; ?>" href="<?php echo esc_url( $u2 ); ?>"<?php echo sraik_link_attrs( $u2 ); // phpcs:ignore ?>><?php echo esc_html( $p['second'][0] ); ?></a>
          </div>
          <div class="plan-feats">
            <p class="plan-fl">Features</p>
            <p class="plan-fi"><?php echo esc_html( $p['feat_l'] ); ?></p>
            <ul>
              <?php foreach ( $p['features'] as $f ) : ?>
              <li><span class="plan-ck"><?php sraik_i( 'check', 11, 2.6 ); ?></span><span><?php echo esc_html( $f ); ?></span></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </article>
        <?php endforeach; ?>
      </div>

      <div class="card mb-pay" id="pay-video" data-acc data-appear>
        <div data-acc-item>
          <h3 class="mb-mod-h"><button type="button" class="mb-mod-btn" data-acc-btn aria-expanded="false" aria-controls="pay-video-a">
            <span class="gloss mb-mod-ic" aria-hidden="true"><?php sraik_i( 'play', 16, 2 ); ?></span>
            <span class="mb-mod-tx"><span class="mb-mod-meta">Checkout Tutorial</span><span class="mb-mod-title"><?php echo esc_html( $v['title'] ); ?></span></span>
            <span class="faq-ic" aria-hidden="true"><?php sraik_i( 'chevron-down', 14, 2.2 ); ?></span>
          </button></h3>
          <div class="mb-mod-a" id="pay-video-a" data-acc-panel role="region" style="height:0">
            <div class="mb-pay-in">
              <div class="mb-pay-video" data-sraik-video="<?php echo esc_attr( $v['id'] ); ?>" data-start="<?php echo (int) $v['start']; ?>" data-ratio="9:16">
                <img src="<?php echo esc_url( sraik_img( $v['poster'] ) ); ?>" alt="<?php echo esc_attr( $v['title'] ); ?>" width="480" height="360" loading="lazy" decoding="async">
                <button class="hwin-play" type="button" aria-label="<?php echo esc_attr( 'ভিডিও চালাও: ' . $v['title'] ); ?>"><?php sraik_i( 'play', 22, 2 ); ?></button>
              </div>
              <a class="mb-pay-yt" href="<?php echo esc_url( $v['yt_link'] ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $v['yt_text'] ); ?> <?php sraik_i( 'arrow-up-right', 13 ); ?></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
