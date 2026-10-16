<?php
/**
 * faq.php — FAQ data access + the accordion markup shared by the home
 * page and /faq/.
 *
 * Source: inc/content/faq.php. If the "SRAIK FAQ Manager" plugin is active
 * and exposes its data through the 'sraik_faq_groups' filter, that wins,
 * so FAQs edited in wp-admin flow straight to the site.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** All FAQ groups: array of array( slug, title, icon, items[ id, q, a ] ). */
function sraik_faq_groups() {
	static $groups = null;
	if ( null === $groups ) {
		$groups = apply_filters( 'sraik_faq_groups', sraik_content( 'faq' ) );
	}
	return is_array( $groups ) ? $groups : array();
}

/** One question by id (or null). */
function sraik_faq_find( $id ) {
	foreach ( sraik_faq_groups() as $g ) {
		foreach ( $g['items'] as $it ) {
			if ( $it['id'] === $id ) {
				return $it;
			}
		}
	}
	return null;
}

/** Answer HTML, with links made site-relative and stripped of anything unsafe. */
function sraik_faq_answer( $html ) {
	$html = preg_replace_callback(
		'#href="(/[^"]*)"#',
		function ( $m ) {
			return 'href="' . esc_url( sraik_href( $m[1] ) ) . '"';
		},
		$html
	);
	return wp_kses(
		$html,
		array(
			'p'      => array(),
			'br'     => array(),
			'ul'     => array(),
			'ol'     => array(),
			'li'     => array(),
			'strong' => array(),
			'b'      => array(),
			'em'     => array(),
			'span'   => array( 'class' => true ),
			'a'      => array( 'href' => true, 'target' => true, 'rel' => true ),
		)
	);
}

/**
 * Accordion items.
 *   $items  list of array( id, q, a )
 *   $open   index open on load (-1: none)
 */
function sraik_faq_list( $items, $open = 0, $cls = 'faq' ) {
	ob_start();
	foreach ( array_values( $items ) as $i => $it ) {
		$is   = ( $i === $open );
		$id   = 'q-' . sanitize_title( $it['id'] );
		$a_id = $id . '-a';
		?>
		<div class="<?php echo esc_attr( $cls ); ?>-item<?php echo $is ? ' is-open' : ''; ?>" id="<?php echo esc_attr( $id ); ?>" data-acc-item>
		  <h3 class="<?php echo esc_attr( $cls ); ?>-q-wrap"><button type="button" class="<?php echo esc_attr( $cls ); ?>-q" data-acc-btn aria-expanded="<?php echo $is ? 'true' : 'false'; ?>" aria-controls="<?php echo esc_attr( $a_id ); ?>"><span><?php echo esc_html( $it['q'] ); ?></span><span class="<?php echo esc_attr( $cls ); ?>-ic" aria-hidden="true"><?php sraik_i( 'chevron-down', 14, 2.2 ); ?></span></button></h3>
		  <div class="<?php echo esc_attr( $cls ); ?>-a" id="<?php echo esc_attr( $a_id ); ?>" data-acc-panel role="region"<?php echo $is ? '' : ' style="height:0"'; ?>><div class="<?php echo esc_attr( $cls ); ?>-a-in"><?php echo sraik_faq_answer( $it['a'] ); // phpcs:ignore ?></div></div>
		</div>
		<?php
	}
	return ob_get_clean();
}
