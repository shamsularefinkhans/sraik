<?php
/**
 * config.php — the one place to add a page, change a link, or edit metadata.
 *
 * Page COPY lives in inc/content/<page>.php, one array per page, so the
 * words can be edited without touching any markup.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function sraik_config( $key = null ) {

	static $config = null;

	if ( null === $config ) {
		$config = array(

			/* URL path (no slashes)  =>  file in templates/
			   Each one works with or without a WordPress Page of that slug. */
			'routes'  => array(
				'features'       => 'page-features.php',
				'blog'           => 'blog.php',
				'faq'            => 'page-faq.php',
				'about'          => 'page-about.php',
				'support'        => 'page-support.php',
				'changelog'      => 'page-changelog.php',
				'status'         => 'page-status.php',
				'privacy-policy' => 'page-legal.php',
				'terms'          => 'page-legal.php',
				'refund-policy'  => 'page-legal.php',
				'mbhsc'          => 'page-mbhsc.php',
			),

			'blog'    => array(
				'per_page'        => 9,
				/* Category slugs that feed the changelog / status pages. Posts in
				   them still appear on /blog/ unless listed in 'hide_from_blog'. */
				'changelog_cat'   => 'changelog',
				'incident_cat'    => 'incidents',
				'hide_from_blog'  => array( 'changelog', 'incidents' ),
				'fallback_author' => 'S A Khan Shams',
			),

			/* External destinations */
			'urls'    => array(
				'lms'        => 'https://vip.sraik.com',
				'dashboard'  => 'https://vip.sraik.com/dashboard',
				'training'   => 'https://vip.sraik.com/training/',
				'player'     => 'https://vip.sraik.com/training/player-matace-3-0/',
				'pro'        => 'https://vip.sraik.com/training/pro-matace-3-0/',
				'whatsapp'   => 'https://wa.me/8801601013241?text=chat',
				'wa_live'    => 'https://wa.me/8801601013241?text=LVS%20%7Bjust%20click%20send%7D',
				'wa_channel' => '', /* WhatsApp channel link — fill in to show it on /faq/ */
				'facebook'   => 'https://facebook.com/sraikbyshams',
				'youtube'    => 'https://youtube.com/sraikbyshams',
				'instagram'  => 'https://instagram.com/sraikbyshams',
				'linkedin'   => 'https://linkedin.com/company/sraik',
				'sslcommerz' => 'https://www.sslcommerz.com/',
			),

			/* Contact */
			'contact' => array(
				'email'    => 'shamsfccbd@gmail.com',
				'whatsapp' => '+8801601013241',
				'phone'    => '01601013241',
				'address'  => '123 Sheikh Mujib Road, Chowmuhani Agrabad, Chittagong, Bangladesh',
			),

			/* Header navigation (desktop). 'route' links resolve to home_url. */
			'nav'     => array(
				array( 'label' => 'Training', 'href' => '/features/' ),
				array( 'label' => 'Pricing', 'href' => '/#pricing' ),
				array( 'label' => 'Blog', 'href' => '/blog/' ),
				array( 'label' => 'Support', 'href' => '/support/' ),
			),

			/* Mobile menu adds a few more rows. */
			'nav_mobile' => array(
				array( 'label' => 'Training', 'href' => '/features/' ),
				array( 'label' => 'Curriculum', 'href' => '/features/#curriculum' ),
				array( 'label' => 'Pricing', 'href' => '/#pricing' ),
				array( 'label' => 'Blog', 'href' => '/blog/' ),
				array( 'label' => 'Support', 'href' => '/support/' ),
				array( 'label' => 'Log In', 'href' => 'https://vip.sraik.com/dashboard' ),
			),

			/* Footer link columns */
			'footer'  => array(
				'tagline' => 'নিজের সেরাটা দিতে চাওয়া স্টুডেন্টদের জন্য একটি ডিসিপ্লিনড ট্রেনিং ইকোসিস্টেম।',
				'cols'    => array(
					'Training' => array(
						array( 'Features', '/features/' ),
						array( 'Pricing', '/#pricing' ),
						array( 'Curriculum', '/features/#curriculum' ),
					),
					'Company'  => array(
						array( 'About', '/about/' ),
						array( 'Blog', '/blog/' ),
						array( 'Programs', '/about/#programs' ),
					),
					'Support'  => array(
						array( 'FAQ', '/faq/' ),
						array( 'Contact', '/support/' ),
						array( 'Status', '/status/' ),
						array( 'Change Log', '/changelog/' ),
					),
					'Legal'    => array(
						array( 'Privacy', '/privacy-policy/' ),
						array( 'Terms', '/terms/' ),
						array( 'Refund', '/refund-policy/' ),
					),
				),
				'copyright' => '© %Y SRAIK. All rights reserved.',
				'wordmark'   => 'SRAIK.COM',
				'wordmark_w' => '83.6', /* measured width of the word, see parts/footer.php */
			),

			/* Per-view <title>, description and share image. */
			'meta'    => array(
				'home'           => array(
					'title' => 'MATACE 3.0 — মেডিকেল এডমিশন ট্রেনিং | SRAIK',
					'desc'  => 'কোচিংয়ের ক্লাস, টেনশন আর ১৪ ধরনের মেটেরিয়ালসের ফাঁদ bypass করে মেডিকেলে একটি সরকারি সিট ছিনিয়ে নেওয়ার কমপ্লিট হাইব্রিড ট্রেনিং সিস্টেম — MATACE 3.0 by S A Khan Shams.',
					'image' => 'https://sraik.com/wp-content/uploads/2026/06/glb.jpg',
				),
				'mbhsc'          => array(
					'title' => 'Mission: Bypass HSC — SRAIK',
					'desc'  => 'Mission: Bypass HSC by SRAIK — a high-performance system for ambitious students.',
					'image' => 'https://sraik.com/wp-content/uploads/2026/06/glb.jpg',
				),
				'features'       => array(
					'title' => 'Training — MATACE 3.0 | SRAIK',
					'desc'  => 'AI Gems, মিলিটারি গ্রেড রুটিন, ১০০+ মেডিকেল স্ট্যান্ডার্ড টেস্ট আর সরাসরি মেন্টরশিপ — MATACE 3.0-এর ভেতরে যা যা পাচ্ছো।',
				),
				'blog'           => array(
					'title' => 'Blog — SRAIK',
					'desc'  => 'মেডিকেল এডমিশন স্ট্র্যাটেজি, স্টাডি সিস্টেম আর স্টুডেন্টদের গল্প — SRAIK টিমের লেখা।',
				),
				'archive'        => array(
					'title' => 'Blog — SRAIK',
					'desc'  => 'মেডিকেল এডমিশন স্ট্র্যাটেজি, স্টাডি সিস্টেম আর স্টুডেন্টদের গল্প — SRAIK টিমের লেখা।',
				),
				'faq'            => array(
					'title' => 'FAQ — SRAIK',
					'desc'  => 'MATACE 3.0, ভর্তি, পেমেন্ট আর অ্যাকাউন্ট নিয়ে সব প্রশ্নের সরাসরি উত্তর।',
				),
				'about'          => array(
					'title' => 'About Us | SRAIK',
					'desc'  => 'A disciplined modern training ecosystem for ambitious individuals.',
				),
				'support'        => array(
					'title' => 'Support — SRAIK',
					'desc'  => 'Get help with your SRAIK training, account or payment.',
				),
				'changelog'      => array(
					'title' => 'Changelog — SRAIK',
					'desc'  => 'SRAIK-এর নতুন ফিচার, আপডেট আর ফিক্স — সব এক জায়গায়।',
				),
				'status'         => array(
					'title' => 'System Status — SRAIK',
					'desc'  => 'sraik.com, vip.sraik.com আর পেমেন্ট সিস্টেমের লাইভ স্ট্যাটাস।',
				),
				'terms'          => array(
					'title' => 'Terms and Conditions — SRAIK',
					'desc'  => 'The terms governing your use of SRAIK.',
				),
				'privacy-policy' => array(
					'title' => 'Privacy Policy — SRAIK',
					'desc'  => 'How SRAIK collects, uses and protects your data.',
				),
				'refund-policy'  => array(
					'title' => 'Refund Policy — SRAIK',
					'desc'  => 'SRAIK refund terms and how to request one.',
				),
				'404'            => array(
					'title' => 'Page Not Found — SRAIK',
					'desc'  => 'That page does not exist.',
				),
			),
		);
	}

	if ( null === $key ) {
		return $config;
	}
	return isset( $config[ $key ] ) ? $config[ $key ] : array();
}

/** Shorthand for a contact detail from config. */
function sraik_contact( $name, $fallback = '' ) {
	$c = sraik_config( 'contact' );
	return isset( $c[ $name ] ) ? $c[ $name ] : $fallback;
}

/** Shorthand for an external URL from config. */
function sraik_url( $name, $fallback = '#' ) {
	$urls = sraik_config( 'urls' );
	return isset( $urls[ $name ] ) ? $urls[ $name ] : $fallback;
}

/** Page copy from inc/content/<name>.php (cached per request). */
function sraik_content( $name ) {
	static $cache = array();
	if ( ! isset( $cache[ $name ] ) ) {
		$file           = SRAIK_TPL_DIR . '/inc/content/' . preg_replace( '/[^a-z0-9-]/', '', $name ) . '.php';
		$cache[ $name ] = file_exists( $file ) ? include $file : array();
	}
	return $cache[ $name ];
}
