<?php
/**
 * features/compare.php — MATACE 3.0 vs conventional coaching, as the
 * template's capability table. Only contrasts the live copy itself makes.
 *
 * $s = content/features.php ['compare']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$hd = $s['head'];
?>
<section class="sec fsec-flush" id="compare">
  <div class="sec-in">
    <?php echo sraik_sh( array( 'eyebrow' => $s['eyebrow'], 'title' => $s['title'], 'sub' => $s['sub'] ) ); // phpcs:ignore ?>
    <div class="fcmp" role="table" aria-label="<?php echo esc_attr( $hd[1] . ' বনাম ' . $hd[2] ); ?>" data-appear>
      <div class="fcmp-row fcmp-row--head" role="row">
        <span class="fcmp-c fcmp-c--l" role="columnheader"><?php echo esc_html( $hd[0] ); ?></span>
        <span class="fcmp-c fcmp-c--us" role="columnheader"><span class="fcmp-mark" aria-hidden="true"><?php echo sraik_bolt_svg(); // phpcs:ignore ?></span><span><?php echo esc_html( $hd[1] ); ?></span></span>
        <span class="fcmp-c fcmp-c--them" role="columnheader"><?php echo esc_html( $hd[2] ); ?></span>
      </div>
      <?php foreach ( $s['rows'] as $r ) : ?>
      <div class="fcmp-row" role="row">
        <span class="fcmp-c fcmp-c--l" role="rowheader"><?php echo esc_html( $r[0] ); ?></span>
        <span class="fcmp-c fcmp-c--us" role="cell"><?php sraik_i( 'circle-check', 20, 1.8 ); ?><span class="sr-only"><?php echo esc_html( 'আছে' ); ?></span></span>
        <span class="fcmp-c fcmp-c--them" role="cell">
          <?php if ( '' === $r[1] ) : ?>
          <?php sraik_i( 'minus', 18, 1.6 ); ?><span class="sr-only"><?php echo esc_html( 'নেই' ); ?></span>
          <?php else : ?>
          <span class="fcmp-txt"><?php echo esc_html( $r[1] ); ?></span>
          <?php endif; ?>
        </span>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
