<?php
/**
 * page-features.php — /features/ ("Training"), on the Code Craft features layout.
 *
 * Copy: inc/content/features.php · Styles: assets/css/features.css
 * (+ illus.css for the orb kit, home.css for the shared step / use-case
 * cards and the FAQ accordion the curriculum reuses).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$c = sraik_content( 'features' );

sraik_page_css( array( 'css/illus.css', 'css/home.css', 'css/features.css' ) );
sraik_part( 'head.php' );
sraik_part( 'nav.php' );
?>
<main id="main" class="page">
<?php
sraik_part( 'features/hero.php', array( 'h' => $c['hero'] ) );
sraik_part( 'features/caps.php', array( 's' => $c['caps'] ) );
sraik_part( 'features/deep.php', array( 'rows' => $c['deep'] ) );
sraik_part( 'features/curriculum.php', array( 's' => $c['curriculum'] ) );
sraik_part( 'features/live.php', array( 's' => $c['live'] ) );
sraik_part( 'features/stats.php', array( 'stats' => $c['stats'] ) );
sraik_part( 'features/outcomes.php', array( 's' => $c['outcomes'] ) );
sraik_part( 'features/compare.php', array( 's' => $c['compare'] ) );
?>
</main>
<?php
sraik_part( 'cta.php', array( 'cta' => $c['cta'] ) );
sraik_part( 'footer.php' );
sraik_part( 'foot.php' );
