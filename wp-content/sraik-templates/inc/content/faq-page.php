<?php
/**
 * content/faq-page.php — the chrome around the questions on /faq/
 * (hero, sidebar, closing routes). The questions themselves live in
 * content/faq.php and are read through sraik_tpl_faq_groups().
 *
 * Counts ("75 answers · 8 topics") are computed from the data, never typed here.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'hero'    => array(
		'eyebrow' => 'FAQ',
		'title'   => 'টিকেট না, <span class="hl">সোজা উত্তর।</span>',
		'sub'     => 'MATACE 3.0, ভর্তি, পেমেন্ট আর অ্যাকাউন্ট নিয়ে স্টুডেন্টরা যা যা জিজ্ঞেস করে, সব টপিক ধরে এক জায়গায় সাজানো।',
		/* %1$d answers, %2$d topics — filled from the data. */
		'meta'    => '%1$d answers · %2$d topics',
		'term'    => array(
			'title' => 'zsh — sraik help',
			'cmd'   => 'sraik help --topics',
			'label' => 'Topics',
			'unit'  => 'answers',
			'foot'  => 'Run sraik help <topic> or scroll to browse.',
		),
	),

	'sidebar' => array(
		'topics_l' => 'Topics',
		'more_l'   => 'More help',
		'more'     => array(
			array( 'Support', '/support/' ),
			array( 'System status', '/status/' ),
		),
		'card'     => array(
			'title' => 'খুঁজে পাচ্ছো না?',
			'text'  => 'WhatsApp-এ মেসেজ দাও। সাপোর্ট টিম প্রতিদিন সকাল ৯টা থেকে রাত ৯টা পর্যন্ত সক্রিয়।',
			'link'  => 'WhatsApp-এ কথা বলো',
			'href'  => 'whatsapp', /* key in config 'urls' */
		),
	),

	/* Topic kicker: "§1  PROGRAM ———— 12 answers" */
	'unit'    => 'answers',

	'routes'  => array(
		'kicker' => '$ sraik help --human',
		'title'  => 'এখনও আটকে আছো? একটা রাস্তা বেছে নাও।',
		'cards'  => array(
			array(
				'icon'  => 'headphones',
				'title' => 'Support পেজ',
				'text'  => 'ট্রেনিং, অ্যাকাউন্ট বা পেমেন্ট নিয়ে সাহায্য। ফোন, ইমেইল আর WhatsApp সব এক জায়গায়।',
				'href'  => '/support/',
			),
			array(
				'icon'  => 'message-circle',
				'title' => 'WhatsApp-এ কথা বলো',
				'text'  => 'সাপোর্ট টিম প্রতিদিন সকাল ৯টা থেকে রাত ৯টা পর্যন্ত সক্রিয়।',
				'href'  => 'https://wa.me/8801601013241?text=chat',
			),
			array(
				'icon'  => 'activity',
				'title' => 'সিস্টেম স্ট্যাটাস',
				'text'  => 'sraik.com, vip.sraik.com আর পেমেন্ট সিস্টেমের লাইভ স্ট্যাটাস।',
				'href'  => '/status/',
			),
		),
	),
);
