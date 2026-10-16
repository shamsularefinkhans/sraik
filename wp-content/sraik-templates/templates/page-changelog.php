<?php
/**
 * page-changelog.php — /changelog/, on the Code Craft changelog layout.
 *
 * Entries are WordPress posts in the 'changelog' category
 * (inc/config.php → blog.changelog_cat), newest first, 10 per page (?pg=2).
 * Per post:
 *   version chip + big card number  custom field 'version', else a tag that
 *                                   looks like a version (v2.4, 3.0.1)
 *   category chip                   custom field 'label', else the first
 *                                   other tag, else "Update"
 *   summary line                    the post's Excerpt (omitted when empty)
 *   body                            the post content (paragraph + list)
 *
 * Copy: inc/content/changelog.php · Styles: assets/css/changelog.css
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * One post → the fields an entry prints (see the header for the mapping).
 */
function sraik_changelog_entry( $post ) {
	$is_ver  = function ( $s ) {
		return (bool) preg_match( '/^v?\d+(\.\d+)+[a-z0-9.-]*$/i', trim( $s ) );
	};
	$version = trim( (string) get_post_meta( $post->ID, 'version', true ) );
	$label   = trim( (string) get_post_meta( $post->ID, 'label', true ) );
	foreach ( (array) get_the_tags( $post->ID ) as $tag ) {
		if ( ! $tag ) {
			continue;
		}
		if ( '' === $version && $is_ver( $tag->name ) ) {
			$version = $tag->name;
		} elseif ( '' === $label && ! $is_ver( $tag->name ) ) {
			$label = $tag->name;
		}
	}
	if ( '' !== $version && 'v' !== strtolower( $version[0] ) && ctype_digit( $version[0] ) ) {
		$version = 'v' . $version;
	}
	return array(
		'date'    => get_the_date( 'M j, Y', $post ),
		'iso'     => get_the_date( 'c', $post ),
		'version' => $version,
		'label'   => '' !== $label ? $label : sraik_content( 'changelog' )['label'],
		/* The card's big mono line: the version, else the release date. */
		'big'     => '' !== $version ? $version : get_the_date( 'M j', $post ),
		'title'   => get_the_title( $post ),
		'summary' => has_excerpt( $post ) ? get_the_excerpt( $post ) : '',
		'content' => apply_filters( 'the_content', get_the_content( null, false, $post ) ), // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals
		'url'     => get_permalink( $post ),
	);
}

$c   = sraik_content( 'changelog' );
$cat = get_category_by_slug( sraik_config( 'blog' )['changelog_cat'] );
$pg  = isset( $_GET['pg'] ) ? max( 1, absint( wp_unslash( $_GET['pg'] ) ) ) : 1; // phpcs:ignore WordPress.Security.NonceVerification

$entries = null;
if ( $cat ) {
	$entries = new WP_Query(
		array(
			'cat'                 => (int) $cat->term_id,
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => (int) $c['per_page'],
			'paged'               => $pg,
			'ignore_sticky_posts' => true,
		)
	);
}

/* ?pg= past the last page: back to the first rather than an empty list. */
if ( $entries && $pg > 1 && $pg > (int) $entries->max_num_pages ) {
	wp_safe_redirect( home_url( '/changelog/' ) );
	exit;
}

sraik_page_css( array( 'css/changelog.css' ) );
sraik_part( 'head.php' );
sraik_part( 'nav.php' );
?>
<main id="main" class="page">
  <section class="hero cl-hero" aria-labelledby="cl-title">
    <?php sraik_hero_bg( false ); ?>
    <div class="cl-hero-in">
      <?php echo sraik_eyebrow( $c['hero']['eyebrow'] ); // phpcs:ignore ?>
      <h1 id="cl-title" class="t-display cl-hero-title"><?php sraik_t( $c['hero']['title'] ); ?></h1>
      <p class="cl-hero-sub"><?php sraik_t( $c['hero']['sub'] ); ?></p>
      <div class="cl-hero-btns">
        <?php echo sraik_btn( $c['hero']['primary'][0], $c['hero']['primary'][1], 'lime', 'arrow-right' ); // phpcs:ignore ?>
        <?php echo sraik_btn( $c['hero']['secondary'][0], $c['hero']['secondary'][1], 'dark' ); // phpcs:ignore ?>
      </div>
    </div>
  </section>

  <section class="sec cl-sec" aria-label="<?php echo esc_attr( wp_strip_all_tags( $c['hero']['eyebrow'] ) ); ?>">
    <div class="cl-in">
      <?php if ( $entries && $entries->have_posts() ) : ?>
      <ol class="cl-list">
        <?php
        while ( $entries->have_posts() ) :
          $entries->the_post();
          sraik_part( 'changelog/entry.php', array( 'e' => sraik_changelog_entry( get_post() ), 'c' => $c ) );
        endwhile;
        wp_reset_postdata();
        ?>
      </ol>
        <?php if ( $entries->max_num_pages > 1 ) : ?>
      <nav class="cl-pager" aria-label="Changelog pages">
          <?php if ( $pg > 1 ) : ?>
            <?php echo sraik_btn( $c['newer'], add_query_arg( 'pg', $pg - 1 > 1 ? $pg - 1 : false, home_url( '/changelog/' ) ), 'dark' ); // phpcs:ignore ?>
          <?php endif; ?>
        <span class="cl-pager-n"><?php echo esc_html( $pg . ' / ' . (int) $entries->max_num_pages ); ?></span>
          <?php if ( $pg < $entries->max_num_pages ) : ?>
            <?php echo sraik_btn( $c['older'], add_query_arg( 'pg', $pg + 1, home_url( '/changelog/' ) ), 'dark', 'arrow-right' ); // phpcs:ignore ?>
          <?php endif; ?>
      </nav>
        <?php endif; ?>
      <?php else : ?>
      <ol class="cl-list">
        <?php
        sraik_part(
          'changelog/entry.php',
          array(
            'c' => $c,
            'e' => array(
              'date'    => '',
              'iso'     => '',
              'version' => '',
              'label'   => $c['empty']['label'],
              'big'     => $c['empty']['big'],
              'title'   => $c['empty']['title'],
              'summary' => $c['empty']['text'],
              'content' => '',
              'url'     => '',
            ),
          )
        );
        ?>
      </ol>
      <?php endif; ?>
    </div>
  </section>
</main>
<?php
sraik_part( 'cta.php' );
sraik_part( 'footer.php' );
sraik_part( 'foot.php' );
