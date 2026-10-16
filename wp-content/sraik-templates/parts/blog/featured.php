<?php
/**
 * blog/featured.php — the wide horizontal card at the top of /blog/:
 * image left, "Featured" badge + category + date + reading time, title,
 * excerpt, author and "Read article". Stacks under 1200px.
 *
 * $post_obj = WP_Post · $c = content/blog.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$bp_id  = $post_obj->ID;
$bp_cat = sraik_post_cat( $bp_id );
?>
<a class="fpost" href="<?php echo esc_url( get_permalink( $bp_id ) ); ?>" data-appear style="--ay:24px;--ad:.25s">
  <span class="fpost-media">
    <?php echo sraik_post_img_tag( $bp_id, 'large', '(max-width:809px) calc(100vw - 56px), (max-width:1199px) calc(100vw - 96px), 504px', true ); // phpcs:ignore ?>
  </span>
  <span class="fpost-body">
    <span class="fpost-meta">
      <span class="fpost-badge"><?php echo esc_html( $c['featured'] ); ?></span>
      <span class="pmeta">
        <span class="pcat"><?php echo esc_html( $bp_cat['name'] ); ?></span>
        <span class="pmeta-dr">
          <time datetime="<?php echo esc_attr( get_the_date( 'c', $bp_id ) ); ?>"><?php echo esc_html( get_the_date( 'M j, Y', $bp_id ) ); ?></time>
          <span class="pmeta-dot" aria-hidden="true">•</span>
          <span><?php echo (int) sraik_read_time( $bp_id ); ?> min read</span>
        </span>
      </span>
    </span>
    <span class="fpost-title t-h4b"><?php echo esc_html( wp_strip_all_tags( get_the_title( $bp_id ) ) ); ?></span>
    <?php if ( ! post_password_required( $post_obj ) ) : ?>
    <span class="fpost-ex"><?php echo esc_html( sraik_post_excerpt( $bp_id, 26 ) ); ?></span>
    <?php endif; ?>
    <span class="fpost-foot">
      <span class="fpost-author"><?php echo esc_html( sraik_post_author( $bp_id ) ); ?></span>
      <span class="fpost-read"><?php echo esc_html( $c['read'] ); ?> <?php sraik_i( 'arrow-up-right', 16 ); ?></span>
    </span>
  </span>
</a>
