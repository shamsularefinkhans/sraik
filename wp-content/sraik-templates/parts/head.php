<?php
/**
 * head.php — shared <head> + opening <body> for every SRAIK template.
 *
 * CSS is INLINED (LiteSpeed's optimizer mangles our stylesheets as separate
 * files). A cached PAGE therefore carries its CSS: after changing CSS do
 * LiteSpeed "Purge All", then Cloudflare "Purge Everything".
 *
 * Page stylesheets come from sraik_page_css(), set by the template before
 * this part is included.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sraik_view  = sraik_view();
$sraik_title = sraik_meta( 'title', get_bloginfo( 'name' ) );
$sraik_desc  = sraik_meta( 'desc', get_bloginfo( 'description' ) );
$sraik_image = sraik_meta( 'image', 'https://sraik.com/wp-content/uploads/2026/06/glb.jpg' );
if ( 'single' === $sraik_view ) {
	$sraik_url = get_permalink();
} elseif ( isset( sraik_config( 'routes' )[ $sraik_view ] ) ) {
	$sraik_url = home_url( '/' . $sraik_view . '/' );
	$sraik_pg  = (int) get_query_var( 'paged' );
	if ( 'blog' === $sraik_view && $sraik_pg > 1 ) {
		$sraik_url .= 'page/' . $sraik_pg . '/';
	}
} elseif ( 'archive' === $sraik_view ) {
	$sraik_url = get_pagenum_link( max( 1, (int) get_query_var( 'paged' ) ) );
} else {
	$sraik_url = home_url( '/' );
}
?><!-- بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ -->
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title><?php echo esc_html( $sraik_title ); ?></title>
<meta name="description" content="<?php echo esc_attr( $sraik_desc ); ?>">
<meta name="theme-color" content="#07080a">
<meta name="color-scheme" content="dark">
<?php if ( '404' === $sraik_view || is_search() ) : ?>
<meta name="robots" content="noindex,follow">
<?php else : ?>
<link rel="canonical" href="<?php echo esc_url( $sraik_url ); ?>">
<?php endif; ?>
<meta property="og:type" content="<?php echo 'single' === $sraik_view ? 'article' : 'website'; ?>">
<meta property="og:url" content="<?php echo esc_url( $sraik_url ); ?>">
<meta property="og:title" content="<?php echo esc_attr( $sraik_title ); ?>">
<meta property="og:description" content="<?php echo esc_attr( $sraik_desc ); ?>">
<meta property="og:image" content="<?php echo esc_url( $sraik_image ); ?>">
<meta property="og:site_name" content="SRAIK">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo esc_attr( $sraik_title ); ?>">
<meta name="twitter:description" content="<?php echo esc_attr( $sraik_desc ); ?>">
<meta name="twitter:image" content="<?php echo esc_url( $sraik_image ); ?>">
<link rel="icon" href="https://sraik.com/wp-content/uploads/2026/05/cropped-site-logo-white-png-192x192.png">
<link rel="apple-touch-icon" href="https://sraik.com/wp-content/uploads/2026/05/cropped-site-logo-white-png-192x192.png">
<?php if ( 'single' === $sraik_view || 'blog' === $sraik_view ) : ?>
<link rel="alternate" type="application/rss+xml" title="SRAIK Blog" href="<?php echo esc_url( get_feed_link() ); ?>">
<?php endif; ?>
<?php
/* Above-the-fold image of this view (hero mockup / featured image). Preloading
   it starts the fetch during head parsing. Fonts are deliberately NOT
   preloaded: measured on event.sraik.com it starved the LCP image. */
$sraik_lcp = isset( $sraik_lcp ) ? $sraik_lcp : '';
if ( $sraik_lcp ) :
	?>
<link rel="preload" as="image" href="<?php echo esc_url( $sraik_lcp ); ?>" fetchpriority="high">
<?php endif; ?>
<script>document.documentElement.classList.add('js')</script>
<style><?php sraik_inline( 'css/base.css' ); ?></style>
<?php foreach ( sraik_page_css() as $sraik_css ) : ?>
<style><?php sraik_inline( $sraik_css ); ?></style>
<?php endforeach; ?>
<?php if ( 'single' === $sraik_view ) : ?>
<script type="application/ld+json"><?php echo wp_json_encode( sraik_post_schema( get_queried_object_id() ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ); ?></script>
<?php endif; ?>
</head>
<body class="v-<?php echo esc_attr( $sraik_view ? $sraik_view : 'page' ); ?>">
<a class="skip" href="#main">Skip to content</a>
