<?php
/**
 * footer.php — site footer: brand + socials, four link columns, the giant
 * gradient wordmark and the copyright row. Links: inc/config.php 'footer'.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sraik_f    = sraik_config( 'footer' );
$sraik_here = untrailingslashit( wp_parse_url( home_url( add_query_arg( array() ) ), PHP_URL_PATH ) );
?>
<footer class="foot">
  <div class="foot-in">
    <div class="foot-top">
      <div class="foot-brand">
        <?php sraik_brand(); ?>
        <p><?php echo esc_html( $sraik_f['tagline'] ); ?></p>
        <?php echo sraik_socials(); // phpcs:ignore ?>
      </div>
      <?php foreach ( $sraik_f['cols'] as $sraik_title => $sraik_links ) : ?>
      <div class="foot-col">
        <h3><?php echo esc_html( $sraik_title ); ?></h3>
        <?php
        foreach ( $sraik_links as $sraik_l ) :
          $sraik_u   = sraik_href( $sraik_l[1] );
          $sraik_cur = ( untrailingslashit( wp_parse_url( $sraik_u, PHP_URL_PATH ) ) === $sraik_here && false === strpos( $sraik_l[1], '#' ) );
          ?>
        <a href="<?php echo esc_url( $sraik_u ); ?>"<?php echo $sraik_cur ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $sraik_l[0] ); ?></a>
        <?php endforeach; ?>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="foot-hr"></div>
    <?php /* Giant wordmark. viewBox = the text's measured box in Bricolage 600 @16px
       (letter-spacing -.03em), so it fills the row edge to edge without
       stretching. Changing the word? Re-measure: tools/measure-wordmark.js */ ?>
    <svg class="foot-word" viewBox="0 0 <?php echo esc_attr( $sraik_f['wordmark_w'] ); ?> 16" aria-hidden="true" focusable="false">
      <defs><linearGradient id="fwg" x1="0" y1="1" x2="0" y2="0"><stop offset="0" stop-color="#fff" stop-opacity=".02"/><stop offset="1" stop-color="#fff" stop-opacity=".14"/></linearGradient></defs>
      <text x="0" y="14.2" fill="url(#fwg)"><?php echo esc_html( $sraik_f['wordmark'] ); ?></text>
    </svg>
    <div class="foot-bottom">
      <span><?php echo esc_html( str_replace( '%Y', date_i18n( 'Y' ), $sraik_f['copyright'] ) ); ?></span>
      <a href="mailto:<?php echo esc_attr( sraik_contact( 'email' ) ); ?>"><?php sraik_i( 'mail', 14 ); ?><?php echo esc_html( sraik_contact( 'email' ) ); ?></a>
    </div>
  </div>
</footer>
