<?php
/**
 * features/caps.php — "Core capabilities": the five-card bento. The
 * template's illustrations are pictures of code; they are rebuilt here in
 * HTML/CSS (styles: features.css → "bento visuals") so they carry the
 * five MATACE tools instead.
 *
 * Layout: wide + narrow, then three narrow (template order).
 *
 * $s = content/features.php ['caps']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$k = $s['cards'];

/* Glossy round satellite: lucide name or 'svg:<brand>'. */
$sat = function ( $ic, $cls ) {
	$svg = 0 === strpos( $ic, 'svg:' ) ? sraik_social_svg( substr( $ic, 4 ) ) : sraik_icon( $ic, 18, 1.9 );
	return '<span class="fv-sat ' . esc_attr( $cls ) . '">' . $svg . '</span>';
};
?>
<section class="sec" id="capabilities">
  <div class="sec-in fcaps">
    <?php echo sraik_sh( array( 'eyebrow' => $s['eyebrow'], 'title' => $s['title'], 'sub' => $s['sub'] ) ); // phpcs:ignore ?>
    <div class="fbento">
      <?php foreach ( $k as $i => $card ) : $ill = $card['ill']; ?>
      <article class="fcard<?php echo 0 === $i ? ' fcard--wide' : ''; ?>" data-appear style="--ad:<?php echo esc_attr( ( $i % 3 ) * 0.06 ); ?>s">
        <div class="fv fv--<?php echo (int) $i + 1; ?>" aria-hidden="true">
          <?php if ( 0 === $i ) : ?>
          <span class="fv1-line"></span>
          <span class="fv1-in">
            <span class="fv1-pill"><span><?php echo esc_html( $ill['prompt'] ); ?></span><span class="fv1-go"><?php sraik_i( 'arrow-up', 15, 2 ); ?></span></span>
            <span class="fv1-chips"><?php foreach ( $ill['chips'] as $ch ) : ?><span class="fv-tag"><?php echo esc_html( $ch ); ?></span><?php endforeach; ?></span>
          </span>
          <span class="fv-orb fv1-orb"><span class="orb-ring"><i class="orb-dot orb-dot--l"></i><i class="orb-dot orb-dot--r"></i></span><span class="orb-core"><?php sraik_i( 'sparkles', 22, 1.9 ); ?></span></span>
          <span class="fv-win fv1-out">
            <small><?php echo esc_html( $ill['file'] ); ?><b><?php echo esc_html( $ill['count'] ); ?></b></small>
            <i class="t w70"></i><i class="w55"></i><i class="t w80"></i><i class="w45"></i><i class="t w60"></i>
          </span>
          <?php elseif ( 1 === $i ) : ?>
          <span class="fv-ring fv-ring--a"></span><span class="fv-ring fv-ring--b"></span>
          <?php echo $sat( $ill['icons'][0], 'fv2-t' ) . $sat( $ill['icons'][1], 'fv2-r' ) . $sat( $ill['icons'][2], 'fv2-b' ) . $sat( $ill['icons'][3], 'fv2-l' ); // phpcs:ignore ?>
          <span class="fv2-key"><span><?php echo esc_html( $ill['key'] ); ?></span></span>
          <?php elseif ( 2 === $i ) : ?>
          <span class="fv-ring fv3-halo"></span>
          <span class="fv-orb fv3-orb"><span class="orb-ring"></span><span class="orb-core"><?php sraik_i( 'check', 22, 2.2 ); ?></span></span>
          <span class="fv3-stem"><i></i><b></b></span>
          <span class="fv3-rows">
            <?php foreach ( $ill['rows'] as $r ) : ?>
            <span class="fv3-row"><span class="dot"></span><span class="fv3-l"><?php echo esc_html( $r[0] ); ?></span><span class="fv3-r"><?php echo esc_html( $r[1] ); ?></span></span>
            <?php endforeach; ?>
          </span>
          <?php elseif ( 3 === $i ) : ?>
          <span class="fv-win fv4-term">
            <span class="fv4-dots"><i></i><i></i><i></i></span>
            <span class="fv4-cmd">$ <?php echo esc_html( $ill['cmd'] ); ?></span>
            <span class="fv4-ok">✓ <?php echo esc_html( $ill['done'] ); ?></span>
            <span class="fv4-cur"></span>
          </span>
          <span class="fv-orb fv4-orb"><span class="orb-ring"></span><span class="orb-core"><?php sraik_i( 'list-checks', 18, 1.9 ); ?></span></span>
          <span class="status-chip fv4-chip"><span class="dot"></span><?php echo esc_html( $ill['chip'] ); ?></span>
          <?php else : ?>
          <span class="fv-ring fv-ring--a"></span><span class="fv-ring fv-ring--b"></span>
          <?php foreach ( $ill['icons'] as $j => $ic ) { echo $sat( $ic, 'fv5-s fv5-s--' . $j ); } // phpcs:ignore ?>
          <span class="fv5-core"><span class="orb-ring"></span><span class="fv5-in"><b><?php echo esc_html( $ill['value'] ); ?></b><small><?php echo esc_html( $ill['label'] ); ?></small></span></span>
          <?php endif; ?>
        </div>
        <div class="fcard-body">
          <h3 class="t-h5"><?php sraik_t( $card['title'] ); ?></h3>
          <p><?php sraik_t( $card['text'] ); ?></p>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
