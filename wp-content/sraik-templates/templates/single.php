<?php
/**
 * single.php — one blog post, on the Code Craft "single blog" layout.
 *
 *   hero: "All posts" · category + date + reading time · title · dek ·
 *         "Written by" · featured image
 *   the post content (block editor output, styled in blog-page.css .prose)
 *   "Keep reading" — the three latest other posts (hidden when none)
 *   CTA → footer
 *
 * Runs inside the real loop so the_content() filters (heading ids, embeds,
 * password protection) behave exactly as WordPress intends.
 *
 * Copy: inc/content/blog.php ['single'] · Styles: blog.css + blog-page.css
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$c = sraik_content( 'blog' );

sraik_page_css( array( 'css/blog.css', 'css/blog-page.css' ) );
sraik_part( 'head.php' );
sraik_part( 'nav.php' );
?>
<main id="main" class="page">
<?php
while ( have_posts() ) :
	the_post();
	$sp_id     = get_the_ID();
	$sp_cat    = sraik_post_cat( $sp_id );
	$sp_locked = post_password_required();
	/* Only a hand-written excerpt: an automatic one would repeat the first paragraph. */
	$sp_dek    = has_excerpt() ? wp_strip_all_tags( get_the_excerpt() ) : '';
	$sp_cover  = $sp_locked ? null : sraik_post_image( $sp_id, 'large' );
	?>
  <article <?php post_class( 'sp' ); ?>>
    <section class="hero sp-hero<?php echo $sp_cover ? '' : ' sp-hero--plain'; ?>">
      <?php sraik_hero_bg( false ); ?>
      <div class="sp-hero-in">
        <header class="sp-head">
          <a class="sp-back" href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" data-appear style="--ay:12px"><?php sraik_i( 'arrow-left', 14 ); ?><span><?php echo esc_html( $c['single']['back'] ); ?></span></a>
          <div class="pmeta sp-meta" data-appear style="--ad:.05s">
            <a class="pcat" href="<?php echo esc_url( $sp_cat['url'] ); ?>"><?php echo esc_html( $sp_cat['name'] ); ?></a>
            <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'M j, Y' ) ); ?></time>
            <span class="pmeta-dot" aria-hidden="true">•</span>
            <span><?php echo (int) sraik_read_time( $sp_id ); ?> min read</span>
          </div>
          <h1 class="t-h2r sp-title" data-appear style="--ad:.1s"><?php echo esc_html( wp_strip_all_tags( get_the_title() ) ); ?></h1>
          <?php if ( ! $sp_locked && '' !== $sp_dek ) : ?>
          <p class="sp-dek" data-appear style="--ad:.15s"><?php echo esc_html( $sp_dek ); ?></p>
          <?php endif; ?>
          <p class="sp-by" data-appear style="--ad:.2s">
            <span class="sp-by-l"><?php echo esc_html( $c['single']['by'] ); ?></span>
            <a class="sp-by-n" href="<?php echo esc_url( get_author_posts_url( (int) get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( sraik_post_author( $sp_id ) ); ?></a>
          </p>
        </header>
        <?php if ( $sp_cover ) : ?>
        <figure class="sp-cover" data-appear style="--ay:24px;--ad:.25s">
          <?php echo sraik_post_img_tag( $sp_id, 'large', '(max-width:809px) calc(100vw - 40px), (max-width:1199px) calc(100vw - 80px), 1104px', true ); // phpcs:ignore ?>
        </figure>
        <?php endif; ?>
      </div>
    </section>

    <section class="sp-body">
      <div class="sp-body-in">
        <div class="prose">
          <?php
          if ( $sp_locked ) {
            /* WordPress's own form, with its English intro line swapped for ours. */
            $sp_msg = $c['single']['protected'];
            add_filter(
              'the_password_form',
              function ( $form ) use ( $sp_msg ) {
                return preg_replace( '#<p>.*?</p>#s', '<p>' . esc_html( $sp_msg ) . '</p>', $form, 1 );
              }
            );
          }
          the_content();
          ?>
        </div>
        <?php
        wp_link_pages(
          array(
            'before'      => '<nav class="sp-pages" aria-label="' . esc_attr( wp_strip_all_tags( $c['single']['pages'] ) ) . '"><span class="sp-pages-l">' . esc_html( $c['single']['pages'] ) . '</span>',
            'after'       => '</nav>',
            'link_before' => '<span>',
            'link_after'  => '</span>',
          )
        );
        ?>
      </div>
    </section>
  </article>
	<?php
endwhile;

$sp_more = sraik_latest_posts( 3, isset( $sp_id ) ? array( $sp_id ) : array() );
if ( $sp_more ) :
	$sp_m = $c['single']['more'];
	?>
  <section class="sp-more" aria-label="<?php echo esc_attr( $sp_m['eyebrow'] ); ?>">
    <div class="sp-more-in">
      <div class="hair" aria-hidden="true"></div>
      <div class="sh-row">
        <?php echo sraik_sh( array( 'eyebrow' => $sp_m['eyebrow'], 'title' => $sp_m['title'], 'align' => 'left' ) ); // phpcs:ignore ?>
        <?php echo sraik_btn( $sp_m['button'], '/blog/', 'dark' ); // phpcs:ignore ?>
      </div>
      <div class="pgrid">
        <?php
        foreach ( $sp_more as $sp_p ) {
          echo sraik_post_card( $sp_p, '(max-width:809px) calc(100vw - 56px), (max-width:1199px) calc(50vw - 46px), 336px' ); // phpcs:ignore
        }
        ?>
      </div>
    </div>
  </section>
<?php endif; ?>
</main>
<?php
wp_reset_postdata();
sraik_part( 'cta.php', array( 'cta' => $c['cta'] ) );
sraik_part( 'footer.php' );
sraik_part( 'foot.php' );
