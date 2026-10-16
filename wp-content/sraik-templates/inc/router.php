<?php
/**
 * router.php — decides which template renders a request.
 *
 * Two kinds of URL are ours:
 *
 *   1. Virtual routes (inc/config.php → 'routes'): /features/, /faq/, /blog/ …
 *      They work WITHOUT a WordPress Page existing. A rewrite rule maps the
 *      path to ?sraik_route=<name>. If a Page with the same slug exists it is
 *      simply shadowed — its editor content is never shown.
 *
 *   2. WordPress's own views: the front page, single posts, category / tag /
 *      author / search archives and the 404. Posts are always rendered by
 *      templates/single.php, so a post published in wp-admin appears on the
 *      site with the template styling and nothing else to do.
 *
 * Anything else (WooCommerce, Tutor LMS, plain Pages we have no design for)
 * falls through to the active theme untouched.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Rewrite rules for the virtual routes. */
function sraik_rewrite_rules() {
	foreach ( sraik_config( 'routes' ) as $route => $tpl ) {
		$path = preg_quote( $route, '#' );
		add_rewrite_rule( '^' . $path . '/?$', 'index.php?sraik_route=' . $route, 'top' );
		if ( 'blog' === $route ) {
			add_rewrite_rule( '^blog/page/([0-9]+)/?$', 'index.php?sraik_route=blog&paged=$matches[1]', 'top' );
		}
	}
}
add_action( 'init', 'sraik_rewrite_rules' );

/** Flush rules once whenever the route list changes — no manual "Save permalinks" needed. */
function sraik_maybe_flush_rules() {
	$sig = md5( SRAIK_TPL_VER . '|' . implode( ',', array_keys( sraik_config( 'routes' ) ) ) );
	if ( get_option( 'sraik_rewrite_sig' ) !== $sig ) {
		flush_rewrite_rules( false );
		update_option( 'sraik_rewrite_sig', $sig, true );
	}
}
add_action( 'init', 'sraik_maybe_flush_rules', 99 );

function sraik_query_vars( $vars ) {
	$vars[] = 'sraik_route';
	return $vars;
}
add_filter( 'query_vars', 'sraik_query_vars' );

/**
 * The main query of a virtual route.
 * /blog/ becomes a normal paginated posts query so the_post() and
 * pagination work exactly as on any archive; every other route only needs
 * one row, so it asks for one.
 */
function sraik_pre_get_posts( $q ) {
	if ( is_admin() || ! $q->is_main_query() ) {
		return;
	}
	$route = $q->get( 'sraik_route' );
	if ( ! $route ) {
		return;
	}
	$q->set( 'post_type', 'post' );
	$q->set( 'post_status', 'publish' );
	$q->set( 'ignore_sticky_posts', false );
	if ( 'blog' === $route ) {
		$q->set( 'posts_per_page', (int) sraik_config( 'blog' )['per_page'] );
	} else {
		$q->set( 'posts_per_page', 1 );
		$q->set( 'no_found_rows', true );
	}
	/* A virtual route is a page of ours, not the posts index / front page. */
	$q->is_home       = false;
	$q->is_front_page = false;
	$q->is_archive    = false;
	$q->is_404        = false;
}
add_action( 'pre_get_posts', 'sraik_pre_get_posts' );

/** Never let canonical redirects rewrite a virtual route (e.g. /blog/page/2/). */
function sraik_redirect_canonical( $redirect ) {
	return get_query_var( 'sraik_route' ) ? false : $redirect;
}
add_filter( 'redirect_canonical', 'sraik_redirect_canonical' );

/**
 * The current view, as one string every part of the system agrees on:
 *   'home' | 'single' | 'archive' | '404' | a route name ('blog', 'faq' …)
 */
function sraik_view() {
	static $view = null;
	if ( null !== $view ) {
		return $view;
	}
	$route = get_query_var( 'sraik_route' );
	$map   = sraik_config( 'routes' );

	if ( $route && isset( $map[ $route ] ) ) {
		$view = $route;
	} elseif ( is_front_page() ) {
		$view = 'home';
	} elseif ( is_home() ) {
		$view = 'blog'; /* a Page chosen as "Posts page" in Settings → Reading */
	} elseif ( is_singular( 'post' ) ) {
		$view = 'single';
	} elseif ( is_category() || is_tag() || is_author() || is_date() || is_search() ) {
		$view = 'archive';
	} elseif ( is_404() ) {
		$view = '404';
	} elseif ( is_page() ) {
		$slug = get_post_field( 'post_name', get_queried_object_id() );
		$view = isset( $map[ $slug ] ) ? $slug : '';
	} else {
		$view = '';
	}
	return $view;
}

function sraik_template_include( $template ) {
	if ( is_admin() || is_feed() || is_robots() || is_trackback() || is_embed() ) {
		return $template;
	}
	$view = sraik_view();
	if ( '' === $view ) {
		return $template; /* not ours: the theme renders it */
	}

	$routes = sraik_config( 'routes' );
	$file   = isset( $routes[ $view ] ) ? $routes[ $view ] : $view . '.php';
	if ( 'archive' === $view ) {
		$file = 'blog.php';
	}

	$path = SRAIK_TPL_DIR . '/templates/' . $file;
	if ( ! file_exists( $path ) ) {
		return $template;
	}
	if ( isset( $routes[ $view ] ) && '404' !== $view ) {
		status_header( 200 );
	}
	return $path;
}
add_filter( 'template_include', 'sraik_template_include', 99 );

/** Our templates print their own <head>; the theme's admin bar would render broken. */
add_filter( 'show_admin_bar', '__return_false' );

/* Generator + emoji noise; nothing on our pages consumes wp_head. */
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

/** <title> for any view (also used by the theme's pages, harmless there). */
function sraik_document_title( $title ) {
	$t = sraik_meta( 'title', '' );
	return $t ? $t : $title;
}
add_filter( 'pre_get_document_title', 'sraik_document_title' );
