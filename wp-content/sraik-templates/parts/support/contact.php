<?php
/**
 * support/contact.php — the live support form, in the API panel's
 * two-pane frame: the form on the left, direct contact + network on the
 * right. Submitting opens WhatsApp with the message composed from the
 * fields; without JavaScript the form still opens the chat.
 *
 * $s = content/support.php ['contact']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$f  = $s['form'];
$wa = preg_replace( '/\D+/', '', sraik_contact( 'whatsapp' ) );
?>
<section class="hc-sec" id="contact" aria-labelledby="hc-contact">
  <?php sraik_part( 'support/head.php', array( 's' => $s, 'hid' => 'hc-contact' ) ); ?>
  <div class="hc-api hc-api--form" data-appear>
    <form class="hc-api-l hc-form" id="hc-form" action="<?php echo esc_url( 'https://wa.me/' . $wa ); ?>" method="get" target="_blank">
      <div class="hc-form-row">
        <label class="hc-field"><span class="hc-ml"><?php echo esc_html( $f['name'][0] ); ?></span><input type="text" id="hc-name" autocomplete="name" placeholder="<?php echo esc_attr( $f['name'][1] ); ?>" required></label>
        <label class="hc-field"><span class="hc-ml"><?php echo esc_html( $f['phone'][0] ); ?></span><input type="tel" id="hc-phone" autocomplete="tel" placeholder="<?php echo esc_attr( $f['phone'][1] ); ?>" required></label>
      </div>
      <label class="hc-field"><span class="hc-ml"><?php echo esc_html( $f['subject'][0] ); ?></span><input type="text" id="hc-subject" placeholder="<?php echo esc_attr( $f['subject'][1] ); ?>" required></label>
      <label class="hc-field"><span class="hc-ml"><?php echo esc_html( $f['details'][0] ); ?></span><textarea id="hc-details" rows="5" placeholder="<?php echo esc_attr( $f['details'][1] ); ?>" required></textarea></label>
      <input type="hidden" name="text" id="hc-text" value="">
      <button class="btn btn--lime hc-submit" type="submit"><span><?php echo esc_html( $f['submit'] ); ?></span><?php sraik_i( 'arrow-right', 16, 2, 'ico-arrow' ); ?></button>
    </form>
    <div class="hc-api-r hc-direct">
      <div class="hc-code-blk">
        <p class="hc-code-h"><span class="hc-ml"><?php echo esc_html( $s['direct_l'] ); ?></span></p>
        <dl class="hc-dl">
          <?php foreach ( $s['direct'] as $d ) : ?>
          <div>
            <dt class="hc-ml"><?php echo esc_html( $d[0] ); ?></dt>
            <dd><?php if ( $d[2] ) : ?><a href="<?php echo esc_url( $d[2] ); ?>"><?php echo esc_html( $d[1] ); ?></a><?php else : ?><?php echo esc_html( $d[1] ); ?><?php endif; ?></dd>
          </div>
          <?php endforeach; ?>
        </dl>
      </div>
      <div class="hc-code-blk">
        <p class="hc-code-h"><span class="hc-ml"><?php echo esc_html( $s['net_l'] ); ?></span></p>
        <?php echo sraik_socials(); // phpcs:ignore ?>
      </div>
    </div>
  </div>
</section>
<script>
/* Compose the WhatsApp message from the fields (the live form's behaviour). */
(function () {
	var f = document.getElementById('hc-form');
	if (!f) { return; }
	f.addEventListener('submit', function () {
		var v = function (id) { var el = document.getElementById(id); return el ? el.value.trim() : ''; };
		document.getElementById('hc-text').value =
			'Name: ' + v('hc-name') + '\nPhone: ' + v('hc-phone') + '\nSubject: ' + v('hc-subject') + '\n\n' + v('hc-details');
	});
}());
</script>
