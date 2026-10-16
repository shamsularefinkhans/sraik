<?php
/**
 * about/journey.php — four steps on a dotted rail ("Hiring process"):
 * a student's path from enrolment to mentorship. The last dot is lit.
 *
 * $s = content/about.php ['journey']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$last = count( $s['steps'] ) - 1;
?>
<section class="sec" id="journey">
  <div class="sec-in ab-sec">
    <?php echo sraik_sh( array( 'eyebrow' => $s['eyebrow'], 'title' => $s['title'], 'sub' => $s['sub'] ) ); // phpcs:ignore ?>
    <ol class="ab-steps">
      <?php foreach ( $s['steps'] as $i => $st ) : ?>
      <li class="ab-step<?php echo $last === $i ? ' is-on' : ''; ?>" data-appear style="--ad:<?php echo esc_attr( $i * 0.08 ); ?>s">
        <span class="ab-step-rail" aria-hidden="true"><i></i><b></b></span>
        <span class="ab-step-n"><?php echo esc_html( sprintf( $s['step_l'], $i + 1 ) ); ?></span>
        <h3 class="t-title-s"><?php echo esc_html( $st[0] ); ?></h3>
        <p><?php echo esc_html( $st[1] ); ?></p>
      </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
