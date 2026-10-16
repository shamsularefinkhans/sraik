<?php
/**
 * support/head.php — a guide section's heading: glossy icon, mono teal
 * label, hairline, then the title and one line of intro.
 *
 * $s   = a section array with label, icon, title, sub
 * $hid = id of the <h2> (the section is labelled by it)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="hc-sh" data-appear>
  <div class="hc-kick">
    <span class="gloss hc-gloss" aria-hidden="true"><?php sraik_i( $s['icon'], 16, 2 ); ?></span>
    <span class="hc-kick-l"><?php echo esc_html( $s['label'] ); ?></span>
    <span class="hc-rule" aria-hidden="true"></span>
  </div>
  <h2 class="t-h4b" id="<?php echo esc_attr( $hid ); ?>"><?php sraik_t( $s['title'] ); ?></h2>
  <p class="hc-sub"><?php sraik_t( $s['sub'] ); ?></p>
</div>
