<?php
/**
 * helpers.php — small utilities shared by every template.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Inline a file from assets/ directly into the page.
 *
 * CSS rides inside the document (LiteSpeed's optimizer mangles our
 * stylesheets when it processes them as separate files). %ASSETS% is
 * rewritten to the real assets URL, because an inlined url() would otherwise
 * resolve against the PAGE path instead of assets/.
 */
function sraik_inline( $file ) {
	$path = SRAIK_TPL_DIR . '/assets/' . ltrim( $file, '/' );
	if ( file_exists( $path ) ) {
		echo str_replace( '%ASSETS%', SRAIK_TPL_URL . '/assets', file_get_contents( $path ) ); // phpcs:ignore WordPress.Security.EscapeOutput
	}
}

/** Versioned URL for an asset that is linked rather than inlined. */
function sraik_asset( $file ) {
	$path = SRAIK_TPL_DIR . '/assets/' . ltrim( $file, '/' );
	$ver  = file_exists( $path ) ? filemtime( $path ) : SRAIK_TPL_VER;
	return SRAIK_TPL_URL . '/assets/' . ltrim( $file, '/' ) . '?v=' . $ver;
}

/** Plain (unversioned) URL for an image in assets/img/. */
function sraik_img( $file ) {
	return SRAIK_TPL_URL . '/assets/img/' . ltrim( $file, '/' );
}

/**
 * Include a part from parts/.
 *
 * An include inside a function inherits the FUNCTION's scope, not the
 * caller's: pass variables through $vars.
 */
function sraik_part( $name, $vars = array() ) {
	$path = SRAIK_TPL_DIR . '/parts/' . ltrim( $name, '/' );
	if ( file_exists( $path ) ) {
		if ( ! empty( $vars ) && is_array( $vars ) ) {
			extract( $vars, EXTR_SKIP ); // phpcs:ignore WordPress.PHP.DontExtract
		}
		include $path;
	}
}

/**
 * Register (or read back) the extra stylesheets for the current view.
 * Templates call this BEFORE head.php: sraik_page_css( array( 'css/home.css' ) );
 */
function sraik_page_css( $files = null ) {
	static $registered = array();
	if ( null !== $files ) {
		$registered = array_values( array_filter( (array) $files ) );
	}
	return $registered;
}

/** Same idea for page scripts (printed deferred at the end of <body>). */
function sraik_page_js( $files = null ) {
	static $registered = array();
	if ( null !== $files ) {
		$registered = array_values( array_filter( (array) $files ) );
	}
	return $registered;
}

/**
 * Turn a config href into a real URL.
 *   '/features/'  → home_url( '/features/' )
 *   '/#pricing'   → '#pricing' on the front page, home_url( '/#pricing' ) elsewhere
 *   'https://…'   → unchanged
 */
function sraik_href( $href ) {
	if ( '' === $href || null === $href ) {
		return '#';
	}
	if ( preg_match( '#^(https?:|mailto:|tel:)#', $href ) ) {
		return $href;
	}
	if ( 0 === strpos( $href, '#' ) ) {
		return $href;
	}
	if ( 0 === strpos( $href, '/#' ) && function_exists( 'sraik_view' ) && 'home' === sraik_view() ) {
		return substr( $href, 1 );
	}
	return home_url( $href );
}

/** Is this external (opens in a new tab)? */
function sraik_is_external( $href ) {
	return (bool) preg_match( '#^https?://#', $href ) && false === strpos( $href, wp_parse_url( home_url(), PHP_URL_HOST ) );
}

/** target/rel attributes for a link. */
function sraik_link_attrs( $href ) {
	return sraik_is_external( $href ) ? ' target="_blank" rel="noopener noreferrer"' : '';
}

/** Title / description / image for the current view, from config. */
function sraik_meta( $key, $fallback = '' ) {
	$view = function_exists( 'sraik_view' ) ? sraik_view() : '';

	if ( 'single' === $view ) {
		$id = get_queried_object_id();
		if ( 'title' === $key ) {
			return wp_strip_all_tags( get_the_title( $id ) ) . ' — SRAIK';
		}
		if ( 'desc' === $key ) {
			return sraik_post_excerpt( $id, 30 );
		}
		if ( 'image' === $key ) {
			$img = sraik_post_image( $id, 'large' );
			return $img ? $img['src'] : $fallback;
		}
	}
	if ( 'archive' === $view && 'title' === $key ) {
		return wp_strip_all_tags( get_the_archive_title() ) . ' — SRAIK Blog';
	}

	$meta = sraik_config( 'meta' );
	if ( isset( $meta[ $view ][ $key ] ) ) {
		return $meta[ $view ][ $key ];
	}
	return $fallback;
}

/** Bengali digits for a number or numeric string. */
function sraik_bn( $n ) {
	return strtr( (string) $n, array( '0' => '০', '1' => '১', '2' => '২', '3' => '৩', '4' => '৪', '5' => '৫', '6' => '৬', '7' => '৭', '8' => '৮', '9' => '৯' ) );
}

/**
 * Allow a small set of inline tags in copy strings (content arrays hold
 * <span class="hl">, <br>, <strong>, <a>, <em>).
 */
function sraik_kses( $html ) {
	return wp_kses(
		$html,
		array(
			'span'   => array( 'class' => true ),
			'br'     => array( 'class' => true ),
			'strong' => array(),
			'b'      => array(),
			'em'     => array(),
			'code'   => array(),
			'a'      => array( 'href' => true, 'target' => true, 'rel' => true, 'class' => true ),
		)
	);
}

/** Echo copy through sraik_kses(). */
function sraik_t( $html ) {
	echo sraik_kses( $html ); // phpcs:ignore WordPress.Security.EscapeOutput
}
