<?php
/**
 * home.php — sraik.com front page (MATACE 3.0), on the Code Craft home layout.
 *
 * Copy: inc/content/home.php · FAQ: inc/content/faq.php
 * Styles: assets/css/home.css (+ base.css) · Blog row: latest WordPress posts.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$c = sraik_content( 'home' );

sraik_page_css( array( 'css/illus.css', 'css/home.css', 'css/blog.css' ) );
sraik_part( 'head.php', array( 'sraik_lcp' => $c['hero']['window']['poster'] ) );
sraik_part( 'nav.php' );
?>
<main id="main" class="page">
<?php
sraik_part( 'home/hero.php', array( 'h' => $c['hero'] ) );
sraik_part( 'home/trust.php', array( 't' => $c['trust'] ) );
sraik_part( 'home/why.php', array( 's' => $c['why'] ) );
sraik_part( 'home/inside.php', array( 's' => $c['inside'] ) );
sraik_part( 'home/steps.php', array( 's' => $c['steps'] ) );
sraik_part( 'home/mentor.php', array( 's' => $c['mentor'] ) );
sraik_part( 'home/love.php', array( 's' => $c['love'] ) );
sraik_part( 'home/pricing.php', array( 's' => $c['pricing'] ) );
sraik_part( 'home/faq.php', array( 's' => $c['faq'] ) );
sraik_part( 'home/blog.php', array( 's' => $c['blog'] ) );
?>
</main>
<?php
sraik_part( 'cta.php', array( 'cta' => $c['cta'] ) );
sraik_part( 'footer.php' );
sraik_part( 'foot.php' );
