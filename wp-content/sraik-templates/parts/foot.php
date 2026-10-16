<?php
/**
 * foot.php — closing scripts and </body></html>.
 * All scripts are deferred; nothing blocks first paint.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<script src="<?php echo esc_url( sraik_asset( 'js/lenis.min.js' ) ); ?>" defer></script>
<script src="<?php echo esc_url( sraik_asset( 'js/aurora.js' ) ); ?>" defer></script>
<script src="<?php echo esc_url( sraik_asset( 'js/site.js' ) ); ?>" defer></script>
<?php foreach ( sraik_page_js() as $sraik_js ) : ?>
<script src="<?php echo esc_url( sraik_asset( $sraik_js ) ); ?>" defer></script>
<?php endforeach; ?>
<?php
/* SRAIK Player: mounts into any [data-sraik-video] box. The loader is tiny
   and inline; the player's own JS/CSS download only once the page is idle
   and a video box is near the screen (see assets/player/sraik-video.js). */
$sraik_pl = function ( $f ) {
	return file_exists( SRAIK_TPL_DIR . '/assets/player/' . $f . '.min.js' ) ? 'player/' . $f . '.min.js' : 'player/' . $f . '.js';
};
if ( file_exists( SRAIK_TPL_DIR . '/assets/player/sraik-video.js' ) ) :
	?>
<script>
window.SRAIK_PLAYER = <?php echo wp_json_encode( array( 'js' => sraik_asset( $sraik_pl( 'sraik-player' ) ), 'css' => sraik_asset( 'player/sraik-player.css' ) ) ); ?>;
<?php sraik_inline( $sraik_pl( 'sraik-video' ) ); ?>
</script>
<?php endif; ?>
</body>
</html>
