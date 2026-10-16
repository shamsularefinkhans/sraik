<?php
/**
 * status.php — a small, real uptime monitor behind /status/.
 *
 * Every 5 minutes a WP-Cron event requests each component's URL with a short
 * timeout and records the outcome: up, degraded (answered, but slower than
 * 3 s) or down (no answer / 5xx). Everything lives in ONE option
 * (autoload = no) so the page itself never makes an HTTP request:
 *
 *   'last'    unix time of the last completed run
 *   'current' key => array( s, ms, code, t )        latest result per component
 *   'samples' key => array( array( t, s, ms ) … )   last 24 hours, raw
 *   'days'    key => array( 'Y-m-d' => array( c, u, d, x, ms, n ) )
 *             per Dhaka-time day, last 90 days: checks, up, degraded, down,
 *             summed ms and the number of timed answers behind it
 *
 * Status codes: 0 = up, 1 = degraded, 2 = down.
 *
 * Incidents are not guessed from the data: they are WordPress posts in the
 * 'incidents' category (inc/config.php → blog.incident_cat), written by a
 * person, so a blip of the sandbox network never becomes a public incident.
 *
 * WP-Cron only runs when someone visits the site. On a quiet site, point a
 * server cron at wp-cron.php every 5 minutes for evenly spaced checks.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SRAIK_STATUS_OPTION', 'sraik_status_data' );
define( 'SRAIK_STATUS_HOOK', 'sraik_status_check' );
define( 'SRAIK_STATUS_SLOW_MS', 3000 );
define( 'SRAIK_STATUS_DAYS', 90 );

/**
 * What is monitored. Filter 'sraik_status_components' to add or drop one;
 * keys are stored in the option, so keep a key stable once it has history.
 */
function sraik_status_components() {
	$list = array(
		'site'      => array(
			'name' => 'sraik.com',
			'desc' => 'Website, blog and enrolment pages',
			'url'  => home_url( '/' ),
		),
		'lms'       => array(
			'name' => 'vip.sraik.com',
			'desc' => 'Training platform and class library',
			'url'  => sraik_url( 'lms' ),
		),
		'dashboard' => array(
			'name' => 'Dashboard & login',
			'desc' => 'Student sign-in and dashboard',
			'url'  => sraik_url( 'dashboard' ),
		),
		'payment'   => array(
			'name' => 'Payment gateway',
			'desc' => 'SSLCommerz checkout',
			'url'  => 'https://securepay.sslcommerz.com/',
		),
		'video'     => array(
			'name' => 'Video delivery',
			'desc' => 'YouTube-hosted lessons',
			'url'  => 'https://www.youtube.com/',
		),
	);
	return apply_filters( 'sraik_status_components', $list );
}

/** Bangladesh time — every date and time on /status/ is shown in it. */
function sraik_status_tz() {
	static $tz = null;
	if ( null === $tz ) {
		$tz = new DateTimeZone( 'Asia/Dhaka' );
	}
	return $tz;
}

/** Format a unix time in Dhaka time. */
function sraik_status_date( $format, $ts ) {
	return wp_date( $format, (int) $ts, sraik_status_tz() );
}

/* ---------- schedule ---------- */

function sraik_status_cron_schedules( $schedules ) {
	$schedules['sraik_5min'] = array(
		'interval' => 5 * MINUTE_IN_SECONDS,
		'display'  => 'Every 5 minutes (SRAIK status)',
	);
	return $schedules;
}
add_filter( 'cron_schedules', 'sraik_status_cron_schedules' );

function sraik_status_schedule() {
	if ( ! wp_next_scheduled( SRAIK_STATUS_HOOK ) ) {
		wp_schedule_event( time() + 60, 'sraik_5min', SRAIK_STATUS_HOOK );
	}
}
add_action( 'init', 'sraik_status_schedule' );
add_action( SRAIK_STATUS_HOOK, 'sraik_status_run' );

/**
 * Called while /status/ renders: when the data is older than 10 minutes
 * (cron missed, quiet site) queue a one-off run. WordPress fires it from a
 * separate non-blocking loopback request, so this page view does not wait.
 */
function sraik_status_maybe_refresh( $data ) {
	if ( ! empty( $data['last'] ) && ( time() - (int) $data['last'] ) < 10 * MINUTE_IN_SECONDS ) {
		return;
	}
	if ( get_transient( 'sraik_status_lock' ) ) {
		return;
	}
	$next = wp_next_scheduled( SRAIK_STATUS_HOOK );
	if ( $next && $next <= time() + MINUTE_IN_SECONDS ) {
		return; /* the recurring event is due anyway */
	}
	wp_schedule_single_event( time(), SRAIK_STATUS_HOOK, array( 'once' ) );
}

/* ---------- the check ---------- */

/**
 * Request one URL and classify it. Only the first 2 KB of the body is read:
 * the timing is "how fast does it answer", not "how fast is the full page".
 */
function sraik_status_probe( $url ) {
	$start = microtime( true );
	$res   = wp_remote_get(
		$url,
		array(
			'timeout'             => 10,
			'redirection'         => 3,
			'limit_response_size' => 2048,
			'user-agent'          => 'SRAIK-Status/1.0 (+' . home_url( '/status/' ) . ')',
			'headers'             => array( 'Cache-Control' => 'no-cache' ),
		)
	);
	$ms = (int) round( ( microtime( true ) - $start ) * 1000 );

	if ( is_wp_error( $res ) ) {
		return array( 2, 0, 0 );
	}
	$code = (int) wp_remote_retrieve_response_code( $res );
	if ( $code >= 500 || 0 === $code ) {
		return array( 2, $ms, $code );
	}
	/* 2xx–4xx: the server answered (a 403 from a bot shield is still "up"). */
	return array( $ms > SRAIK_STATUS_SLOW_MS ? 1 : 0, $ms, $code );
}

/** Read the stored data with every key present. */
function sraik_status_data() {
	$d = get_option( SRAIK_STATUS_OPTION, array() );
	if ( ! is_array( $d ) ) {
		$d = array();
	}
	return wp_parse_args(
		$d,
		array(
			'v'       => 1,
			'last'    => 0,
			'current' => array(),
			'samples' => array(),
			'days'    => array(),
		)
	);
}

/** The cron callback: check everything once and fold the results in. */
function sraik_status_run() {
	if ( get_transient( 'sraik_status_lock' ) ) {
		return;
	}
	set_transient( 'sraik_status_lock', 1, 2 * MINUTE_IN_SECONDS );

	$results = array();
	foreach ( sraik_status_components() as $key => $c ) {
		$results[ $key ] = sraik_status_probe( $c['url'] );
	}
	sraik_status_record( $results, time() );

	delete_transient( 'sraik_status_lock' );
}

/**
 * Fold one run's results into the option.
 * $results = key => array( status, ms, http code ).
 */
function sraik_status_record( $results, $now ) {
	$d      = sraik_status_data();
	$day    = sraik_status_date( 'Y-m-d', $now );
	$cutoff = $now - DAY_IN_SECONDS;
	$oldest = sraik_status_date( 'Y-m-d', $now - ( SRAIK_STATUS_DAYS - 1 ) * DAY_IN_SECONDS );

	foreach ( $results as $key => $r ) {
		list( $s, $ms, $code ) = $r;

		$d['current'][ $key ] = array( $s, $ms, $code, $now );

		$samples   = isset( $d['samples'][ $key ] ) ? (array) $d['samples'][ $key ] : array();
		$samples[] = array( $now, $s, $ms );
		$d['samples'][ $key ] = array_values(
			array_filter(
				$samples,
				function ( $x ) use ( $cutoff ) {
					return (int) $x[0] >= $cutoff;
				}
			)
		);

		$days = isset( $d['days'][ $key ] ) ? (array) $d['days'][ $key ] : array();
		if ( ! isset( $days[ $day ] ) ) {
			$days[ $day ] = array( 'c' => 0, 'u' => 0, 'd' => 0, 'x' => 0, 'ms' => 0, 'n' => 0 );
		}
		$days[ $day ]['c']++;
		$days[ $day ][ 0 === $s ? 'u' : ( 1 === $s ? 'd' : 'x' ) ]++;
		if ( 2 !== $s && $ms > 0 ) {
			$days[ $day ]['ms'] += $ms;
			$days[ $day ]['n']++;
		}
		foreach ( array_keys( $days ) as $k ) {
			if ( $k < $oldest ) {
				unset( $days[ $k ] );
			}
		}
		ksort( $days );
		$d['days'][ $key ] = $days;
	}

	$d['last'] = $now;
	update_option( SRAIK_STATUS_OPTION, $d, false );
	return $d;
}

/* ---------- reading it back for the page ---------- */

/** Median of a list of numbers (0 when empty). */
function sraik_status_median( $vals ) {
	$vals = array_values( $vals );
	$n    = count( $vals );
	if ( ! $n ) {
		return 0;
	}
	sort( $vals );
	$mid = (int) floor( $n / 2 );
	return $n % 2 ? $vals[ $mid ] : ( $vals[ $mid - 1 ] + $vals[ $mid ] ) / 2;
}

/** Nearest-rank percentile. */
function sraik_status_pct( $vals, $p ) {
	$vals = array_values( $vals );
	if ( ! $vals ) {
		return 0;
	}
	sort( $vals );
	$i = (int) ceil( $p / 100 * count( $vals ) ) - 1;
	return $vals[ max( 0, min( count( $vals ) - 1, $i ) ) ];
}

/** "142 ms" / "1.4 s". */
function sraik_status_ms( $ms ) {
	$ms = (float) $ms;
	if ( $ms >= 1000 ) {
		return number_format_i18n( $ms / 1000, 1 ) . ' s';
	}
	return number_format_i18n( round( $ms ) ) . ' ms';
}

/** "99.97%" — never rounds a real gap up to 100. */
function sraik_status_pct_label( $up, $total ) {
	if ( ! $total ) {
		return '';
	}
	if ( $up >= $total ) {
		return '100%';
	}
	$v = floor( $up / $total * 10000 ) / 100;
	return rtrim( rtrim( number_format( $v, 2, '.', '' ), '0' ), '.' ) . '%';
}

/** Colour class for a day's summary (or 'none' for a day without checks). */
function sraik_status_day_state( $row ) {
	if ( empty( $row['c'] ) ) {
		return 'none';
	}
	if ( $row['x'] >= 3 ) {
		return 'down';
	}
	if ( $row['x'] > 0 || $row['d'] >= 3 ) {
		return 'deg';
	}
	return 'up';
}

/**
 * Incident posts (newest first) from the configured category, each with
 * its severity, affected line, duration and the days it touched.
 */
function sraik_status_incidents( $limit = 20 ) {
	$cat = get_category_by_slug( sraik_config( 'blog' )['incident_cat'] );
	if ( ! $cat ) {
		return array();
	}
	$posts = get_posts(
		array(
			'cat'              => (int) $cat->term_id,
			'numberposts'      => $limit,
			'post_status'      => 'publish',
			'suppress_filters' => false,
		)
	);
	$out = array();
	foreach ( $posts as $p ) {
		$out[] = array(
			'post'     => $p,
			'severity' => sraik_status_severity( $p->ID ),
			'affected' => trim( (string) get_post_meta( $p->ID, 'affected', true ) ),
			'duration' => trim( (string) get_post_meta( $p->ID, 'duration', true ) ),
			'time'     => (int) get_post_time( 'U', true, $p ),
		);
	}
	return $out;
}

/**
 * Severity of an incident post: custom field 'severity', else a tag named
 * major / minor / maintenance (or "major-incident" …). Default: minor.
 */
function sraik_status_severity( $post_id ) {
	$v = strtolower( trim( (string) get_post_meta( $post_id, 'severity', true ) ) );
	if ( '' === $v ) {
		foreach ( wp_get_post_tags( $post_id, array( 'fields' => 'slugs' ) ) as $slug ) {
			foreach ( array( 'maintenance', 'major', 'minor' ) as $sev ) {
				if ( 0 === strpos( $slug, $sev ) ) {
					$v = $sev;
					break 2;
				}
			}
		}
	}
	return in_array( $v, array( 'major', 'minor', 'maintenance' ), true ) ? $v : 'minor';
}

/**
 * Everything /status/ prints, computed from the option in one pass.
 * No HTTP happens here.
 */
function sraik_status_view() {
	$d     = sraik_status_data();
	$comps = sraik_status_components();
	$now   = time();
	$n     = count( $comps );

	sraik_status_maybe_refresh( $d );

	/* 90 Dhaka-time day keys, oldest first. */
	$keys = array();
	for ( $i = SRAIK_STATUS_DAYS - 1; $i >= 0; $i-- ) {
		$keys[] = sraik_status_date( 'Y-m-d', $now - $i * DAY_IN_SECONDS );
	}

	/* Maintenance windows announced as incident posts, by day. */
	$incidents = sraik_status_incidents();
	$maint     = array();
	foreach ( $incidents as $inc ) {
		if ( 'maintenance' === $inc['severity'] ) {
			$maint[ sraik_status_date( 'Y-m-d', $inc['time'] ) ][] = strtolower( $inc['affected'] );
		}
	}

	$rows      = array();
	$healthy   = 0;
	$worst     = -1;
	$all_c     = 0;
	$all_ok    = 0;
	$days_seen = array();
	$lat_all   = array();

	foreach ( $comps as $key => $c ) {
		$days = isset( $d['days'][ $key ] ) ? $d['days'][ $key ] : array();
		$bars = array();
		$c_n  = 0;
		$ok_n = 0;
		foreach ( $keys as $k ) {
			$row   = isset( $days[ $k ] ) ? $days[ $k ] : array( 'c' => 0 );
			$state = sraik_status_day_state( $row );
			if ( 'none' !== $state ) {
				$c_n            += $row['c'];
				$ok_n           += $row['c'] - $row['x'];
				$days_seen[ $k ] = true;
			}
			/* Downtime on a day with announced maintenance for this component is planned. */
			if ( isset( $maint[ $k ] ) && in_array( $state, array( 'deg', 'down' ), true ) ) {
				foreach ( $maint[ $k ] as $aff ) {
					if ( '' === $aff || false !== strpos( $aff, strtolower( $c['name'] ) ) ) {
						$state = 'maint';
						break;
					}
				}
			}
			$bars[] = array(
				'day'   => $k,
				'state' => $state,
				'row'   => $row,
			);
		}
		$all_c  += $c_n;
		$all_ok += $ok_n;

		$cur = isset( $d['current'][ $key ] ) ? $d['current'][ $key ] : null;
		/* A result older than 30 minutes is not "current" any more. */
		$s = ( $cur && ( $now - (int) $cur[3] ) < 30 * MINUTE_IN_SECONDS ) ? (int) $cur[0] : -1;
		if ( 0 === $s ) {
			$healthy++;
		}
		$worst = max( $worst, $s );

		foreach ( isset( $d['samples'][ $key ] ) ? $d['samples'][ $key ] : array() as $smp ) {
			if ( 2 !== (int) $smp[1] && $smp[2] > 0 ) {
				$lat_all[] = (int) $smp[2];
			}
		}

		$rows[ $key ] = array(
			'name'   => $c['name'],
			'desc'   => $c['desc'],
			'state'  => $s,
			'uptime' => sraik_status_pct_label( $ok_n, $c_n ),
			'bars'   => $bars,
		);
	}

	$down = 0;
	foreach ( $rows as $r ) {
		if ( 2 === $r['state'] ) {
			$down++;
		}
	}
	if ( -1 === $worst || ( $healthy < $n && $worst < 1 ) ) {
		$overall = 'none';    /* not every component has a fresh result yet */
	} elseif ( 0 === $worst ) {
		$overall = 'up';
	} elseif ( 1 === $worst ) {
		$overall = 'deg';
	} else {
		$overall = $down >= $n ? 'major' : 'partial';
	}

	/* Days since the last incident post that was not planned maintenance. */
	$since = null;
	$count = 0;
	foreach ( $incidents as $inc ) {
		if ( $inc['time'] >= $now - SRAIK_STATUS_DAYS * DAY_IN_SECONDS ) {
			$count++;
		}
		if ( null === $since && 'maintenance' !== $inc['severity'] ) {
			$since = (int) floor( ( $now - $inc['time'] ) / DAY_IN_SECONDS );
		}
	}

	return array(
		'last'      => (int) $d['last'],
		'overall'   => $overall,
		'healthy'   => $healthy,
		'total'     => $n,
		'rows'      => $rows,
		'uptime'    => sraik_status_pct_label( $all_ok, $all_c ),
		'days_n'    => count( $days_seen ),
		'median'    => $lat_all ? sraik_status_median( $lat_all ) : 0,
		'incidents' => $incidents,
		'inc_count' => $count,
		'since'     => $since,
		'samples'   => $d['samples'],
	);
}

/**
 * Inline SVG sparkline of one component's last-24h response times
 * (template markup: 600×120 viewBox, dashed guides, teal line + fade).
 * Returns '' when there are fewer than two timed samples.
 */
function sraik_status_spark( $samples, $id ) {
	$now   = time();
	$start = $now - DAY_IN_SECONDS;
	$pts   = array();
	foreach ( (array) $samples as $s ) {
		if ( 2 !== (int) $s[1] && $s[2] > 0 && $s[0] >= $start ) {
			$pts[] = array( (int) $s[0], (int) $s[2] );
		}
	}
	if ( count( $pts ) < 2 ) {
		return '';
	}
	/* Scale to the 95th percentile so one slow outlier cannot flatten the line. */
	$vals = wp_list_pluck( $pts, 1 );
	$max  = max( sraik_status_pct( $vals, 95 ) * 1.25, 1 );
	$span = max( 1, $pts[ count( $pts ) - 1 ][0] - $pts[0][0] );
	$line = '';
	foreach ( $pts as $i => $p ) {
		$x     = ( $p[0] - $pts[0][0] ) / $span * 600;
		$y     = 112 - min( 1, $p[1] / $max ) * 96;
		$line .= ( $i ? ' L' : 'M' ) . number_format( $x, 1, '.', '' ) . ',' . number_format( $y, 1, '.', '' );
	}
	$area = $line . ' L600,120 L0,120 Z';
	$gid  = 'spark-' . sanitize_html_class( $id );

	$svg  = '<svg class="st-spark" viewBox="0 0 600 120" preserveAspectRatio="none" width="100%" height="120" aria-hidden="true" focusable="false">';
	$svg .= '<defs><linearGradient id="' . esc_attr( $gid ) . '" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#6ee7d2" stop-opacity=".28"/><stop offset="100%" stop-color="#6ee7d2" stop-opacity="0"/></linearGradient></defs>';
	foreach ( array( 30, 60, 90 ) as $gy ) {
		$svg .= '<line x1="0" x2="600" y1="' . $gy . '" y2="' . $gy . '" stroke="rgba(255,255,255,.08)" stroke-width="1" vector-effect="non-scaling-stroke" stroke-dasharray="3 4"/>';
	}
	$svg .= '<path d="' . esc_attr( $area ) . '" fill="url(#' . esc_attr( $gid ) . ')"/>';
	$svg .= '<path d="' . esc_attr( $line ) . '" fill="none" stroke="#6ee7d2" stroke-width="2" vector-effect="non-scaling-stroke" stroke-linejoin="round"/>';
	return $svg . '</svg>';
}
