<?php
/**
 * Plugin Name: SRAIK Templates (sraik.com)
 * Description: Serves the sraik.com front end from wp-content/sraik-templates/.
 *              WordPress stays the backend (pages, posts, media, users);
 *              this file only decides which template renders a request.
 *              Deleting THIS ONE FILE hands the site back to the active theme.
 * Version:     2.0.0
 * Author:      S A Khan Shams
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SRAIK_TPL_DIR', WP_CONTENT_DIR . '/sraik-templates' );
define( 'SRAIK_TPL_URL', content_url( '/sraik-templates' ) );
define( 'SRAIK_TPL_VER', '2.0.0' );

if ( ! file_exists( SRAIK_TPL_DIR . '/inc/bootstrap.php' ) ) {
	return; /* folder missing: stay out of the way, the theme renders */
}

require_once SRAIK_TPL_DIR . '/inc/bootstrap.php';
