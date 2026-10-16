<?php
/**
 * home/faq.php — six questions from /faq/ (ids in content/home.php).
 *
 * $s = content/home.php ['faq']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$items = array_values( array_filter( array_map( 'sraik_faq_find', $s['ids'] ) ) );
if ( ! $items ) {
	return;
}
?>
<section class="sec" id="faq">
  <div class="sec-in">
    <?php echo sraik_sh( array( 'eyebrow' => $s['eyebrow'], 'title' => $s['title'], 'sub' => $s['sub'] ) ); // phpcs:ignore ?>
    <div class="faq-list" data-acc data-appear>
      <?php echo sraik_faq_list( $items, 0 ); // phpcs:ignore ?>
    </div>
  </div>
</section>
