<?php
/**
 * page-support.php — /support/ on the Code Craft docs layout: a sticky
 * help-center sidebar beside the guides (overview, enrolment, Player vs
 * Pro, WhatsApp order, payment, video, help routes, contact form), then
 * the CTA card.
 *
 * Copy: inc/content/support.php · Styles: assets/css/support.css
 * /faq/ links to #payment-video; the footer's "Contact" lands on this page.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$c = sraik_content( 'support' );

/**
 * A link target from the copy: '#anchor', '/path/', a full URL, or a
 * config url key ('whatsapp', 'dashboard' …).
 */
function sraik_hc_href( $h ) {
	if ( preg_match( '#^(\#|/|https?:|mailto:|tel:)#', $h ) ) {
		return sraik_href( $h );
	}
	return sraik_url( $h );
}

sraik_page_css( array( 'css/support.css' ) );
sraik_part( 'head.php' );
sraik_part( 'nav.php' );
?>
<main id="main" class="page">
  <div class="hc">
    <div class="hc-bg" aria-hidden="true"><div class="hc-fade"></div><div class="hc-spot"></div></div>
    <div class="hc-in">
      <?php sraik_part( 'support/sidebar.php', array( 's' => $c['side'] ) ); ?>
      <div class="hc-main">
        <?php
        sraik_part( 'support/overview.php', array( 's' => $c['overview'] ) );
        sraik_part( 'support/enroll.php', array( 's' => $c['enroll'] ) );
        sraik_part( 'support/editions.php', array( 's' => $c['editions'] ) );
        sraik_part( 'support/order.php', array( 's' => $c['order'] ) );
        sraik_part( 'support/payment.php', array( 's' => $c['payment'] ) );
        sraik_part( 'support/video.php', array( 's' => $c['video'] ) );
        sraik_part( 'support/help.php', array( 's' => $c['help'] ) );
        sraik_part( 'support/contact.php', array( 's' => $c['contact'] ) );
        ?>
      </div>
    </div>
  </div>
</main>
<?php
sraik_part( 'cta.php' );
sraik_part( 'footer.php' );
sraik_part( 'foot.php' );
