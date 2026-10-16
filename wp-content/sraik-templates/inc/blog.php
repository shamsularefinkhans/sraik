<?php
/**
 * blog.php — everything the templates need to know about a WordPress post.
 *
 * A post written in wp-admin shows up on /blog/, on the home page's
 * "From the blog" row and at its own permalink, styled by the template.
 * The card image is, in order: the featured image, the first image inside
 * the post content, then a neutral gradient placeholder — so a post never
 * renders a broken card.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Card image of a post: array( src, srcset, sizes, w, h, alt ) or null.
 */
function sraik_post_image( $post_id, $size = 'large' ) {
	$thumb = get_post_thumbnail_id( $post_id );
	if ( $thumb ) {
		$src = wp_get_attachment_image_src( $thumb, $size );
		if ( $src ) {
			$alt = get_post_meta( $thumb, '_wp_attachment_image_alt', true );
			return array(
				'src'    => $src[0],
				'w'      => (int) $src[1],
				'h'      => (int) $src[2],
				'srcset' => (string) wp_get_attachment_image_srcset( $thumb, $size ),
				'alt'    => $alt ? $alt : wp_strip_all_tags( get_the_title( $post_id ) ),
			);
		}
	}
	/* No featured image: the first <img> in the content. */
	$content = (string) get_post_field( 'post_content', $post_id );
	if ( preg_match( '/<img[^>]+src=["\']([^"\']+)["\']/i', $content, $m ) ) {
		$id = attachment_url_to_postid( preg_replace( '/-\d+x\d+(?=\.[a-z]+$)/i', '', $m[1] ) );
		if ( $id ) {
			$src = wp_get_attachment_image_src( $id, $size );
			if ( $src ) {
				return array(
					'src'    => $src[0],
					'w'      => (int) $src[1],
					'h'      => (int) $src[2],
					'srcset' => (string) wp_get_attachment_image_srcset( $id, $size ),
					'alt'    => wp_strip_all_tags( get_the_title( $post_id ) ),
				);
			}
		}
		return array( 'src' => $m[1], 'w' => 0, 'h' => 0, 'srcset' => '', 'alt' => wp_strip_all_tags( get_the_title( $post_id ) ) );
	}
	return null;
}

/** <img> tag for a post image (or the placeholder). */
function sraik_post_img_tag( $post_id, $size = 'large', $sizes = '(max-width:809px) 100vw, 360px', $eager = false ) {
	$img = sraik_post_image( $post_id, $size );
	if ( ! $img ) {
		return '<span class="post-ph" aria-hidden="true">' . sraik_bolt_svg() . '</span>';
	}
	$attrs = ' src="' . esc_url( $img['src'] ) . '"';
	if ( $img['srcset'] ) {
		$attrs .= ' srcset="' . esc_attr( $img['srcset'] ) . '" sizes="' . esc_attr( $sizes ) . '"';
	}
	if ( $img['w'] && $img['h'] ) {
		$attrs .= ' width="' . (int) $img['w'] . '" height="' . (int) $img['h'] . '"';
	}
	$attrs .= ' alt="' . esc_attr( $img['alt'] ) . '"';
	$attrs .= $eager ? ' fetchpriority="high" decoding="async"' : ' loading="lazy" decoding="async"';
	return '<img' . $attrs . '>';
}

/** Primary category: array( name, url, slug ) — Yoast/RankMath primary first. */
function sraik_post_cat( $post_id ) {
	$primary = (int) get_post_meta( $post_id, '_yoast_wpseo_primary_category', true );
	if ( ! $primary ) {
		$primary = (int) get_post_meta( $post_id, 'rank_math_primary_category', true );
	}
	$term = $primary ? get_term( $primary, 'category' ) : null;
	if ( ! $term || is_wp_error( $term ) ) {
		$cats = get_the_category( $post_id );
		$term = $cats ? $cats[0] : null;
	}
	if ( ! $term || 'uncategorized' === $term->slug ) {
		return array( 'name' => 'Article', 'url' => home_url( '/blog/' ), 'slug' => '' );
	}
	return array( 'name' => $term->name, 'url' => get_category_link( $term ), 'slug' => $term->slug );
}

/**
 * Reading time in minutes. Bengali and English words both count as words;
 * 200 wpm is the usual figure for mixed-script reading.
 */
function sraik_read_time( $post_id ) {
	$text  = wp_strip_all_tags( strip_shortcodes( (string) get_post_field( 'post_content', $post_id ) ) );
	$words = preg_split( '/\s+/u', trim( $text ), -1, PREG_SPLIT_NO_EMPTY );
	return max( 1, (int) ceil( count( $words ) / 200 ) );
}

/** "SEP 18, 2026 · 6 MIN READ" meta line. */
function sraik_post_meta_line( $post_id ) {
	return esc_html( strtoupper( get_the_date( 'M j, Y', $post_id ) ) ) . ' <span class="sep">·</span> ' . (int) sraik_read_time( $post_id ) . ' MIN READ';
}

/** Author display name (falls back to the configured name). */
function sraik_post_author( $post_id ) {
	$name = get_the_author_meta( 'display_name', (int) get_post_field( 'post_author', $post_id ) );
	return $name ? $name : sraik_config( 'blog' )['fallback_author'];
}

/** Plain-text excerpt of N words. */
function sraik_post_excerpt( $post_id, $words = 24 ) {
	$ex = (string) get_post_field( 'post_excerpt', $post_id );
	if ( '' === trim( $ex ) ) {
		$ex = (string) get_post_field( 'post_content', $post_id );
	}
	return wp_trim_words( wp_strip_all_tags( strip_shortcodes( $ex ) ), $words, '…' );
}

/** Category ids hidden from the blog list (changelog, incidents). */
function sraik_hidden_cat_ids() {
	$ids = array();
	foreach ( (array) sraik_config( 'blog' )['hide_from_blog'] as $slug ) {
		$t = get_category_by_slug( $slug );
		if ( $t ) {
			$ids[] = (int) $t->term_id;
		}
	}
	return $ids;
}

/** Keep changelog / incident posts off /blog/ and the home page row. */
function sraik_blog_exclude( $q ) {
	if ( is_admin() || ! $q->is_main_query() ) {
		return;
	}
	if ( 'blog' === $q->get( 'sraik_route' ) || ( $q->is_home() && ! $q->get( 'sraik_route' ) ) ) {
		$ids = sraik_hidden_cat_ids();
		if ( $ids ) {
			$q->set( 'category__not_in', $ids );
		}
	}
}
add_action( 'pre_get_posts', 'sraik_blog_exclude', 20 );

/** Latest N posts for a row of cards. */
function sraik_latest_posts( $n = 3, $exclude = array() ) {
	return get_posts(
		array(
			'numberposts'      => $n,
			'post_status'      => 'publish',
			'post__not_in'     => (array) $exclude,
			'category__not_in' => sraik_hidden_cat_ids(),
			'suppress_filters' => false,
		)
	);
}

/** One blog card (home row, blog grid, single "keep reading"). */
function sraik_post_card( $post, $sizes = '(max-width:809px) calc(100vw - 40px), 336px' ) {
	$id  = $post->ID;
	$cat = sraik_post_cat( $id );
	ob_start();
	?>
	<a class="pcard" href="<?php echo esc_url( get_permalink( $id ) ); ?>" data-appear>
	  <span class="pcard-media">
	    <?php echo sraik_post_img_tag( $id, 'medium_large', $sizes ); // phpcs:ignore ?>
	    <span class="pcard-cat"><?php echo esc_html( $cat['name'] ); ?></span>
	  </span>
	  <span class="pcard-body">
	    <span class="pcard-meta"><?php echo sraik_post_meta_line( $id ); // phpcs:ignore ?></span>
	    <span class="pcard-title"><?php echo esc_html( wp_strip_all_tags( get_the_title( $id ) ) ); ?></span>
	    <span class="pcard-ex"><?php echo esc_html( sraik_post_excerpt( $id, 22 ) ); ?></span>
	  </span>
	  <span class="pcard-foot">
	    <span class="pcard-author"><?php echo esc_html( sraik_post_author( $id ) ); ?></span>
	    <span class="pcard-read">Read <?php sraik_i( 'arrow-up-right', 16 ); ?></span>
	  </span>
	</a>
	<?php
	return ob_get_clean();
}

/** Article schema for single posts. */
function sraik_post_schema( $post_id ) {
	$img = sraik_post_image( $post_id, 'large' );
	return array(
		'@context'      => 'https://schema.org',
		'@type'         => 'BlogPosting',
		'headline'      => wp_strip_all_tags( get_the_title( $post_id ) ),
		'description'   => sraik_post_excerpt( $post_id, 30 ),
		'image'         => $img ? $img['src'] : null,
		'datePublished' => get_the_date( 'c', $post_id ),
		'dateModified'  => get_the_modified_date( 'c', $post_id ),
		'author'        => array( '@type' => 'Person', 'name' => sraik_post_author( $post_id ) ),
		'publisher'     => array( '@type' => 'Organization', 'name' => 'SRAIK', 'url' => home_url( '/' ) ),
		'mainEntityOfPage' => get_permalink( $post_id ),
	);
}

/**
 * Headings inside the post get ids so a table of contents / deep links work.
 * Only on our single template; editor content is otherwise untouched.
 */
function sraik_heading_ids( $content ) {
	if ( 'single' !== sraik_view() || ! in_the_loop() ) {
		return $content;
	}
	$used = array();
	return preg_replace_callback(
		'#<h([2-3])([^>]*)>(.*?)</h\1>#is',
		function ( $m ) use ( &$used ) {
			if ( preg_match( '/\sid=/', $m[2] ) ) {
				return $m[0];
			}
			$slug = sanitize_title( wp_strip_all_tags( $m[3] ) );
			if ( '' === $slug ) {
				$slug = 'section';
			}
			$base = $slug;
			$i    = 2;
			while ( isset( $used[ $slug ] ) ) {
				$slug = $base . '-' . $i++;
			}
			$used[ $slug ] = true;
			return '<h' . $m[1] . $m[2] . ' id="' . esc_attr( $slug ) . '">' . $m[3] . '</h' . $m[1] . '>';
		},
		$content
	);
}
add_filter( 'the_content', 'sraik_heading_ids', 20 );
