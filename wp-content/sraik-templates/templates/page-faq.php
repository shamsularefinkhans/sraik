<?php
/**
 * page-faq.php — /faq/ on the Code Craft FAQ layout: split hero with a
 * "help --topics" terminal, sticky topic sidebar + every question grouped
 * by topic, then three "still stuck" routes.
 *
 * Copy: inc/content/faq-page.php · Questions: inc/content/faq.php (via inc/faq.php)
 * Styles: assets/css/faq.css (+ home.css for the shared .faq-* accordion)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$c      = sraik_content( 'faq-page' );
$groups = array_values(
	array_filter(
		sraik_tpl_faq_groups(),
		function ( $g ) {
			return ! empty( $g['items'] );
		}
	)
);

sraik_page_css( array( 'css/home.css', 'css/faq.css' ) );
sraik_part( 'head.php' );
sraik_part( 'nav.php' );
?>
<main id="main" class="page">
<?php
sraik_part( 'faq/hero.php', array( 'h' => $c['hero'], 'groups' => $groups ) );
sraik_part( 'faq/body.php', array( 'c' => $c, 'groups' => $groups ) );
sraik_part( 'faq/routes.php', array( 's' => $c['routes'] ) );
?>
</main>
<?php
sraik_part( 'footer.php' );
sraik_part( 'foot.php' );
