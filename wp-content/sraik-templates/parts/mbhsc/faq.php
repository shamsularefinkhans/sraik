<?php
/**
 * mbhsc/faq.php — the landing page's own questions (content/mbhsc.php),
 * not the /faq/ library the front page samples, in the same accordion.
 *
 * $s = content/mbhsc.php ['faq']   items: array( id, q, a )
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( empty( $s['items'] ) ) {
	return;
}
?>
<section class="sec" id="faq">
  <div class="sec-in">
    <?php echo sraik_sh( array( 'eyebrow' => $s['eyebrow'], 'title' => $s['title'], 'sub' => $s['sub'] ) ); // phpcs:ignore ?>
    <div class="faq-list" data-acc data-appear>
      <?php echo sraik_tpl_faq_list( $s['items'], 0 ); // phpcs:ignore ?>
    </div>
    <?php if ( ! empty( $s['more'] ) ) : ?>
    <div class="btn-row mb-faq-more" data-appear><?php echo sraik_btn( $s['more'][0], $s['more'][1], 'dark', 'arrow-up-right' ); // phpcs:ignore ?></div>
    <?php endif; ?>
  </div>
</section>
