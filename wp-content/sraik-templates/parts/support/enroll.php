<?php
/**
 * support/enroll.php — enrolling on the website in four numbered steps
 * ("Quickstart"). Each step ends in a mono box; the real addresses carry
 * a copy button (site.js [data-copy]).
 *
 * $s = content/support.php ['enroll']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$last = count( $s['steps'] ) - 1;
?>
<section class="hc-sec" id="enroll" aria-labelledby="hc-enroll">
  <?php sraik_part( 'support/head.php', array( 's' => $s, 'hid' => 'hc-enroll' ) ); ?>
  <ol class="hc-steps">
    <?php foreach ( $s['steps'] as $i => $st ) : ?>
    <li class="hc-step<?php echo $last === $i ? ' is-last' : ''; ?>" data-appear>
      <span class="hc-step-rail" aria-hidden="true"><span class="hc-step-n"><?php echo (int) ( $i + 1 ); ?></span><i></i></span>
      <div class="hc-step-body">
        <h3 class="hc-t6"><?php echo esc_html( $st[0] ); ?></h3>
        <p class="hc-p"><?php echo esc_html( $st[1] ); ?></p>
        <div class="hc-cmd">
          <code><span aria-hidden="true">$ </span><?php echo esc_html( $st[2] ); ?></code>
          <?php if ( $st[3] ) : ?>
          <button class="hc-copy" type="button" data-copy="<?php echo esc_attr( 'https://' . $st[2] ); ?>" aria-label="<?php echo esc_attr( 'Copy ' . $st[2] ); ?>"><?php sraik_i( 'copy', 14, 2, 'hc-copy-a' ); ?><?php sraik_i( 'check', 14, 2.4, 'hc-copy-b' ); ?></button>
          <?php endif; ?>
        </div>
      </div>
    </li>
    <?php endforeach; ?>
  </ol>
</section>
