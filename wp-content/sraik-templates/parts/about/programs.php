<?php
/**
 * about/programs.php — the programs as list rows ("Open roles" in the
 * template): name + one line, a teal category tag, two neutral tags and a
 * round arrow. Footer "Programs" links land here (#programs).
 *
 * $s = content/about.php ['programs']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="sec" id="programs">
  <div class="sec-in ab-sec ab-sec--list">
    <?php echo sraik_sh( array( 'eyebrow' => $s['eyebrow'], 'title' => $s['title'], 'sub' => $s['sub'] ) ); // phpcs:ignore ?>
    <ul class="ab-rows">
      <?php
      foreach ( $s['rows'] as $r ) :
		$href = sraik_href( 0 === strpos( $r[5], '/' ) ? $r[5] : sraik_url( $r[5] ) );
		?>
      <li data-appear>
        <a class="ab-row" href="<?php echo esc_url( $href ); ?>"<?php echo sraik_link_attrs( $href ); // phpcs:ignore ?>>
          <span class="ab-row-txt">
            <span class="ab-row-t"><?php echo esc_html( $r[0] ); ?></span>
            <span class="ab-row-d"><?php echo esc_html( $r[1] ); ?></span>
          </span>
          <span class="ab-row-tags">
            <span class="ab-tag ab-tag--teal"><?php echo esc_html( $r[2] ); ?></span>
            <span class="ab-tag"><?php sraik_i( $r[3][0], 12, 2 ); ?><?php echo esc_html( $r[3][1] ); ?></span>
            <span class="ab-tag"><?php echo esc_html( $r[4] ); ?></span>
          </span>
          <span class="ab-row-go" aria-hidden="true"><?php sraik_i( 'arrow-up-right', 16, 2 ); ?></span>
        </a>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
