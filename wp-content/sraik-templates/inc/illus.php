<?php
/**
 * illus.php — the template's illustrations, rebuilt in HTML/CSS so their
 * labels can carry SRAIK copy (styles: assets/css/illus.css).
 *
 *   sraik_orb( $icon, $opts )          glossy core + ring + side dots (the
 *                                      template's most used card visual)
 *   sraik_orbit_subjects( $icons )     stadium track with six satellites
 *   sraik_gauge( $value, $label )      teal progress ring with a readout
 *   sraik_diff( $left, $right )        two panels around a merge orb
 *   sraik_shield( $icon )              core with two side satellites
 *   sraik_hub( $icons, $badge )        large hub with a row of satellites
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** The single-icon orbit (used by feature cards on many pages). */
function sraik_orb( $icon, $opts = array() ) {
	$o = wp_parse_args( $opts, array( 'size' => '', 'cls' => '' ) );
	ob_start();
	?>
	<span class="orb<?php echo $o['size'] ? ' orb--' . esc_attr( $o['size'] ) : ''; ?><?php echo $o['cls'] ? ' ' . esc_attr( $o['cls'] ) : ''; ?>" aria-hidden="true">
	  <span class="orb-line"></span>
	  <span class="orb-halo"></span>
	  <span class="orb-ring"><i class="orb-dot orb-dot--l"></i><i class="orb-dot orb-dot--r"></i></span>
	  <span class="orb-core"><?php sraik_i( $icon, 22, 1.9 ); ?></span>
	</span>
	<?php
	return ob_get_clean();
}

/** Stadium track with three satellites each side and a centre core. */
function sraik_orbit_subjects( $icons ) {
	ob_start();
	?>
	<span class="osub" aria-hidden="true">
	  <span class="osub-track osub-track--o"></span>
	  <span class="osub-track osub-track--i"></span>
	  <span class="osub-core"><span class="osub-ring"><i class="orb-dot orb-dot--l"></i><i class="orb-dot orb-dot--r"></i></span><span class="osub-in"><?php echo sraik_bolt_svg(); // phpcs:ignore ?></span></span>
	  <?php foreach ( array_slice( $icons, 0, 6 ) as $i => $ic ) : ?>
	  <span class="osub-sat osub-sat--<?php echo (int) $i; ?>"><?php sraik_i( $ic, 18, 1.9 ); ?></span>
	  <?php endforeach; ?>
	</span>
	<?php
	return ob_get_clean();
}

/** Teal progress ring with a value and a mono caption. */
function sraik_gauge( $value, $label, $pct = 72 ) {
	$r   = 70;
	$len = 2 * M_PI * $r;
	ob_start();
	?>
	<span class="gauge" aria-hidden="true">
	  <span class="gauge-halo"></span>
	  <svg class="gauge-svg" viewBox="0 0 168 168">
	    <defs><linearGradient id="gg" x1="0" y1="1" x2="1" y2="0"><stop offset="0" stop-color="#3fb8a4"/><stop offset="1" stop-color="#6ee7d2"/></linearGradient></defs>
	    <circle cx="84" cy="84" r="<?php echo (int) $r; ?>" fill="none" stroke="rgba(255,255,255,.06)" stroke-width="12"/>
	    <circle class="gauge-arc" cx="84" cy="84" r="<?php echo (int) $r; ?>" fill="none" stroke="url(#gg)" stroke-width="12" stroke-linecap="round" stroke-dasharray="<?php echo esc_attr( round( $len * $pct / 100, 2 ) . ' ' . round( $len, 2 ) ); ?>" transform="rotate(-210 84 84)"/>
	  </svg>
	  <span class="gauge-knob" style="--a:<?php echo esc_attr( -210 + 360 * $pct / 100 ); ?>deg"></span>
	  <span class="gauge-core"><b><?php echo esc_html( $value ); ?></b><small><?php echo esc_html( $label ); ?></small></span>
	</span>
	<?php
	return ob_get_clean();
}

/** Two panels (before / after) around a merge orb. */
function sraik_diff( $left, $right ) {
	ob_start();
	?>
	<span class="diff" aria-hidden="true">
	  <span class="diff-halo"></span>
	  <span class="diff-line"></span>
	  <span class="diff-card diff-card--a"><small><?php echo esc_html( $left ); ?></small><i class="w60"></i><i class="r w40"></i><i class="w70"></i><i class="r w30"></i></span>
	  <span class="diff-orb"><span class="orb-ring"><i class="orb-dot orb-dot--l"></i><i class="orb-dot orb-dot--r"></i></span><span class="orb-core"><?php sraik_i( 'git-pull-request', 20, 1.9 ); ?></span></span>
	  <span class="diff-card diff-card--b"><small><?php echo esc_html( $right ); ?></small><i class="t w70"></i><i class="t w55"></i><i class="w65"></i><i class="t w45"></i></span>
	</span>
	<?php
	return ob_get_clean();
}

/** Core with a satellite on each side (lock / key in the template). */
function sraik_shield( $icon, $left = 'lock', $right = 'key-round' ) {
	ob_start();
	?>
	<span class="shield" aria-hidden="true">
	  <span class="orb-line"></span>
	  <span class="shield-halo"></span>
	  <span class="shield-sat shield-sat--l"><?php sraik_i( $left, 16, 1.9 ); ?></span>
	  <span class="orb-ring"><i class="orb-dot orb-dot--l"></i><i class="orb-dot orb-dot--r"></i></span>
	  <span class="orb-core"><?php sraik_i( $icon, 24, 1.9 ); ?></span>
	  <span class="shield-sat shield-sat--r"><?php sraik_i( $right, 16, 1.9 ); ?></span>
	</span>
	<?php
	return ob_get_clean();
}

/** Large hub: concentric rings, a row of satellites, a badge underneath. */
function sraik_hub( $icons, $badge, $core = 'headphones' ) {
	ob_start();
	?>
	<span class="hub" aria-hidden="true">
	  <span class="hub-rings"><i></i><i></i><i></i></span>
	  <span class="hub-vline"></span>
	  <span class="hub-row">
	    <?php foreach ( $icons as $i => $ic ) : ?>
	      <?php if ( 2 === $i ) : ?>
	    <span class="hub-core"><span class="hub-ring"><i class="orb-dot orb-dot--t"></i><i class="orb-dot orb-dot--b"></i></span><span class="hub-in"><?php sraik_i( $core, 28, 1.8 ); ?></span></span>
	      <?php endif; ?>
	    <span class="hub-sat"><?php echo 0 === strpos( $ic, 'svg:' ) ? sraik_social_svg( substr( $ic, 4 ) ) : sraik_icon( $ic, 22, 1.8 ); // phpcs:ignore ?></span>
	    <?php endforeach; ?>
	  </span>
	  <span class="status-chip hub-badge"><span class="dot"></span><?php echo esc_html( $badge ); ?></span>
	</span>
	<?php
	return ob_get_clean();
}
