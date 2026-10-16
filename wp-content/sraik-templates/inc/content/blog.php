<?php
/**
 * content/blog.php — the words around the posts on /blog/, the archives
 * (category, tag, author, date, search), single posts and the 404 page.
 *
 * The posts themselves come from WordPress; counts and dates are computed,
 * never typed here.
 *
 * Inline tags allowed in strings: <span class="hl">, <br>, <strong>, <em>, <a>.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(

	/* ───────────────────────── /blog/ HERO ───────────────────────── */
	'hero'     => array(
		'eyebrow' => 'The SRAIK Blog',
		'title'   => 'Insights for <span class="hl">ambitious students</span>',
		'sub'     => 'মেডিকেল এডমিশন স্ট্র্যাটেজি, স্টাডি সিস্টেম আর স্টুডেন্টদের গল্প — যারা এই সিস্টেম বানিয়েছে, সেই SRAIK টিমের লেখা।',
	),

	/* Archive heroes. %s = term / author / date / search words. */
	'archive'  => array(
		'category' => array( 'Category', 'Articles on <span class="hl">%s</span>' ),
		'tag'      => array( 'Tag', 'Articles tagged <span class="hl">%s</span>' ),
		'author'   => array( 'Author', 'Articles by <span class="hl">%s</span>' ),
		'date'     => array( 'Archive', 'Articles from <span class="hl">%s</span>' ),
		'search'   => array( 'Search', 'Results for <span class="hl">“%s”</span>' ),
		/* Sub when the term / author has no description. %s = Bengali count. */
		'count'    => 'এখানে মোট %s টি লেখা আছে — নতুন থেকে পুরনো ক্রমে সাজানো।',
		'found'    => '%s টি লেখা পাওয়া গেছে — নতুন থেকে পুরনো ক্রমে সাজানো।',
	),

	/* Featured card + list header. */
	'featured' => 'Featured',
	'read'     => 'Read article',
	'latest'   => 'Latest articles',
	'results'  => 'Results',
	/* Mono note on the right of the list header: %d articles, page %d of %d. */
	'note'     => '%d articles',
	'note_pg'  => '%1$d articles · page %2$d of %3$d',

	'pager'    => array(
		'label' => 'Blog pages',
		'prev'  => 'Newer',
		'next'  => 'Older',
	),

	'empty'    => array(
		'blog'   => array(
			'title' => 'প্রথম লেখাটা আসছে খুব শিগগিরই',
			'sub'   => 'নতুন লেখা প্রকাশ হলেই এখানে দেখাবে। ততক্ষণে MATACE 3.0-এর ভেতরে কী আছে দেখে নাও।',
			'btn'   => array( 'ট্রেনিং দেখো', '/features/' ),
		),
		'search' => array(
			'title' => 'কিছু পাওয়া যায়নি',
			'sub'   => 'অন্য কোনো শব্দ দিয়ে খুঁজে দেখো, অথবা সব লেখা একসাথে দেখো।',
			'btn'   => array( 'সব পোস্ট দেখো', '/blog/' ),
			'ph'    => 'ব্লগে খুঁজো…',
			'go'    => 'Search',
		),
		'other'  => array(
			'title' => 'এখানে এখনো কোনো লেখা নেই',
			'sub'   => 'নতুন লেখা প্রকাশ হলেই এখানে দেখাবে। ততক্ষণে বাকি লেখাগুলো পড়ে দেখো।',
			'btn'   => array( 'সব পোস্ট দেখো', '/blog/' ),
		),
	),

	/* ───────────────────────── SINGLE POST ───────────────────────── */
	'single'   => array(
		'back'      => 'All posts',
		'by'        => 'Written by',
		'pages'     => 'Pages:',
		'protected' => 'এই লেখাটি পাসওয়ার্ড দিয়ে সুরক্ষিত। পড়তে নিচে পাসওয়ার্ড দাও।',
		'more'      => array(
			'eyebrow' => 'Keep Reading',
			'title'   => 'ব্লগ থেকে আরও',
			'button'  => 'সব পোস্ট দেখো',
		),
	),

	/* ───────────────────────── 404 ───────────────────────── */
	'404'      => array(
		'eyebrow'   => '404',
		'title'     => 'Sector <span class="hl">Not Found</span>',
		'sub'       => 'তুমি ট্রেনিং জোনের বাইরে চলে এসেছো। যে পেজটা খুঁজছো, সেটা আমাদের ইকোসিস্টেমে নেই। চলো, ফোকাসটা আবার সঠিক জায়গায় ফিরিয়ে আনি।',
		'primary'   => array( 'Back To Home', '/' ),
		'secondary' => array( 'Read the Blog', '/blog/' ),
		'posts'     => array(
			'eyebrow' => 'From the Blog',
			'title'   => 'এর বদলে এগুলো পড়ে দেখো',
			'sub'     => 'মেডিকেল এডমিশন স্ট্র্যাটেজি, স্টাডি সিস্টেম আর স্টুডেন্টদের গল্প — SRAIK টিমের সাম্প্রতিক লেখা।',
			'button'  => 'সব পোস্ট দেখো',
		),
	),

	/* ───────────────────────── CTA ───────────────────────── */
	'cta'      => array(
		'eyebrow'   => 'Ready to Play?',
		'title'     => 'তোমার মেডিকেল সিট এক সিদ্ধান্ত দূরে।',
		'sub'       => 'তুমি নিজেও জানো, টাইম বেশি নাই, নিজের ভালো নিজেকেই বুঝতে হবে। ফি আমানিল্লাহ!',
		'primary'   => array( 'যুক্ত হও!', '/#pricing' ),
		'secondary' => array( 'WhatsApp-এ কথা বলো', 'https://wa.me/8801601013241?text=chat' ),
		'checks'    => array( 'লাইফটাইম এক্সেস', 'এককালীন পেমেন্ট', 'ইনস্ট্যান্ট এক্সেস' ),
	),
);
