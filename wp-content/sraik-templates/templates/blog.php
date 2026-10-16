<?php
/**
 * blog.php — /blog/ (and /blog/page/N/) plus every post archive: category,
 * tag, author, date and search. Code Craft "blog" layout.
 *
 * The main query is already the right list of posts (router.php turns
 * /blog/ into a paginated posts query; blog.php keeps changelog/incident
 * posts off it), so this file only walks it:
 *   hero → featured post (page 1 of /blog/ only) → "Latest articles" grid
 *   → pagination → CTA → footer.
 *
 * Copy: inc/content/blog.php · Styles: blog.css (cards) + blog-page.css
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wp_query;

$c      = sraik_content( 'blog' );
$bp_view   = sraik_view();
$bp_paged  = max( 1, (int) get_query_var( 'paged' ) );
$bp_total  = (int) $wp_query->max_num_pages;
$bp_found  = (int) $wp_query->found_posts;
$bp_hidden = sraik_hidden_cat_ids();

/* ---------- hero copy: /blog/ or the archive being viewed ---------- */
$bp_hero = $c['hero'];
$bp_kind = '';
if ( 'archive' === $bp_view ) {
	$bp_name = '';
	$bp_desc = '';
	if ( is_search() ) {
		$bp_kind = 'search';
		$bp_name = get_search_query( false );
	} elseif ( is_category() || is_tag() ) {
		$bp_kind = is_category() ? 'category' : 'tag';
		$bp_name = single_term_title( '', false );
		$bp_desc = term_description();
	} elseif ( is_author() ) {
		$bp_kind = 'author';
		$bp_name = get_the_author_meta( 'display_name', (int) get_query_var( 'author' ) );
		$bp_desc = get_the_author_meta( 'description', (int) get_query_var( 'author' ) );
	} elseif ( is_date() ) {
		$bp_kind = 'date';
		if ( is_day() ) {
			$bp_name = get_the_date( 'F j, Y' );
		} elseif ( is_month() ) {
			$bp_name = get_the_date( 'F Y' );
		} else {
			$bp_name = get_the_date( 'Y' );
		}
	}
	if ( $bp_kind ) {
		$bp_hero = array(
			'eyebrow' => $c['archive'][ $bp_kind ][0],
			'title'   => sprintf( $c['archive'][ $bp_kind ][1], esc_html( $bp_name ) ),
			'sub'     => '' !== trim( wp_strip_all_tags( (string) $bp_desc ) )
				? esc_html( wp_strip_all_tags( $bp_desc ) )
				: sprintf( 'search' === $bp_kind ? $c['archive']['found'] : $c['archive']['count'], sraik_bn( $bp_found ) ),
		);
	}
}

/* ---------- featured post: newest sticky, else the newest post ---------- */
$bp_featured = null;
if ( 'blog' === $bp_view && 1 === $bp_paged && have_posts() ) {
	$bp_sticky = array_filter( array_map( 'intval', (array) get_option( 'sticky_posts' ) ) );
	if ( $bp_sticky ) {
		$bp_s = get_posts(
			array(
				'post__in'            => $bp_sticky,
				'numberposts'         => 1,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => true,
				'category__not_in'    => $bp_hidden,
			)
		);
		$bp_featured = $bp_s ? $bp_s[0] : null;
	}
	if ( ! $bp_featured ) {
		foreach ( $wp_query->posts as $bp_p ) {
			if ( ! $bp_hidden || ! has_category( $bp_hidden, $bp_p ) ) {
				$bp_featured = $bp_p;
				break;
			}
		}
	}
}

/* ---------- the grid: the main query minus the featured post ---------- */
$bp_cards = array();
foreach ( $wp_query->posts as $bp_p ) {
	if ( $bp_featured && (int) $bp_p->ID === (int) $bp_featured->ID ) {
		continue;
	}
	/* WordPress prepends sticky posts without the category filter. */
	if ( 'blog' === $bp_view && $bp_hidden && has_category( $bp_hidden, $bp_p ) ) {
		continue;
	}
	$bp_cards[] = $bp_p;
}

$bp_note = $bp_total > 1 ? sprintf( $c['note_pg'], $bp_found, $bp_paged, $bp_total ) : sprintf( $c['note'], $bp_found );

sraik_page_css( array( 'css/blog.css', 'css/blog-page.css' ) );
sraik_part( 'head.php' );
sraik_part( 'nav.php' );
?>
<main id="main" class="page">

  <section class="hero bp-hero" aria-labelledby="bp-title">
    <?php sraik_hero_bg( false ); ?>
    <div class="bp-hero-in">
      <?php echo sraik_eyebrow( $bp_hero['eyebrow'] ); // phpcs:ignore ?>
      <h1 class="t-display bp-title" id="bp-title" data-appear style="--ad:.1s"><?php sraik_t( $bp_hero['title'] ); ?></h1>
      <p class="bp-sub" data-appear style="--ad:.2s"><?php sraik_t( $bp_hero['sub'] ); ?></p>
    </div>
  </section>

  <?php if ( $bp_featured ) : ?>
  <section class="bp-feat" aria-label="<?php echo esc_attr( $c['featured'] ); ?>">
    <div class="bp-feat-in">
      <?php sraik_part( 'blog/featured.php', array( 'post_obj' => $bp_featured, 'c' => $c ) ); ?>
    </div>
  </section>
  <?php endif; ?>

  <section class="bp-list" aria-labelledby="bp-latest">
    <div class="bp-list-in">
      <?php if ( $bp_cards || $bp_featured ) : ?>
      <div class="bp-list-head" data-appear>
        <h2 class="t-h5" id="bp-latest"><?php echo esc_html( 'search' === $bp_kind ? $c['results'] : $c['latest'] ); ?></h2>
        <p class="bp-note"><?php echo esc_html( $bp_note ); ?></p>
      </div>
      <?php endif; ?>

      <?php if ( $bp_cards ) : ?>
      <div class="pgrid">
        <?php
        foreach ( $bp_cards as $bp_p ) {
          echo sraik_post_card( $bp_p, '(max-width:809px) calc(100vw - 56px), (max-width:1199px) calc(50vw - 46px), 336px' ); // phpcs:ignore
        }
        ?>
      </div>
      <?php elseif ( ! $bp_featured ) : ?>
        <?php
        $bp_empty_key = 'search' === $bp_kind ? 'search' : ( 'blog' === $bp_view ? 'blog' : 'other' );
        sraik_part( 'blog/empty.php', array( 'e' => $c['empty'][ $bp_empty_key ], 'search' => 'search' === $bp_kind, 'h_id' => 'bp-latest' ) );
        ?>
      <?php endif; ?>

      <?php
      if ( $bp_total > 1 ) {
        sraik_part( 'blog/pager.php', array( 'pg' => $c['pager'], 'paged' => $bp_paged, 'total' => $bp_total ) );
      }
      ?>
    </div>
  </section>

</main>
<?php
sraik_part( 'cta.php', array( 'cta' => $c['cta'] ) );
sraik_part( 'footer.php' );
sraik_part( 'foot.php' );
