<?php
/**
 * page-legal.php — /privacy-policy/, /terms/ and /refund-policy/ on the
 * Code Craft legal layout: document tabs, hero + "<slug>.md" meta card,
 * TL;DR cards, sticky contents + numbered sections with a plain-English
 * note each, then a contact card. The route name (sraik_view()) picks the
 * document from inc/content/legal.php.
 *
 * Every section carries the live English AND Bengali text; the language
 * switch in the meta card toggles them (site.js [data-tabs]).
 *
 * Styles: assets/css/legal.css (+ illus.css for the TL;DR orbs)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$all  = sraik_content( 'legal' );
$slug = sraik_view();
if ( ! isset( $all[ $slug ] ) || 0 === strpos( $slug, '_' ) ) {
	$slug = 'privacy-policy';
}
$doc = $all[ $slug ];
$ui  = $all['_ui'];

/* Reading time of the English text at ~200 words a minute. */
$words = 0;
foreach ( $doc['sections'] as $sec ) {
	$words += str_word_count( wp_strip_all_tags( $sec['en'] ) );
	if ( ! empty( $sec['table'] ) ) {
		foreach ( $sec['table']['rows'] as $r ) {
			$words += str_word_count( $r[0] . ' ' . $r[1] );
		}
	}
}
$doc['minutes'] = max( 1, (int) ceil( $words / 200 ) );

sraik_page_css( array( 'css/illus.css', 'css/legal.css' ) );
sraik_part( 'head.php' );
sraik_part( 'nav.php' );
?>
<main id="main" class="page">
<?php
sraik_part( 'legal/hero.php', array( 'doc' => $doc, 'ui' => $ui, 'tabs' => $all['_tabs'], 'slug' => $slug ) );
sraik_part( 'legal/tldr.php', array( 'doc' => $doc, 'ui' => $ui ) );
sraik_part( 'legal/body.php', array( 'doc' => $doc, 'ui' => $ui, 'related' => $all['_related'], 'slug' => $slug ) );
sraik_part( 'legal/contact.php', array( 'doc' => $doc, 'ui' => $ui ) );
?>
</main>
<?php
sraik_part( 'footer.php' );
sraik_part( 'foot.php' );
