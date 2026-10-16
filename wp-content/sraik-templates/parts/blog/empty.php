<?php
/**
 * blog/empty.php — shown when a list has no posts (new blog, empty
 * category, a search with no results). A search also gets a search box.
 *
 * $e = content/blog.php ['empty'][…] · $search (bool) · $h_id (heading id)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="bp-empty card-flat card-flat--line" data-appear>
  <span class="gloss bp-empty-ico" aria-hidden="true"><?php sraik_i( $search ? 'search' : 'newspaper', 22 ); ?></span>
  <h2 class="t-h5" id="<?php echo esc_attr( $h_id ); ?>"><?php sraik_t( $e['title'] ); ?></h2>
  <p class="bp-empty-sub"><?php sraik_t( $e['sub'] ); ?></p>
  <?php if ( $search ) : ?>
  <form class="bp-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label class="sr-only" for="bp-s"><?php echo esc_html( $e['go'] ); ?></label>
    <input type="search" id="bp-s" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php echo esc_attr( $e['ph'] ); ?>">
    <button class="btn btn--lime" type="submit"><span><?php echo esc_html( $e['go'] ); ?></span><?php sraik_i( 'search', 16 ); ?></button>
  </form>
  <?php endif; ?>
  <?php echo sraik_btn( $e['btn'][0], $e['btn'][1], 'dark' ); // phpcs:ignore ?>
</div>
