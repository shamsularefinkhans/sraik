<?php
/**
 * mbhsc/curriculum.php — a module list as an accordion of glossy cards.
 * Used twice: the recorded Training Curriculum and the Live Session
 * Curriculum. The first module starts open, like the live page.
 *
 * $s = content/mbhsc.php ['curriculum'] | ['live']
 *   modules: array( title, meta, lessons ) — a lesson is a string or
 *   array( name, duration ).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$sid = sanitize_html_class( $s['id'] );
?>
<section class="sec mb-curr" id="<?php echo esc_attr( $sid ); ?>">
  <div class="sec-in">
    <div class="mb-curr-head">
      <?php echo sraik_sh( array( 'eyebrow' => $s['eyebrow'], 'icon' => $s['icon'], 'title' => $s['title'], 'sub' => $s['sub'] ) ); // phpcs:ignore ?>
      <div class="mb-badges" data-appear>
        <?php foreach ( $s['badges'] as $b ) : ?><span class="chip"><b><?php echo esc_html( $b[0] ); ?></b><?php echo esc_html( $b[1] ); ?></span><?php endforeach; ?>
      </div>
    </div>
    <div class="mb-mods" data-acc data-appear>
      <?php
      foreach ( $s['modules'] as $i => $m ) :
        $open = ( 0 === $i );
        $pid  = $sid . '-m' . ( $i + 1 );
        ?>
      <div class="card mb-mod<?php echo $open ? ' is-open' : ''; ?>" data-acc-item>
        <h3 class="mb-mod-h"><button type="button" class="mb-mod-btn" data-acc-btn aria-expanded="<?php echo $open ? 'true' : 'false'; ?>" aria-controls="<?php echo esc_attr( $pid ); ?>">
          <span class="gloss mb-mod-ic" aria-hidden="true"><?php sraik_i( $s['icon'], 16, 1.9 ); ?></span>
          <span class="mb-mod-tx"><span class="mb-mod-meta"><?php echo esc_html( $m[1] ); ?></span><span class="mb-mod-title"><?php echo esc_html( $m[0] ); ?></span></span>
          <span class="mb-mod-n" aria-hidden="true"><?php echo esc_html( sraik_bn( count( $m[2] ) ) ); ?>টি লেসন</span>
          <span class="faq-ic" aria-hidden="true"><?php sraik_i( 'chevron-down', 14, 2.2 ); ?></span>
        </button></h3>
        <div class="mb-mod-a" id="<?php echo esc_attr( $pid ); ?>" data-acc-panel role="region"<?php echo $open ? '' : ' style="height:0"'; ?>>
          <ol class="mb-les">
            <?php
            foreach ( $m[2] as $l ) :
              $l = (array) $l;
              ?>
            <li><span class="mb-les-ic" aria-hidden="true"><?php sraik_i( 'play', 10, 2.4 ); ?></span><span class="mb-les-n"><?php echo esc_html( $l[0] ); ?></span><?php if ( ! empty( $l[1] ) ) : ?><span class="mb-les-d"><?php echo esc_html( $l[1] ); ?></span><?php endif; ?></li>
            <?php endforeach; ?>
          </ol>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php if ( ! empty( $s['note'] ) ) : ?><p class="mb-note-txt" data-appear><?php sraik_t( $s['note'] ); ?></p><?php endif; ?>
  </div>
</section>
