<?php
/**
 * faq/routes.php — "Still stuck? Pick a route." three link cards.
 *
 * $s = content/faq-page.php ['routes']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="fq-routes" aria-labelledby="fq-routes-h">
  <div class="fq-routes-in">
    <div class="fq-routes-head" data-appear>
      <p class="fq-routes-k"><?php echo esc_html( $s['kicker'] ); ?></p>
      <h2 class="t-h4b" id="fq-routes-h"><?php echo esc_html( $s['title'] ); ?></h2>
    </div>
    <div class="fq-rgrid">
      <?php foreach ( $s['cards'] as $i => $r ) : ?>
        <?php $url = sraik_href( $r['href'] ); ?>
      <a class="fq-route" href="<?php echo esc_url( $url ); ?>"<?php echo sraik_link_attrs( $url ); // phpcs:ignore ?> data-appear style="--ad:<?php echo esc_attr( 0.08 * $i ); ?>s">
        <span class="fq-route-top">
          <span class="gloss fq-gloss" aria-hidden="true"><?php sraik_i( $r['icon'], 16, 2 ); ?></span>
          <?php sraik_i( 'arrow-up-right', 16, 2, 'fq-route-arr' ); ?>
        </span>
        <span class="fq-route-copy">
          <span class="fq-route-t"><?php echo esc_html( $r['title'] ); ?></span>
          <span class="fq-route-p"><?php echo esc_html( $r['text'] ); ?></span>
        </span>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
