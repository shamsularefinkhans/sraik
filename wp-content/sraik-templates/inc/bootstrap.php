<?php
/**
 * bootstrap.php — loads the template system. Included by the mu-plugin.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once SRAIK_TPL_DIR . '/inc/helpers.php';
require_once SRAIK_TPL_DIR . '/inc/config.php';
require_once SRAIK_TPL_DIR . '/inc/icons.php';
require_once SRAIK_TPL_DIR . '/inc/components.php';
require_once SRAIK_TPL_DIR . '/inc/illus.php';
require_once SRAIK_TPL_DIR . '/inc/blog.php';
require_once SRAIK_TPL_DIR . '/inc/faq.php';
require_once SRAIK_TPL_DIR . '/inc/status.php';
require_once SRAIK_TPL_DIR . '/inc/wa-proof.php';
require_once SRAIK_TPL_DIR . '/inc/router.php';
