<?php
/**
 * page-mbhsc.php — sraik.com/mbhsc/ (Mission: Bypass HSC landing page),
 * on the same Code Craft home layout as the front page.
 *
 * Copy: inc/content/mbhsc.php. The front page's parts (parts/home/*) render
 * the sections both pages share; sections only this page has live in
 * parts/mbhsc/*. Styles: home.css (+ base/illus) and assets/css/mbhsc.css.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$c = sraik_content( 'mbhsc' );

sraik_page_css( array( 'css/illus.css', 'css/home.css', 'css/mbhsc.css' ) );
sraik_part( 'head.php', array( 'sraik_lcp' => $c['hero']['window']['poster'] ) );
sraik_part( 'nav.php' );
?>
<main id="main" class="page page--mbhsc">
<?php
sraik_part( 'home/hero.php', array( 'h' => $c['hero'] ) );
sraik_part( 'home/trust.php', array( 't' => $c['trust'] ) );
sraik_part( 'mbhsc/program.php', array( 's' => $c['program'] ) );
sraik_part( 'mbhsc/pain.php', array( 's' => $c['pain'] ) );
sraik_part( 'home/inside.php', array( 's' => $c['inside'] ) );
sraik_part( 'home/why.php', array( 's' => $c['why'] ) );
sraik_part( 'mbhsc/curriculum.php', array( 's' => $c['curriculum'] ) );
sraik_part( 'mbhsc/curriculum.php', array( 's' => $c['live'] ) );
sraik_part( 'home/steps.php', array( 's' => $c['steps'] ) );
sraik_part( 'home/mentor.php', array( 's' => $c['mentor'] ) );
sraik_part( 'mbhsc/outcomes.php', array( 's' => $c['outcomes'] ) );
sraik_part( 'mbhsc/about.php', array( 's' => $c['about'] ) );
sraik_part( 'home/love.php', array( 's' => $c['love'] ) );
sraik_part( 'mbhsc/pricing.php', array( 's' => $c['pricing'] ) );
sraik_part( 'mbhsc/faq.php', array( 's' => $c['faq'] ) );
?>
</main>
<?php
sraik_part( 'cta.php', array( 'cta' => $c['cta'] ) );
sraik_part( 'footer.php' );
sraik_part( 'foot.php' );
