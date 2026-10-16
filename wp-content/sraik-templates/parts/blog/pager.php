<?php
/**
 * blog/pager.php — pagination under the post grid. paginate_links() works
 * off the main query, so /blog/page/2/ and /category/x/page/2/ both work.
 *
 * $pg = content/blog.php ['pager'] · $paged · $total
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$bp_links = paginate_links(
	array(
		'current'   => $paged,
		'total'     => $total,
		'type'      => 'array',
		'mid_size'  => 1,
		'end_size'  => 1,
		'prev_text' => sraik_icon( 'arrow-left', 16 ) . '<span>' . esc_html( $pg['prev'] ) . '</span>',
		'next_text' => '<span>' . esc_html( $pg['next'] ) . '</span>' . sraik_icon( 'arrow-right', 16 ),
	)
);
if ( ! $bp_links ) {
	return;
}
?>
<nav class="bp-pager" aria-label="<?php echo esc_attr( $pg['label'] ); ?>" data-appear>
  <?php foreach ( $bp_links as $bp_l ) : ?>
  <?php echo $bp_l; // phpcs:ignore WordPress.Security.EscapeOutput -- built by paginate_links() ?>
  <?php endforeach; ?>
</nav>
