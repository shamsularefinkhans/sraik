<?php
/**
 * page-about.php — /about/ on the Code Craft careers layout.
 *
 * Copy: inc/content/about.php · Styles: assets/css/about.css (+ illus.css
 * for the orb visuals). The template page has no CTA card above the
 * footer; the WhatsApp "direct line" card closes the page instead.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$c = sraik_content( 'about' );

sraik_page_css( array( 'css/illus.css', 'css/about.css' ) );
sraik_part( 'head.php', array( 'sraik_lcp' => $c['hero']['photos'][1][0] ) );
sraik_part( 'nav.php' );
?>
<main id="main" class="page">
<?php
sraik_part( 'about/hero.php', array( 'h' => $c['hero'] ) );
sraik_part( 'about/mentor.php', array( 's' => $c['mentor'] ) );
sraik_part( 'about/values.php', array( 's' => $c['values'] ) );
sraik_part( 'about/principles.php', array( 's' => $c['principles'] ) );
sraik_part( 'about/programs.php', array( 's' => $c['programs'] ) );
sraik_part( 'about/journey.php', array( 's' => $c['journey'] ) );
sraik_part( 'about/contact.php', array( 's' => $c['contact'] ) );
?>
</main>
<?php
sraik_part( 'footer.php' );
sraik_part( 'foot.php' );
