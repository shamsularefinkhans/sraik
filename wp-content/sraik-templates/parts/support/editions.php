<?php
/**
 * support/editions.php — Player, Player Pro mentorship and the AI tools,
 * three linked cards ("Core concepts").
 *
 * $s = content/support.php ['editions']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="hc-sec" id="editions" aria-labelledby="hc-editions">
  <?php sraik_part( 'support/head.php', array( 's' => $s, 'hid' => 'hc-editions' ) ); ?>
  <div class="hc-concepts">
    <?php
    foreach ( $s['cards'] as $i => $k ) :
		$u = sraik_hc_href( $k[4] );
		?>
    <a class="hc-concept" href="<?php echo esc_url( $u ); ?>"<?php echo sraik_link_attrs( $u ); // phpcs:ignore ?> data-appear style="--ad:<?php echo esc_attr( $i * 0.06 ); ?>s">
      <span class="gloss hc-gloss" aria-hidden="true"><?php sraik_i( $k[0], 16, 2 ); ?></span>
      <h3 class="hc-t6"><?php echo esc_html( $k[1] ); ?></h3>
      <p class="hc-p"><?php echo esc_html( $k[2] ); ?></p>
      <span class="hc-more"><?php echo esc_html( $k[3] ); ?><?php sraik_i( 'arrow-up-right', 14, 2 ); ?></span>
    </a>
    <?php endforeach; ?>
  </div>
</section>
