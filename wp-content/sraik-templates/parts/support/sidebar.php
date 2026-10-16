<?php
/**
 * support/sidebar.php — sticky help-center navigation (desktop only, as
 * in the template). [data-toc] highlights the guide in view.
 *
 * $s = content/support.php ['side']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<aside class="hc-side">
  <div class="hc-side-head">
    <span class="gloss hc-side-ico" aria-hidden="true"><?php sraik_i( 'book-open', 15, 2 ); ?></span>
    <span class="hc-side-tt">
      <span class="hc-side-t"><?php echo esc_html( $s['title'] ); ?></span>
      <span class="hc-side-m"><?php echo esc_html( $s['meta'] ); ?></span>
    </span>
  </div>
  <nav class="hc-toc" data-toc aria-label="<?php echo esc_attr( $s['title'] ); ?>">
    <?php foreach ( $s['groups'] as $g ) : ?>
    <div class="hc-toc-grp">
      <span class="hc-toc-l"><?php echo esc_html( $g['label'] ); ?></span>
      <div class="hc-toc-list">
        <?php
        foreach ( $g['links'] as $l ) :
			$ext = ! empty( $l[2] );
			?>
        <a href="<?php echo esc_url( sraik_hc_href( $l[1] ) ); ?>"><?php echo esc_html( $l[0] ); ?><?php echo $ext ? sraik_icon( 'arrow-up-right', 12, 2 ) : ''; // phpcs:ignore ?></a>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endforeach; ?>
  </nav>
  <div class="hc-stuck">
    <p class="hc-stuck-t"><?php echo esc_html( $s['card']['title'] ); ?></p>
    <p class="hc-stuck-p"><?php echo esc_html( $s['card']['text'] ); ?></p>
    <a class="hc-stuck-a" href="<?php echo esc_url( sraik_hc_href( $s['card']['link'][1] ) ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $s['card']['link'][0] ); ?><?php sraik_i( 'arrow-up-right', 14, 2 ); ?></a>
  </div>
</aside>
