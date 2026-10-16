<?php
/**
 * changelog/entry.php — one timeline row: date + version chip on the left,
 * the release card, title, summary and body on the right.
 *
 * $e = sraik_changelog_entry() fields · $c = content/changelog.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<li class="cl-item" data-appear>
  <?php if ( $e['date'] || $e['version'] ) : ?>
  <div class="cl-meta">
    <?php if ( $e['date'] ) : ?>
    <time class="cl-date" datetime="<?php echo esc_attr( $e['iso'] ); ?>"><?php echo esc_html( $e['date'] ); ?></time>
    <?php endif; ?>
    <?php if ( $e['version'] ) : ?>
    <span class="cl-ver"><?php echo esc_html( $e['version'] ); ?></span>
    <?php endif; ?>
  </div>
  <?php else : ?>
  <div class="cl-meta" aria-hidden="true"></div>
  <?php endif; ?>
  <div class="cl-body">
    <span class="cl-dot" aria-hidden="true"></span>
    <div class="cl-card">
      <div class="cl-card-glow" aria-hidden="true"></div>
      <div class="cl-card-top">
        <span class="cl-chip"><i aria-hidden="true"></i><?php echo esc_html( $e['label'] ); ?></span>
        <span class="cl-brand"><span class="cl-brand-mark" aria-hidden="true"><?php echo sraik_bolt_svg(); // phpcs:ignore ?></span><?php echo esc_html( $c['release'] ); ?></span>
      </div>
      <p class="cl-big" aria-hidden="true"><?php echo esc_html( $e['big'] ); ?></p>
      <div class="cl-orbit" aria-hidden="true">
        <span class="cl-orbit-halo"></span>
        <span class="cl-orbit-line"></span>
        <span class="cl-orbit-ring">
          <span class="cl-orbit-core"><?php sraik_i( 'rocket', 22, 2 ); ?></span>
          <b class="cl-orbit-pin cl-orbit-pin--l"></b>
          <b class="cl-orbit-pin cl-orbit-pin--r"></b>
        </span>
      </div>
    </div>
    <h2 class="t-h4b cl-title"><?php echo esc_html( wp_strip_all_tags( $e['title'] ) ); ?></h2>
    <?php if ( $e['summary'] ) : ?>
    <p class="cl-sum"><?php echo esc_html( $e['summary'] ); ?></p>
    <?php endif; ?>
    <?php if ( $e['content'] ) : ?>
    <div class="cl-content"><?php echo wp_kses_post( $e['content'] ); ?></div>
    <?php endif; ?>
  </div>
</li>
