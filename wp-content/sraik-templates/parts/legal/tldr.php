<?php
/**
 * legal/tldr.php — "TL;DR ——— The short version" + four orb cards.
 *
 * $doc, $ui — see templates/page-legal.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="lg-tldr" aria-labelledby="lg-tldr-h">
  <div class="lg-tldr-in">
    <div class="lg-rule-head">
      <h2 class="lg-rule-l" id="lg-tldr-h"><?php echo esc_html( $ui['tldr'] ); ?></h2>
      <span class="lg-rule" aria-hidden="true"></span>
      <span class="lg-rule-r"><?php echo esc_html( $ui['tldr_r'] ); ?></span>
    </div>
    <div class="lg-tgrid">
      <?php foreach ( $doc['tldr'] as $i => $t ) : ?>
      <div class="card lg-tcard" data-appear style="--ad:<?php echo esc_attr( 0.06 * $i ); ?>s">
        <?php echo sraik_orb( $t[0], array( 'cls' => 'lg-orb' ) ); // phpcs:ignore ?>
        <h3><?php echo esc_html( $t[1] ); ?></h3>
        <p><?php echo esc_html( $t[2] ); ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
