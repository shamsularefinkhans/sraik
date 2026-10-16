<?php
/**
 * components.php — markup helpers for the pieces every page repeats:
 * brand, eyebrow pill, buttons, section heading, CTA block, social icons.
 *
 * Each returns a string (sraik_*) or echoes it (the same name without
 * the "get_" prefix where both exist). Copy passed in is run through
 * sraik_kses(), so <span class="hl"> highlights and <br> work everywhere.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** The SRAIK bolt (the mark from the logo), sized by CSS. */
function sraik_bolt_svg( $fill = 'currentColor' ) {
	return '<svg viewBox="0 0 64 75" fill="' . esc_attr( $fill ) . '" aria-hidden="true"><polygon points="1.74 74.69 63.3 28.99 33.73 29.2 61.9 1 4.34 38.29 36.11 37.85 1.74 74.69"/></svg>';
}

/** Full SRAIK wordmark logo (bolt + letters). */
function sraik_logo_svg( $class = '' ) {
	return '<svg class="' . esc_attr( $class ) . '" viewBox="0 0 1289.82 347.79" fill="currentColor" role="img" aria-label="SRAIK"><polygon points="1183.53 164.58 1219.2 195.08 1287.77 252.63 1233.36 252.76 1155.55 186.13 1077.51 246.47 1077.41 81.61 1116.16 81.56 1116.29 173.63 1233.19 81.53 1289.82 81.75 1183.53 164.58"/><rect x="891.38" y="147.75" width="171.28" height="39.18" transform="translate(809.45 1144.32) rotate(-89.99)"/><polygon points="757.05 140.84 673.74 252.59 628.22 252.37 677.71 186.12 757.38 80.23 810.28 150.99 886.04 252.4 839.52 252.64 757.05 140.84"/><path d="M441.43,189.92l-57.66-.05-.1,62.72-37.48.03.05-95.75,160.98-.06c5.95,0,12.88-2.4,16.16-6.92,5.76-7.92,5.46-19.58.85-27.78-3.33-5.91-9.64-7.08-16.11-8.26l-149.15-.03-30.2-33.17,184.44.06c22.07.42,41.57,6.38,48.27,28.14,5.29,17.16,5.19,35.81-.02,52.97-4.44,14.65-16.14,23.6-30.83,26.45-11.84,1.74-22.93,1.56-36.18,1.86l74.62,62.23-53.72.31-48.96-41.75-24.95-21Z"/><polygon points="0 347.79 290.6 132.09 151.02 133.11 283.96 0 12.3 176 162.26 173.89 0 347.79"/></svg>';
}

/** Brand lockup used by the nav and the footer: lime mark + name. */
function sraik_brand( $tag = 'a' ) {
	$open = 'a' === $tag ? '<a class="brand" href="' . esc_url( home_url( '/' ) ) . '" aria-label="SRAIK — home">' : '<div class="brand">';
	echo $open . '<span class="brand-mark">' . sraik_bolt_svg() . '</span><span class="brand-name">SRAIK</span>' . ( 'a' === $tag ? '</a>' : '</div>' ); // phpcs:ignore WordPress.Security.EscapeOutput
}

/** Eyebrow pill: icon + uppercase label. */
function sraik_eyebrow( $text, $icon = 'sparkles', $extra = '' ) {
	if ( '' === (string) $text ) {
		return '';
	}
	return '<span class="eyebrow' . ( $extra ? ' ' . esc_attr( $extra ) : '' ) . '">' . ( $icon ? sraik_icon( $icon, 14, 2 ) : '' ) . '<span>' . sraik_kses( $text ) . '</span></span>';
}

/**
 * Button.
 *   $variant: lime | dark | white | ghost  (+ ' sq' for the 8px-radius pricing shape)
 *   $icon:    lucide name shown after the label ('arrow-right', 'play' …) or ''
 */
function sraik_btn( $label, $href, $variant = 'lime', $icon = '', $attrs = '' ) {
	$classes = 'btn';
	foreach ( preg_split( '/\s+/', trim( $variant ) ) as $v ) {
		$classes .= ' btn--' . sanitize_html_class( $v );
	}
	$url  = sraik_href( $href );
	$ico  = $icon ? sraik_icon( $icon, 16, 2, 'arrow-right' === $icon ? 'ico-arrow' : '' ) : '';
	$attr = sraik_link_attrs( $url ) . ( $attrs ? ' ' . $attrs : '' );
	return '<a class="' . esc_attr( $classes ) . '" href="' . esc_url( $url ) . '"' . $attr . '><span>' . sraik_kses( $label ) . '</span>' . $ico . '</a>';
}

/**
 * Section heading: eyebrow, title, optional sub-copy.
 *   $o = array( 'eyebrow', 'icon', 'title', 'sub', 'align' => center|left, 'tag' => h2, 'cls' => t-h2 )
 */
function sraik_sh( $o ) {
	$o     = wp_parse_args( $o, array( 'eyebrow' => '', 'icon' => 'sparkles', 'title' => '', 'sub' => '', 'align' => 'center', 'tag' => 'h2', 'cls' => 't-h2', 'extra' => '' ) );
	$tag   = tag_escape( $o['tag'] );
	$html  = '<div class="sh' . ( 'left' === $o['align'] ? ' sh--left' : '' ) . ( $o['extra'] ? ' ' . esc_attr( $o['extra'] ) : '' ) . '" data-appear>';
	$html .= sraik_eyebrow( $o['eyebrow'], $o['icon'] );
	$html .= '<' . $tag . ' class="' . esc_attr( $o['cls'] ) . '">' . sraik_kses( $o['title'] ) . '</' . $tag . '>';
	if ( $o['sub'] ) {
		$html .= '<p class="sh-sub">' . sraik_kses( $o['sub'] ) . '</p>';
	}
	return $html . '</div>';
}

/** Filled brand icons for the footer (the template uses solid glyphs). */
function sraik_social_svg( $name ) {
	$p = array(
		'facebook'  => '<path d="M24 12.07C24 5.41 18.63 0 12 0S0 5.4 0 12.07C0 18.1 4.39 23.1 10.13 24v-8.44H7.08v-3.49h3.04V9.41c0-3.02 1.8-4.7 4.54-4.7 1.31 0 2.68.24 2.68.24v2.97h-1.5c-1.5 0-1.96.93-1.96 1.89v2.26h3.32l-.53 3.5h-2.8V24C19.62 23.1 24 18.1 24 12.07"/>',
		'instagram' => '<path d="M12 2.16c3.2 0 3.58.01 4.85.07 3.25.15 4.77 1.69 4.92 4.92.06 1.27.07 1.65.07 4.85s-.01 3.58-.07 4.85c-.15 3.23-1.66 4.77-4.92 4.92-1.27.06-1.64.07-4.85.07s-3.58-.01-4.85-.07c-3.26-.15-4.77-1.7-4.92-4.92-.06-1.27-.07-1.64-.07-4.85s.01-3.58.07-4.85C2.38 3.92 3.9 2.38 7.15 2.23 8.42 2.17 8.8 2.16 12 2.16zM12 0C8.74 0 8.33.01 7.05.07 2.7.27.27 2.69.07 7.05.01 8.33 0 8.74 0 12s.01 3.67.07 4.95c.2 4.36 2.62 6.78 6.98 6.98C8.33 23.99 8.74 24 12 24s3.67-.01 4.95-.07c4.35-.2 6.78-2.62 6.98-6.98.06-1.28.07-1.69.07-4.95s-.01-3.67-.07-4.95c-.2-4.35-2.62-6.78-6.98-6.98C15.67.01 15.26 0 12 0zm0 5.84a6.16 6.16 0 1 0 0 12.32 6.16 6.16 0 0 0 0-12.32zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.4-11.85a1.44 1.44 0 1 0 0 2.88 1.44 1.44 0 0 0 0-2.88z"/>',
		'youtube'   => '<path d="M23.5 6.19a3.02 3.02 0 0 0-2.12-2.14C19.5 3.55 12 3.55 12 3.55s-7.5 0-9.38.5A3.02 3.02 0 0 0 .5 6.19C0 8.07 0 12 0 12s0 3.93.5 5.81a3.02 3.02 0 0 0 2.12 2.14c1.88.5 9.38.5 9.38.5s7.5 0 9.38-.5a3.02 3.02 0 0 0 2.12-2.14C24 15.93 24 12 24 12s0-3.93-.5-5.81zM9.55 15.57V8.43L15.82 12l-6.27 3.57z"/>',
		'linkedin'  => '<path d="M20.45 20.45h-3.56v-5.57c0-1.33-.02-3.04-1.85-3.04-1.85 0-2.14 1.45-2.14 2.94v5.67H9.35V9h3.41v1.56h.05c.48-.9 1.64-1.85 3.37-1.85 3.6 0 4.27 2.37 4.27 5.46v6.28zM5.34 7.43a2.06 2.06 0 1 1 0-4.13 2.06 2.06 0 0 1 0 4.13zM7.12 20.45H3.56V9h3.56v11.45zM22.22 0H1.77C.79 0 0 .77 0 1.73v20.54C0 23.23.79 24 1.77 24h20.45c.98 0 1.78-.77 1.78-1.73V1.73C24 .77 23.2 0 22.22 0z"/>',
		'whatsapp'  => '<path d="M17.47 14.38c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.16-.17.2-.35.22-.64.07-.3-.15-1.26-.46-2.39-1.47-.88-.79-1.48-1.76-1.65-2.06-.17-.3-.02-.46.13-.6.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.67-1.61-.92-2.2-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48s1.06 2.88 1.21 3.07c.15.2 2.1 3.2 5.08 4.49.71.31 1.26.49 1.69.63.71.22 1.36.19 1.87.12.57-.09 1.76-.72 2.01-1.41.25-.7.25-1.29.17-1.41-.07-.13-.27-.2-.57-.35M12.05 21.79h-.01a9.87 9.87 0 0 1-5.03-1.38l-.36-.21-3.74.98 1-3.65-.24-.37a9.86 9.86 0 0 1-1.51-5.26c0-5.45 4.44-9.88 9.89-9.88 2.64 0 5.12 1.03 6.99 2.9a9.82 9.82 0 0 1 2.89 6.99c0 5.45-4.44 9.88-9.88 9.88m8.41-18.3A11.81 11.81 0 0 0 12.05 0C5.5 0 .16 5.34.16 11.89c0 2.1.55 4.14 1.59 5.95L.06 24l6.3-1.65a11.88 11.88 0 0 0 5.68 1.45h.01c6.55 0 11.89-5.34 11.89-11.89 0-3.18-1.24-6.16-3.48-8.41"/>',
		'mail'      => '<path d="M1.5 4.5h21a1.5 1.5 0 0 1 1.5 1.5v12a1.5 1.5 0 0 1-1.5 1.5h-21A1.5 1.5 0 0 1 0 18V6a1.5 1.5 0 0 1 1.5-1.5zm.86 1.8L12 13.2l9.64-6.9z"/>',
	);
	return isset( $p[ $name ] ) ? '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">' . $p[ $name ] . '</svg>' : '';
}

/** Social icon row (footer, about, mentor card). */
function sraik_socials() {
	$items = array(
		'facebook'  => array( sraik_url( 'facebook' ), 'Facebook' ),
		'instagram' => array( sraik_url( 'instagram' ), 'Instagram' ),
		'whatsapp'  => array( sraik_url( 'whatsapp' ), 'WhatsApp' ),
		'linkedin'  => array( sraik_url( 'linkedin' ), 'LinkedIn' ),
		'youtube'   => array( sraik_url( 'youtube' ), 'YouTube' ),
	);
	$out = '<div class="socials">';
	foreach ( $items as $k => $it ) {
		$out .= '<a href="' . esc_url( $it[0] ) . '" target="_blank" rel="noopener noreferrer" aria-label="' . esc_attr( $it[1] ) . '">' . sraik_social_svg( $k ) . '</a>';
	}
	return $out . '</div>';
}

/** Hero backdrop: aurora canvas + fade + glows (identical on every page hero). */
function sraik_hero_bg( $edges = true ) {
	echo '<div class="hero-bg" aria-hidden="true"><canvas data-aurora></canvas><div class="fade"></div><div class="spot"></div>';
	if ( $edges ) {
		echo '<div class="edge edge--l"></div><div class="edge edge--r"></div>';
	}
	echo '</div>';
}

/** Number with Bengali digits when the copy is Bengali. */
function sraik_num( $n, $bn = true ) {
	return $bn ? sraik_bn( $n ) : (string) $n;
}
