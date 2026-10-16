<?php
/**
 * support/order.php — the WhatsApp order flow in the template's API
 * reference panel: the form's fields on the left ("body parameters"),
 * the message you send and the auto reply's three tasks on the right
 * ("request" / "response").
 *
 * $s = content/support.php ['order']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="hc-sec" id="whatsapp-order" aria-labelledby="hc-order">
  <?php sraik_part( 'support/head.php', array( 's' => $s, 'hid' => 'hc-order' ) ); ?>
  <div class="hc-api" data-appear>
    <div class="hc-api-l">
      <p class="hc-ep"><span class="hc-method"><?php echo esc_html( $s['method'] ); ?></span><a href="<?php echo esc_url( sraik_url( 'whatsapp' ) ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $s['endpoint'] ); ?></a></p>
      <p class="hc-p"><?php echo esc_html( $s['text'] ); ?></p>
      <p class="hc-ml"><?php echo esc_html( $s['fields_l'] ); ?></p>
      <dl class="hc-params">
        <?php foreach ( $s['fields'] as $f ) : ?>
        <div class="hc-param">
          <dt><code><?php echo esc_html( $f[0] ); ?></code><span class="hc-type"><?php echo esc_html( $f[1] ); ?></span><?php echo $f[2] ? '<span class="hc-req">required</span>' : ''; ?></dt>
          <dd><?php echo esc_html( $f[3] ); ?></dd>
        </div>
        <?php endforeach; ?>
      </dl>
    </div>
    <div class="hc-api-r">
      <div class="hc-code-blk">
        <p class="hc-code-h"><span class="hc-ml"><?php echo esc_html( $s['req_l'] ); ?></span><span class="hc-pill"><?php echo esc_html( $s['req_tag'] ); ?></span></p>
        <div class="hc-code">
          <?php foreach ( $s['request'] as $i => $ln ) : ?>
          <p<?php echo 0 === $i ? ' class="is-head"' : ''; ?>><?php if ( '' === $ln[1] ) : ?><span class="k-teal"><?php echo esc_html( $ln[0] ); ?></span><?php else : ?><span class="k-ind"><?php echo esc_html( $ln[0] ); ?></span> <span class="k-dim"><?php echo esc_html( $ln[1] ); ?></span><?php endif; ?></p>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="hc-code-blk">
        <p class="hc-code-h"><span class="hc-ml"><?php echo esc_html( $s['res_l'] ); ?></span><span class="hc-pill hc-pill--teal"><?php echo esc_html( $s['res_tag'] ); ?></span></p>
        <div class="hc-code">
          <?php foreach ( $s['response'] as $ln ) : ?>
          <p class="hc-code-li"><span class="k-teal"><?php echo esc_html( $ln[0] ); ?></span><span><?php echo esc_html( $ln[1] ); ?></span></p>
          <?php endforeach; ?>
          <p class="hc-code-note k-dim"><?php echo esc_html( $s['res_note'] ); ?></p>
        </div>
      </div>
    </div>
  </div>
</section>
