<?php
/**
 * features/curriculum.php — #curriculum: every module of MATACE 3.0 and
 * its lessons, in the site's FAQ accordion (site.js [data-acc]) so it
 * reads like the template's own accordion. #module-N opens that module.
 *
 * $s = content/features.php ['curriculum']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="sec fsec-flush" id="curriculum">
  <div class="sec-in">
    <div class="fcur-head">
      <?php echo sraik_sh( array( 'eyebrow' => $s['eyebrow'], 'icon' => 'list-checks', 'title' => $s['title'], 'sub' => $s['sub'] ) ); // phpcs:ignore ?>
      <ul class="fcur-badges" data-appear style="--ad:.1s">
        <?php foreach ( $s['badges'] as $b ) : ?>
        <li class="fpill"><?php sraik_i( $b[0], 14, 2 ); ?><span><b><?php echo esc_html( $b[1] ); ?></b> <?php echo esc_html( $b[2] ); ?></span></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div class="faq-list fcur" data-acc data-appear>
      <?php
      foreach ( $s['modules'] as $i => $m ) :
        $n    = $i + 1;
        $open = 0 === $i;
        $id   = 'module-' . $n;
        ?>
      <div class="faq-item<?php echo $open ? ' is-open' : ''; ?>" id="<?php echo esc_attr( $id ); ?>" data-acc-item>
        <h3 class="faq-q-wrap">
          <button type="button" class="faq-q" data-acc-btn aria-expanded="<?php echo $open ? 'true' : 'false'; ?>" aria-controls="<?php echo esc_attr( $id . '-a' ); ?>">
            <span class="fcur-q"><span class="fcur-n"><?php echo esc_html( 'MODULE ' . sprintf( '%02d', $n ) . ' · ' . count( $m['lessons'] ) . ' ITEMS' ); ?></span><span><?php echo esc_html( $m['title'] ); ?></span></span>
            <span class="faq-ic" aria-hidden="true"><?php sraik_i( 'chevron-down', 14, 2.2 ); ?></span>
          </button>
        </h3>
        <div class="faq-a" id="<?php echo esc_attr( $id . '-a' ); ?>" data-acc-panel role="region"<?php echo $open ? '' : ' style="height:0"'; ?>>
          <ul class="faq-a-in fcur-list">
            <?php foreach ( $m['lessons'] as $l ) : $task = 'task' === $l[0]; ?>
            <li<?php echo $task ? ' class="is-task"' : ''; ?>><?php sraik_i( $task ? 'clipboard-check' : 'circle-play', 16, 1.8 ); ?><span class="sr-only"><?php echo esc_html( $task ? 'এসাইনমেন্ট: ' : 'ভিডিও লেসন: ' ); ?></span><span><?php echo esc_html( $l[1] ); ?></span></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <p class="fnote" data-appear><span class="dot dot--lime"></span><?php echo esc_html( $s['note'] ); ?></p>
  </div>
</section>
