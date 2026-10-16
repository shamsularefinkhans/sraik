<?php
/**
 * home/blog.php — the three latest WordPress posts. No posts, no section.
 *
 * $s = content/home.php ['blog']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$posts = sraik_latest_posts( 3 );
if ( ! $posts ) {
	return;
}
?>
<section class="sec" id="blog">
  <div class="sec-in">
    <div class="sh-row">
      <?php echo sraik_sh( array( 'eyebrow' => $s['eyebrow'], 'title' => $s['title'], 'sub' => $s['sub'], 'align' => 'left' ) ); // phpcs:ignore ?>
      <?php echo sraik_btn( $s['button'], '/blog/', 'dark' ); // phpcs:ignore ?>
    </div>
    <div class="pgrid">
      <?php foreach ( $posts as $p ) { echo sraik_post_card( $p ); } // phpcs:ignore ?>
    </div>
  </div>
</section>
