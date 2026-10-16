<?php
/**
 * legal/hero.php — document tabs, headline and the read-only "<slug>.md"
 * meta card (real facts only: effective date from the live text, reading
 * time computed, owner email) with the English / বাংলা switch.
 *
 * $doc, $ui, $tabs, $slug — see templates/page-legal.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="hero lg-hero" aria-labelledby="lg-title">
  <?php sraik_hero_bg( false ); ?>
  <div class="lg-hero-in">
    <nav class="lg-tabs" aria-label="<?php echo esc_attr( 'Legal documents' ); ?>">
      <?php foreach ( $tabs as $k => $t ) : ?>
      <a href="<?php echo esc_url( home_url( '/' . $k . '/' ) ); ?>"<?php echo $k === $slug ? ' class="is-active" aria-current="page"' : ''; ?>><?php sraik_i( $t[1], 14, 2 ); ?><span><?php echo esc_html( $t[0] ); ?></span></a>
      <?php endforeach; ?>
    </nav>

    <div class="lg-hero-row">
      <div class="lg-copy">
        <?php echo sraik_eyebrow( $doc['eyebrow'] ); // phpcs:ignore ?>
        <h1 class="t-display" id="lg-title" data-appear style="--ad:.1s"><?php sraik_t( $doc['title'] ); ?></h1>
        <p class="lg-sub" data-appear style="--ad:.2s"><?php echo esc_html( $doc['sub'] ); ?></p>
      </div>

      <div class="lg-meta" data-appear style="--ad:.3s">
        <div class="lg-meta-head">
          <span class="lg-meta-file"><?php sraik_i( 'file-text', 14, 2 ); ?><span><?php echo esc_html( $doc['file'] ); ?></span></span>
          <span class="lg-pill"><?php echo esc_html( $ui['readonly'] ); ?></span>
        </div>
        <dl class="lg-meta-rows">
          <?php foreach ( $doc['meta'] as $m ) : ?>
          <div><dt><?php echo esc_html( $m[0] ); ?></dt><dd><?php echo esc_html( $m[1] ); ?></dd></div>
          <?php endforeach; ?>
          <div><dt><?php echo esc_html( $ui['reading'] ); ?></dt><dd><?php echo esc_html( $doc['minutes'] . ' min' ); ?></dd></div>
          <div><dt><?php echo esc_html( $ui['owner'] ); ?></dt><dd><a href="<?php echo esc_url( 'mailto:' . sraik_contact( 'email' ) ); ?>"><?php echo esc_html( sraik_contact( 'email' ) ); ?></a></dd></div>
          <div>
            <dt id="lg-lang-l"><?php echo esc_html( $ui['language'] ); ?></dt>
            <dd class="lg-lang" data-tabs="#lg-doc" role="tablist" aria-labelledby="lg-lang-l">
              <?php $first = true; ?>
              <?php foreach ( $ui['langs'] as $code => $label ) : ?>
              <button type="button" role="tab" data-tab="<?php echo esc_attr( $code ); ?>" class="<?php echo $first ? 'is-active' : ''; ?>" aria-selected="<?php echo $first ? 'true' : 'false'; ?>" lang="<?php echo esc_attr( $code ); ?>"><?php echo esc_html( $label ); ?></button>
                <?php $first = false; ?>
              <?php endforeach; ?>
            </dd>
          </div>
        </dl>
      </div>
    </div>
  </div>
</section>
