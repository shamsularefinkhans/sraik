<?php
/**
 * content/changelog.php — copy for /changelog/ (templates/page-changelog.php).
 *
 * The entries themselves are WordPress posts in the 'changelog' category
 * (inc/config.php → blog.changelog_cat); nothing here is release history.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'hero'     => array(
		'eyebrow'   => 'Changelog',
		'title'     => 'What’s new in <span class="hl">SRAIK</span>',
		'sub'       => 'SRAIK-এর নতুন ফিচার, ইমপ্রুভমেন্ট আর ফিক্স — sraik.com থেকে vip.sraik.com পর্যন্ত, তারিখসহ সবকিছু এক জায়গায়।',
		'primary'   => array( 'Read the blog', '/blog/' ),
		'secondary' => array( 'Get support', '/support/' ),
	),

	/* Card chrome. */
	'release'  => 'SRAIK update',
	'label'    => 'Update',      /* category chip when a post has no tag / 'label' field */

	'per_page' => 10,
	'newer'    => 'Newer updates',
	'older'    => 'Older updates',

	/* Shown while the category is empty. */
	'empty'    => array(
		'label' => 'Coming soon',
		'big'   => 'SRAIK',
		'title' => 'আপডেটগুলো এখানেই আসবে',
		'text'  => 'SRAIK-এ নতুন কোনো ফিচার, ইমপ্রুভমেন্ট বা ফিক্স যুক্ত হলে তারিখসহ এই পেজে লিখে রাখা হবে। এর মধ্যে নতুন খবর পেতে ব্লগে চোখ রাখো।',
	),
);
