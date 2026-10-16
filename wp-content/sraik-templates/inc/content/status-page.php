<?php
/**
 * content/status-page.php — copy for /status/ (templates/page-status.php).
 * Named -page so it never clashes with the monitor in inc/status.php.
 *
 * Every number on the page comes from the monitor; nothing here is data.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'eyebrow'   => 'System Status',

	/* Headline per overall state: [ plain, highlighted ] */
	'titles'    => array(
		'up'      => array( 'All systems', 'operational' ),
		'deg'     => array( 'Degraded', 'performance' ),
		'partial' => array( 'Partial', 'outage' ),
		'major'   => array( 'Major', 'outage' ),
		'none'    => array( 'Status check', 'in progress' ),
	),
	/* Same, one line, for the summary card. */
	'summary'   => array(
		'up'      => 'All systems operational',
		'deg'     => 'Degraded performance',
		'partial' => 'Partial outage',
		'major'   => 'Major outage',
		'none'    => 'Waiting for the first check',
	),

	'report'    => array( 'Report an issue', sraik_url( 'whatsapp' ) ),
	'subscribe' => array( 'Subscribe to updates', '/blog/' ), /* fallback target; see page-status.php */
	'note'      => 'Checked every 5 minutes · times in BST',

	'components' => 'Components',
	'legend'     => array(
		'up'    => 'Operational',
		'deg'   => 'Degraded',
		'down'  => 'Outage',
		'maint' => 'Maintenance',
		'none'  => 'No data',
	),
	'pill'       => array(
		0  => 'Operational',
		1  => 'Degraded',
		2  => 'Outage',
		-1 => 'No data',
	),

	'perf_title' => 'Performance · last 24 hours',
	/* The two charts: component key from inc/status.php + label. */
	'charts'     => array(
		'site' => 'sraik.com response time',
		'lms'  => 'vip.sraik.com response time',
	),
	'perf_empty' => 'Collecting samples — the chart appears after the next checks.',

	'inc_eyebrow' => 'Incident history',
	'inc_title'   => 'Every incident, in the open',
	'inc_sub'     => 'কোনো সার্ভিসে সমস্যা হলে বা প্ল্যানড মেইনটেন্যান্স থাকলে — কী হয়েছিল, আমরা কী করেছি আর কী বদলেছি — সবকিছু তারিখসহ এখানে লিখে রাখা হয়।',
	'inc_none'    => array(
		'title' => 'No incidents reported',
		'text'  => 'এখন পর্যন্ত কোনো ইনসিডেন্ট রিপোর্ট করা হয়নি। কোনো সমস্যা হলে তার পুরো টাইমলাইন এখানে প্রকাশ করা হবে।',
	),
	'severity'    => array(
		'minor'       => 'Minor incident',
		'major'       => 'Major incident',
		'maintenance' => 'Maintenance',
	),
);
