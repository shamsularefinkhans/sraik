<?php
/**
 * home/trust.php — the logo ticker under the hero ("Powering 20,000+ teams"
 * in the template). Institution crests are shown monochrome, like the
 * template's logos, with their short name beside them.
 *
 * $t = content/home.php ['trust']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="trust" aria-label="<?php echo esc_attr( $t['title'] ); ?>">
  <div class="trust-in">
    <p class="trust-title"><?php echo esc_html( $t['title'] ); ?></p>
    <div class="marquee" data-appear>
      <?php for ( $copy = 0; $copy < 2; $copy++ ) : ?>
      <ul class="marquee-track"<?php echo $copy ? ' aria-hidden="true"' : ''; ?>>
        <?php foreach ( $t['items'] as $it ) : ?>
        <li><img src="<?php echo esc_url( $t['base'] . $it[1] ); ?>" alt="" width="24" height="24" loading="lazy" decoding="async"><span><?php echo esc_html( $it[0] ); ?></span></li>
        <?php endforeach; ?>
      </ul>
      <?php endfor; ?>
    </div>
  </div>
</section>
