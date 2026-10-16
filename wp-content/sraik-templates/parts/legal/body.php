<?php
/**
 * legal/body.php — sticky contents sidebar ([data-toc]) + the numbered
 * sections. Each section holds the live text twice, as data-panel="en"
 * and data-panel="bn" (the Bengali one hidden until the reader switches
 * language in the meta card), plus its plain-English note.
 *
 * $doc, $ui, $related, $slug — see templates/page-legal.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$allowed = array(
	'p'      => array(),
	'br'     => array(),
	'ul'     => array(),
	'li'     => array(),
	'strong' => array(),
);
$email = sraik_contact( 'email' );
?>
<section class="lg-body" id="lg-doc" aria-label="<?php echo esc_attr( wp_strip_all_tags( $doc['eyebrow'] ) ); ?>">
  <div class="lg-body-in">
    <aside class="lg-side">
      <nav class="lg-toc" data-toc aria-label="<?php echo esc_attr( $ui['contents'] ); ?>">
        <div class="lg-toc-grp">
          <span class="lg-toc-l"><?php echo esc_html( $ui['contents'] ); ?></span>
          <div class="lg-toc-list">
            <?php foreach ( $doc['sections'] as $i => $sec ) : ?>
            <a href="#<?php echo esc_attr( $sec['id'] ); ?>"><span data-panel="en"><?php echo esc_html( $sec['title'][0] ); ?></span><span data-panel="bn" lang="bn" hidden><?php echo esc_html( $sec['title'][1] ); ?></span></a>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="lg-toc-grp">
          <span class="lg-toc-l"><?php echo esc_html( $ui['related'] ); ?></span>
          <div class="lg-toc-list">
            <?php foreach ( $related as $r ) : ?>
              <?php if ( '/' . $slug . '/' === $r[1] ) { continue; } ?>
            <a href="<?php echo esc_url( sraik_href( $r[1] ) ); ?>"><?php echo esc_html( $r[0] ); ?><?php sraik_i( 'arrow-up-right', 12, 2 ); ?></a>
            <?php endforeach; ?>
          </div>
        </div>
      </nav>
      <div class="lg-help">
        <p class="lg-help-t"><?php echo esc_html( $doc['side'][0] ); ?></p>
        <p class="lg-help-p"><?php echo esc_html( $doc['side'][1] ); ?></p>
        <a class="lg-help-a" href="<?php echo esc_url( 'mailto:' . $email ); ?>"><?php echo esc_html( $doc['side'][2] ); ?><?php sraik_i( 'arrow-up-right', 14, 2 ); ?></a>
      </div>
    </aside>

    <div class="lg-secs">
      <?php foreach ( $doc['sections'] as $i => $sec ) : ?>
      <section class="lg-sec" id="<?php echo esc_attr( $sec['id'] ); ?>" aria-labelledby="<?php echo esc_attr( $sec['id'] . '-h' ); ?>">
        <div class="lg-sec-row">
          <div class="lg-sec-main">
            <div class="lg-sec-head">
              <span class="lg-sec-n">§<?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
              <h2 class="t-h5" id="<?php echo esc_attr( $sec['id'] . '-h' ); ?>"><span data-panel="en"><?php echo esc_html( $sec['title'][0] ); ?></span><span data-panel="bn" lang="bn" hidden><?php echo esc_html( $sec['title'][1] ); ?></span></h2>
            </div>
            <div class="lg-prose" data-panel="en" lang="en"><?php echo wp_kses( $sec['en'], $allowed ); ?></div>
            <div class="lg-prose" data-panel="bn" lang="bn" hidden><?php echo wp_kses( $sec['bn'], $allowed ); ?></div>
          </div>
          <aside class="lg-note" aria-label="<?php echo esc_attr( $ui['note'] ); ?>">
            <span class="lg-note-l"><?php sraik_i( 'message-square', 13, 2 ); ?><?php echo esc_html( $ui['note'] ); ?></span>
            <p><?php echo esc_html( $sec['note'] ); ?></p>
          </aside>
        </div>

        <?php if ( ! empty( $sec['table'] ) ) : ?>
          <?php foreach ( array( 'en' => 0, 'bn' => 2 ) as $lang => $col ) : ?>
        <div class="lg-table" data-panel="<?php echo esc_attr( $lang ); ?>" lang="<?php echo esc_attr( $lang ); ?>"<?php echo 'bn' === $lang ? ' hidden' : ''; ?>>
          <div class="lg-table-cap"><?php sraik_i( 'database', 14, 2 ); ?><span><?php echo esc_html( $sec['table']['title'] ); ?></span></div>
          <div class="lg-tr lg-tr--h" aria-hidden="true">
            <?php foreach ( $sec['table']['cols'] as $h ) : ?><span><?php echo esc_html( $h ); ?></span><?php endforeach; ?>
          </div>
          <ul class="lg-tbody">
            <?php foreach ( $sec['table']['rows'] as $r ) : ?>
            <li class="lg-tr">
              <strong><?php echo esc_html( $r[ $col ] ); ?></strong>
              <span><?php echo esc_html( $r[ $col + 1 ] ); ?></span>
              <span><em class="lg-pill"><?php echo esc_html( $r[4] ); ?></em></span>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>
          <?php endforeach; ?>
        <?php endif; ?>

        <?php if ( ! empty( $sec['cards'] ) ) : ?>
        <div class="lg-cards">
          <?php foreach ( $sec['cards'] as $cd ) : ?>
          <div class="lg-cmd">
            <span class="lg-cmd-k"><span aria-hidden="true">$</span><?php echo esc_html( $cd[0] ); ?></span>
            <h3 class="t-title-s"><?php echo esc_html( $cd[1] ); ?></h3>
            <p><?php echo esc_html( $cd[2] ); ?></p>
            <span class="lg-cmd-f" lang="bn"><?php echo esc_html( $cd[3] ); ?></span>
          </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </section>
      <?php endforeach; ?>
    </div>
  </div>
</section>
