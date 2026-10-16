<?php
/**
 * wa-proof.php — the WhatsApp screenshot wall ("Real Feedback" section).
 *
 * ── Using it on any landing page ─────────────────────────────────────────
 *
 *   1. Screenshots go in  sraik-templates/assets/wa-proof/
 *      (jpg, jpeg, png or webp). They show in natural filename order —
 *      name them 001.jpg, 002.jpg … to control the order. Nothing else to
 *      edit: the section reads the folder on every uncached page render.
 *
 *      A page that needs its OWN set uses a sub-folder,
 *      assets/wa-proof/<set>/  (lowercase letters, digits, hyphens), and
 *      passes 'set' => '<set>' to both calls below.
 *
 *   2. In the page template, add 'wap.css' to sraik_page_css() so the CSS is
 *      inlined in <head> like every other stylesheet. (If it is forgotten
 *      the part inlines it itself, so nothing breaks.)
 *
 *   3. In the page content:
 *        sraik_part( 'wa-proof.php', array( 'mode' => 'teaser' ) );
 *            first 6; its "আরও দেখুন" scrolls to the full wall and loads there
 *        sraik_part( 'wa-proof.php' );
 *            the full wall; "আরও দেখুন" adds 6 more per click until the folder
 *            runs out, then disappears
 *      Optional keys for either call: 'set', 'per' (default 6), 'id',
 *      'target' (teaser only: id of the full wall), 'eyebrow', 'title',
 *      'sub', 'more'. If a page has no screenshots the section prints nothing.
 *
 *   4. After adding or removing screenshots: LiteSpeed Purge All, then
 *      Cloudflare Purge Everything. The list is part of the cached page.
 *
 * ── Thumbnails ───────────────────────────────────────────────────────────
 *
 * The grid never downloads the full screenshots (600 KB–8 MB each). Each tile
 * gets a 720 px square crop, made once by WordPress's own image editor and
 * kept in uploads/sraik-wap/. A thumbnail that does not exist yet is made on
 * its first request through ?sraik_wap=… (handled below, before any regular
 * plugin loads); after the next purge the page links the static file
 * directly. Every failure path — editor missing, uploads not writable, image
 * too large — falls back to the original screenshot, so a tile can be slow
 * but never broken. Replacing a file under the same name makes a new
 * thumbnail automatically (the name is a hash of filename, size and date).
 *
 * The full-size viewer always opens the original file.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SRAIK_WAP_SIZE', 720 );

/** Normalise a set name. '' means the root folder. Anything unsafe → null. */
function sraik_wap_set( $set ) {
	$set = strtolower( trim( (string) $set ) );
	if ( '' === $set ) {
		return '';
	}
	return preg_match( '/^[a-z0-9-]+$/', $set ) ? $set : null;
}

/** Folder key used in thumbnail paths and data attributes. */
function sraik_wap_key( $set ) {
	return '' === $set ? '_default' : $set;
}

/**
 * The screenshots of a set, in natural filename order.
 * Each entry: name, path, size, mtime.
 */
function sraik_wap_files( $set ) {
	static $cache = array();

	$set = sraik_wap_set( $set );
	if ( null === $set ) {
		return array();
	}
	if ( isset( $cache[ $set ] ) ) {
		return $cache[ $set ];
	}

	$dir   = SRAIK_TPL_DIR . '/assets/wa-proof' . ( '' === $set ? '' : '/' . $set );
	$files = array();

	if ( is_dir( $dir ) ) {
		$names = scandir( $dir );
		foreach ( (array) $names as $n ) {
			if ( '' === $n || '.' === $n[0] ) {
				continue;
			}
			if ( ! preg_match( '/\.(jpe?g|png|webp)$/i', $n ) ) {
				continue;
			}
			$p = $dir . '/' . $n;
			if ( ! is_file( $p ) ) {
				continue;
			}
			$files[] = array(
				'name'  => $n,
				'path'  => $p,
				'size'  => (int) filesize( $p ),
				'mtime' => (int) filemtime( $p ),
			);
		}
		usort(
			$files,
			function ( $a, $b ) {
				return strnatcasecmp( $a['name'], $b['name'] );
			}
		);
	}

	$cache[ $set ] = $files;
	return $files;
}

/** Content hash of one screenshot — changes whenever the file does. */
function sraik_wap_hash( $f ) {
	return substr( md5( $f['name'] . '|' . $f['size'] . '|' . $f['mtime'] . '|' . SRAIK_WAP_SIZE ), 0, 16 );
}

/** Public URL of an original screenshot. */
function sraik_wap_full_url( $set, $f ) {
	return SRAIK_TPL_URL . '/assets/wa-proof/' . ( '' === $set ? '' : $set . '/' ) . rawurlencode( $f['name'] ) . '?v=' . $f['mtime'];
}

/** Where thumbnails live: array( dir, url ), or null if uploads is unusable. */
function sraik_wap_store() {
	$up = wp_upload_dir( null, false );
	if ( ! empty( $up['error'] ) || empty( $up['basedir'] ) || empty( $up['baseurl'] ) ) {
		return null;
	}
	return array(
		'dir' => untrailingslashit( $up['basedir'] ) . '/sraik-wap',
		'url' => set_url_scheme( untrailingslashit( $up['baseurl'] ) . '/sraik-wap' ),
	);
}

/** Thumbnail format: WebP when the server's image editor can write it. */
function sraik_wap_ext() {
	static $ext = null;
	if ( null === $ext ) {
		$ext = wp_image_editor_supports( array( 'mime_type' => 'image/webp' ) ) ? 'webp' : 'jpg';
	}
	return $ext;
}

/**
 * Everything the page needs for one set: array of array( full URL, thumb URL ).
 */
function sraik_wap_items( $set ) {
	static $cache = array();

	$set = sraik_wap_set( $set );
	if ( null === $set ) {
		return array();
	}
	if ( isset( $cache[ $set ] ) ) {
		return $cache[ $set ];
	}

	$files = sraik_wap_files( $set );
	$items = array();

	if ( $files ) {
		$store = sraik_wap_store();
		$ext   = sraik_wap_ext();
		$key   = sraik_wap_key( $set );
		foreach ( $files as $f ) {
			$rel  = $key . '/' . sraik_wap_hash( $f ) . '.' . $ext;
			$full = sraik_wap_full_url( $set, $f );
			if ( $store && is_file( $store['dir'] . '/' . $rel ) ) {
				$thumb = $store['url'] . '/' . $rel;
			} else {
				$thumb = add_query_arg( 'sraik_wap', rawurlencode( $rel ), home_url( '/' ) );
			}
			$items[] = array( $full, $thumb );
		}
	}

	$cache[ $set ] = $items;
	return $items;
}

/** True the first time a key is seen on this request. */
function sraik_wap_once( $key ) {
	static $seen = array();
	if ( isset( $seen[ $key ] ) ) {
		return false;
	}
	$seen[ $key ] = true;
	return true;
}

/** Western digits → Bangla digits. */
function sraik_wap_bn( $n ) {
	return strtr( (string) $n, array( '0' => '০', '1' => '১', '2' => '২', '3' => '৩', '4' => '৪', '5' => '৫', '6' => '৬', '7' => '৭', '8' => '৮', '9' => '৯' ) );
}

/* ── Thumbnail endpoint ────────────────────────────────────────────────────
   Runs on muplugins_loaded: before any regular plugin (LiteSpeed Cache,
   NotificationX …) is even loaded, so nothing can buffer, cache or decorate
   the image bytes. Requests without ?sraik_wap= return immediately. */

function sraik_wap_endpoint() {
	if ( ! isset( $_GET['sraik_wap'] ) || ! is_string( $_GET['sraik_wap'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		return;
	}

	$req = (string) $_GET['sraik_wap']; // phpcs:ignore WordPress.Security.NonceVerification,WordPress.Security.ValidatedSanitizedInput -- validated by the pattern below.
	if ( ! preg_match( '#^(_default|[a-z0-9-]+)/([a-f0-9]{16})\.(webp|jpg)$#', $req, $m ) ) {
		sraik_wap_exit( 404 );
	}

	$set  = '_default' === $m[1] ? '' : $m[1];
	$hash = $m[2];
	$ext  = $m[3];
	$mime = 'webp' === $ext ? 'image/webp' : 'image/jpeg';

	/* Which screenshot is this? Only files in the wall's own folder qualify. */
	$src = null;
	foreach ( sraik_wap_files( $set ) as $f ) {
		if ( sraik_wap_hash( $f ) === $hash ) {
			$src = $f;
			break;
		}
	}
	if ( ! $src ) {
		sraik_wap_exit( 404 );
	}
	$full = sraik_wap_full_url( $set, $src );

	$store = sraik_wap_store();
	if ( ! $store ) {
		sraik_wap_exit( 302, $full );
	}
	$dir   = $store['dir'] . '/' . $m[1];
	$final = $dir . '/' . $hash . '.' . $ext;

	if ( is_file( $final ) ) {
		sraik_wap_send( $final, $mime );
	}

	/* Anything unexpected below (an editor quirk, a host without GD) ends in
	   the original screenshot, never in a broken tile. */
	try {
		sraik_wap_make( $src, $mime, $ext, $dir, $final, $full );
	} catch ( \Throwable $e ) {
		sraik_wap_exit( 302, $full );
	}
}
add_action( 'muplugins_loaded', 'sraik_wap_endpoint', 0 );

/** Build one thumbnail and send it. Every failure redirects to the original. */
function sraik_wap_make( $src, $mime, $ext, $dir, $final, $full ) {

	/* Refuse anything that could exhaust memory while decoding. */
	$info = @getimagesize( $src['path'] ); // phpcs:ignore WordPress.PHP.NoSilencedErrors
	if ( ! $info || empty( $info[0] ) || empty( $info[1] ) || empty( $info['mime'] ) || ( $info[0] * $info[1] ) > 50000000 ) {
		sraik_wap_exit( 302, $full );
	}
	if ( ! wp_image_editor_supports( array( 'mime_type' => $mime, 'methods' => array( 'crop', 'save' ) ) ) ) {
		sraik_wap_exit( 302, $full );
	}

	/* mime_type is passed explicitly: without it wp_get_image_editor() calls
	   wp_check_filetype() → current_user_can(), which does not exist yet this
	   early (pluggable.php loads after the regular plugins). */
	$ed = wp_get_image_editor( $src['path'], array( 'mime_type' => $info['mime'] ) );
	if ( is_wp_error( $ed ) ) {
		sraik_wap_exit( 302, $full );
	}
	if ( method_exists( $ed, 'maybe_exif_rotate' ) ) {
		$ed->maybe_exif_rotate();
	}

	/* Centre square, scaled down to SRAIK_WAP_SIZE (never up). */
	$dim = $ed->get_size();
	$w   = isset( $dim['width'] ) ? (int) $dim['width'] : 0;
	$h   = isset( $dim['height'] ) ? (int) $dim['height'] : 0;
	if ( $w < 1 || $h < 1 ) {
		sraik_wap_exit( 302, $full );
	}
	$side = min( $w, $h );
	$out  = min( $side, SRAIK_WAP_SIZE );
	$crop = $ed->crop( (int) floor( ( $w - $side ) / 2 ), (int) floor( ( $h - $side ) / 2 ), $side, $side, $out, $out );
	if ( is_wp_error( $crop ) ) {
		sraik_wap_exit( 302, $full );
	}
	$ed->set_quality( 'webp' === $ext ? 78 : 82 );

	if ( ! wp_mkdir_p( $dir ) ) {
		sraik_wap_exit( 302, $full );
	}

	/* Write beside the target, then rename: a half-written file is never served. */
	$tmp   = $dir . '/.tmp-' . md5( uniqid( '', true ) ) . '.' . $ext;
	$saved = $ed->save( $tmp, $mime );
	if ( is_wp_error( $saved ) || empty( $saved['path'] ) || ! is_file( $saved['path'] ) ) {
		@unlink( $tmp ); // phpcs:ignore WordPress.PHP.NoSilencedErrors
		sraik_wap_exit( 302, $full );
	}
	/* A plugin's image_editor_output_format filter could have changed the format. */
	if ( empty( $saved['mime-type'] ) || $saved['mime-type'] !== $mime || ! @rename( $saved['path'], $final ) ) { // phpcs:ignore WordPress.PHP.NoSilencedErrors
		@unlink( $saved['path'] ); // phpcs:ignore WordPress.PHP.NoSilencedErrors
		if ( ! is_file( $final ) ) {
			sraik_wap_exit( 302, $full );
		}
	}

	sraik_wap_send( $final, $mime );
}

/** Stream a finished thumbnail. Content-addressed, so it may be cached forever. */
function sraik_wap_send( $file, $mime ) {
	header( 'Content-Type: ' . $mime );
	header( 'Content-Length: ' . filesize( $file ) );
	header( 'Cache-Control: public, max-age=31536000, immutable' );
	header( 'X-Content-Type-Options: nosniff' );
	if ( isset( $_SERVER['REQUEST_METHOD'] ) && 'HEAD' === $_SERVER['REQUEST_METHOD'] ) {
		exit;
	}
	readfile( $file ); // phpcs:ignore WordPress.WP.AlternativeFunctions
	exit;
}

/** End the request with a status (and a redirect target for 302). Never cached. */
function sraik_wap_exit( $code, $location = '' ) {
	header( 'Cache-Control: no-store, max-age=0' );
	header( 'X-LiteSpeed-Cache-Control: no-cache' );
	if ( 302 === $code && $location ) {
		header( 'Location: ' . $location, true, 302 );
	} else {
		header( 'Content-Type: text/plain; charset=utf-8', true, (int) $code );
	}
	exit;
}
