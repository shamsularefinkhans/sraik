<?php
/**
 * 404.php — page not found. The template has no 404, so this one is built
 * from its own pieces: the page-hero backdrop, an eyebrow, a display
 * heading, two buttons, then the home page's "From the blog" row so a lost
 * visitor has somewhere to go. The router keeps the 404 status.
 *
 * Copy: inc/content/blog.php ['404'] · Styles: blog.css + blog-page.css
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$c  = sraik_content( 'blog' );
$nf = $c['404'];

sraik_page_css( array( 'css/blog.css', 'css/blog-page.css' ) );
sraik_part( 'head.php' );
sraik_part( 'nav.php' );
?>
<main id="main" class="page">
  <section class="hero nf-hero" aria-labelledby="nf-title">
    <?php sraik_hero_bg(); ?>
    <div class="nf-in">
      <?php echo sraik_eyebrow( $nf['eyebrow'], 'compass', 'eyebrow--mono' ); // phpcs:ignore ?>
      <h1 class="t-display nf-title" id="nf-title" data-appear style="--ad:.1s"><?php sraik_t( $nf['title'] ); ?></h1>
      <p class="bp-sub" data-appear style="--ad:.2s"><?php sraik_t( $nf['sub'] ); ?></p>
      <div class="btn-row nf-btns" data-appear style="--ad:.3s">
        <?php echo sraik_btn( $nf['primary'][0], $nf['primary'][1], 'lime', 'arrow-right' ); // phpcs:ignore ?>
        <?php echo sraik_btn( $nf['secondary'][0], $nf['secondary'][1], 'dark' ); // phpcs:ignore ?>
      </div>
    </div>
  </section>
  <?php sraik_part( 'home/blog.php', array( 's' => $nf['posts'] ) ); ?>
</main>
<?php
sraik_part( 'footer.php' );
sraik_part( 'foot.php' );
