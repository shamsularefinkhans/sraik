<?php
/**
 * features/stats.php — the four-number strip. Real figures only (live
 * copy): learners, rating, tests, Shams's own 22 days.
 *
 * $stats = content/features.php ['stats']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="sec fsec-flush" aria-label="<?php echo esc_attr( 'সংখ্যায় MATACE 3.0' ); ?>">
  <div class="fstats-wrap">
    <dl class="fstats" data-appear>
      <?php foreach ( $stats as $st ) : ?>
      <div class="fstat"><dt><?php echo esc_html( $st[0] ); ?></dt><dd><?php echo esc_html( $st[1] ); ?></dd></div>
      <?php endforeach; ?>
    </dl>
  </div>
</section>
