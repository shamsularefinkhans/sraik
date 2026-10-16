<?php
/**
 * cta.php — the closing call-to-action card used above every footer.
 *
 * Optional $vars: eyebrow, title, sub, primary (array label,href), secondary
 * (array label,href), checks (array of strings). Defaults are the MATACE copy.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cta = wp_parse_args(
	isset( $cta ) ? $cta : array(),
	array(
		'eyebrow'   => 'Ready to Play?',
		'title'     => 'টাইম বেশি নাই, শুরুটা আজই হোক।',
		'sub'       => 'নিজের ভালো নিজেকেই বুঝতে হবে। ৮,৭৫৬+ লার্নারের সাথে যুক্ত হও আর আজই তোমার রোডম্যাপ শুরু করো। ফি আমানিল্লাহ!',
		'primary'   => array( 'যুক্ত হও!', '/#pricing' ),
		'secondary' => array( 'WhatsApp-এ কথা বলো', sraik_url( 'whatsapp' ) ),
		'checks'    => array( 'লাইফটাইম এক্সেস', 'এককালীন পেমেন্ট', 'ইনস্ট্যান্ট এক্সেস' ),
	)
);
?>
<section class="cta-wrap" aria-label="<?php echo esc_attr( wp_strip_all_tags( $cta['eyebrow'] ) ); ?>">
  <div class="cta" data-appear>
    <div class="cta-edge cta-edge--l" aria-hidden="true"></div>
    <div class="cta-edge cta-edge--r" aria-hidden="true"></div>
    <div class="cta-top" aria-hidden="true"></div>
    <div class="cta-beam" aria-hidden="true"></div>
    <span class="cta-pin cta-pin--l" aria-hidden="true"><i></i><b></b></span>
    <span class="cta-pin cta-pin--r" aria-hidden="true"><i></i><b></b></span>
    <div class="cta-mark" aria-hidden="true"><div class="cta-mark-in"><?php echo sraik_bolt_svg(); // phpcs:ignore ?></div></div>
    <?php echo sraik_eyebrow( $cta['eyebrow'] ); // phpcs:ignore ?>
    <h2 class="t-h2 cta-title"><?php sraik_t( $cta['title'] ); ?></h2>
    <p class="cta-sub"><?php sraik_t( $cta['sub'] ); ?></p>
    <div class="cta-btns">
      <?php echo sraik_btn( $cta['primary'][0], $cta['primary'][1], 'lime', 'arrow-right' ); // phpcs:ignore ?>
      <?php if ( ! empty( $cta['secondary'] ) ) : ?>
      <?php echo sraik_btn( $cta['secondary'][0], $cta['secondary'][1], 'dark' ); // phpcs:ignore ?>
      <?php endif; ?>
    </div>
    <?php if ( ! empty( $cta['checks'] ) ) : ?>
    <div class="cta-checks">
      <?php foreach ( $cta['checks'] as $c ) : ?><span><?php echo esc_html( $c ); ?></span><?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</section>
