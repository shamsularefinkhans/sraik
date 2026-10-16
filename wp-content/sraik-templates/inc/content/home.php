<?php
/**
 * content/home.php — every word on the front page (MATACE 3.0).
 *
 * Section order follows the template: hero → trust marquee → why (bento)
 * → what's inside (6 cards) → how to join (3 steps) → mentorship → wall of
 * love → pricing → FAQ → blog → CTA. Copy is the live sraik.com copy,
 * trimmed to the length each template slot was designed for.
 *
 * Inline tags allowed in strings: <span class="hl">, <br>, <strong>, <em>, <a>.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(

	/* ───────────────────────── HERO ───────────────────────── */
	'hero' => array(
		'badge_tag'   => 'অফার',
		'badge_text'  => 'অফার শেষ ১২ নভেম্বর রাত ১১:৫৯ — যুক্ত হও আজই',
		/* Live countdown inside the badge. Empty string turns it off. */
		'deadline'    => '2026-11-12T23:59:00+06:00',
		'badge_href'  => '#pricing',
		'title'       => 'মেডিকেল চান্স actually<br><span class="hl">সহজ?</span>',
		'sub'         => 'কোচিংয়ের ক্লাস, টেনশন, negative marks আর ১৪ ধরনের মেটেরিয়ালসের ফাঁদ bypass করে মেডিকেলে সরকারি সিট ছিনিয়ে নেওয়ার কমপ্লিট হাইব্রিড ট্রেনিং সিস্টেম — MATACE 3.0।',
		'primary'     => array( 'যুক্ত হও!', '#pricing' ),
		'secondary'   => array( 'ভিডিওটি দেখো', '#intro' ),
		'note'        => '★ 4.9/5 based on 1,763 reviews · Trusted by 8,756+ learners',

		/* The product window under the hero. */
		'window'      => array(
			'tab_1'    => 'MATACE 3.0 · Intro',
			'tab_2'    => 'roadmap.pdf',
			'status'   => 'Enrollment is Live',
			'prompt_l' => 'Program',
			'prompt'   => 'সর্বনিম্ন অবস্থা থেকে মেডিকেল এডমিশনে সর্বোচ্চ রেজাল্ট — রেকর্ড সময়ে।',
			'toggle'   => array( 'Player', 'Pro' ),
			'stack_l'  => 'Subjects',
			'stack'    => array( 'Physics', 'Chemistry', 'Biology', 'English', 'GK' ),
			'checks_l' => 'Included',
			'checks'   => array( '7 AI Gems — ২৪/৭ ডাউট সলভিং', 'Military Grade Routine 2.0', '১০০+ মেডিকেল স্ট্যান্ডার্ড টেস্ট' ),
			/* Intro video: YouTube id, start second, poster. */
			'video'    => 'pA0KZjAy2j8',
			'start'    => 1736,
			'poster'   => 'https://i.ytimg.com/vi/pA0KZjAy2j8/maxresdefault.jpg',
			'caption'  => 'Mission: Bypass HSC — ইন্ট্রোডাকশন',
			'yt_link'  => 'https://youtu.be/pA0KZjAy2j8?t=1736',
		),
	),

	/* ───────────────────────── TRUST MARQUEE ───────────────────────── */
	'trust' => array(
		'title' => 'আমাদের লার্নাররা পড়ছে দেশের সেরা প্রতিষ্ঠানগুলোতে',
		'items' => array(
			array( 'DMC', 'dhaka%20medical%20college.webp' ),
			array( 'CMC', 'chittagong%20medical%20college.webp' ),
			array( 'BUET', 'buet.webp' ),
			array( 'AFMC', 'afmc.webp' ),
			array( 'CUET', 'cuet.webp' ),
			array( 'DU', 'dhaka%20university.webp' ),
			array( 'CU', 'chittagong%20university.webp' ),
			array( 'SUST', 'sust.webp' ),
			array( 'BMA', 'bangladesh%20army.webp' ),
			array( 'MMC', 'mymensingh%20medical%20college.webp' ),
			array( 'CuMC', 'comilla%20medical%20college.webp' ),
			array( 'SOMC', 'sylhet%20medical%20college.webp' ),
			array( 'BAFA', 'bangladesh%20air%20force.webp' ),
			array( 'BNA', 'bangladesh%20navy.webp' ),
		),
		'base'  => 'https://sraik.com/wp-content/uploads/logos/',
	),

	/* ───────────────────────── WHY (bento) ───────────────────────── */
	'why' => array(
		'eyebrow' => 'Why MATACE 3.0',
		'title'   => 'কেন ম্যাট এইস ৩.০ অনন্য?',
		'sub'     => 'বিচ্ছিন্ন গাইড ও কোচিংয়ের দৌড়াদৌড়ি বাদ দিয়ে একটি একক সেন্ট্রাল সিস্টেমে তোমার ফুল মেডিকেল প্রস্তুতি।',
		'cards'   => array(
			array(
				'tag'   => 'Self Study System',
				'icon'  => 'layers',
				'title' => 'ডিপেন্ডেন্সি মুক্ত সেলফ স্টাডি সিস্টেম',
				'text'  => 'কোচিং তোমাকে তাদের ওপর নির্ভরশীল রাখতে চায়। আমরা শেখাই এমন সিস্টেম, যাতে তুমি নিজেই প্রশ্ন প্যাটার্ন বুঝে প্রস্তুতি গুছিয়ে নিতে পারো।',
				'orbit' => array( 'atom', 'flask-conical', 'dna', 'languages', 'globe', 'brain' ),
			),
			array(
				'tag'   => 'Retrieval Formula',
				'icon'  => 'activity',
				'title' => 'একটি MCQ-তে চারটি প্রশ্ন শেখা',
				'text'  => 'শুধু উত্তর মুখস্থ নয় — বাকি তিনটি অপশন কেন হলো না, সেগুলো কিসের উত্তর তা বের করার অপশন এনালাইসিস টেকনিক।',
				'gauge' => array( '×৪', 'MCQ Retrieval' ),
				'chip'  => '১টি MCQ · ৪টি প্রশ্ন শেখা',
			),
			array(
				'tag'   => 'One Payment',
				'icon'  => 'shield-check',
				'title' => 'এক পেমেন্টে কমপ্লিট সলিউশন',
				'text'  => 'আলাদা ক্র্যাশ কোর্স, এক্সাম ব্যাচ বা স্পেশাল শীটের নামে বারবার টাকা খরচের দিন শেষ।',
				'chips' => array(
					array( 'wallet', 'এককালীন পেমেন্ট' ),
					array( 'infinity', 'লাইফটাইম এক্সেস' ),
					array( 'lock', 'SSLCOMMERZ' ),
				),
			),
			array(
				'tag'   => 'Anchor Mirror Method',
				'icon'  => 'git-merge',
				'title' => 'অ্যাঙ্কর মিরর কোচিং মেথড',
				'text'  => 'দুইটি অফলাইন কোচিংকে বুদ্ধিমত্তার সাথে ব্যবহারের কৌশল — একটিতে ফুল প্রিপারেশনে এক্সাম, অন্যটিতে কোল্ড টেস্টে নিজের রেসিডুয়াল নলেজ যাচাই।',
				'diff'  => array( 'coaching-a · full prep', 'coaching-b · cold test' ),
			),
		),
	),

	/* ───────────────────────── WHAT'S INSIDE (6 cards) ───────────────────────── */
	'inside' => array(
		'eyebrow' => "What's Inside",
		'title'   => 'ট্রেনিং এর ভেতরে কী পাচ্ছো?',
		'sub'     => 'থিওরি ক্লাসের ফাতরামি নেই — প্রতিটি টুল আর লেসন বানানো একটাই লক্ষ্যে: মেডিকেলে তোমার সিট।',
		'cards'   => array(
			array( 'bot', '7 AI Gems', 'রিয়েল টাইম মেডিকেল স্ট্যান্ডার্ড প্রশ্ন, এমসিকিউ সলভার আর ২৪/৭ ডাউট ক্লিয়ারিং প্লেমেকার জেম।' ),
			array( 'list-checks', 'অ্যাকশন ভিত্তিক কারিকুলাম', 'সিঙ্গেল মেইন বই মাস্টার, এরিয়া মার্কিং আর ভুলের খাতার স্টেপ বাই স্টেপ ব্লুপ্রিন্ট।' ),
			array( 'clipboard-check', '১০০+ মডেল টেস্ট', 'বিএমডিসি ও স্বাস্থ্য অধিদপ্তরের মানদণ্ডে চ্যাপ্টার, সাবজেক্ট ও ফুল মডেল টেস্ট।' ),
			array( 'alarm-clock', 'মিলিটারি গ্রেড রুটিন', 'সকাল ১০টার পিক পারফরম্যান্স নিশ্চিত করা বায়োলজিক্যাল ক্লক প্রোটোকল।' ),
			array( 'users', 'লাইভ মেন্টরশিপ', 'সপ্তাহে ৫ দিন দুপুর ৩টা–৫টা সরাসরি সামসের সাথে ওয়ান টু ওয়ান ডিসকাশন।' ),
			array( 'notebook-pen', 'ভুলের খাতা টেমপ্লেট', 'প্রতিটি ভুল ট্র্যাক করে দ্রুত গ্যাপ ফিলাপ করার ডিজিটাল টেমপ্লেট।' ),
		),
	),

	/* ───────────────────────── HOW TO JOIN (3 steps) ───────────────────────── */
	'steps' => array(
		'eyebrow' => 'How to Join',
		'title'   => 'তিন ধাপে শুরু করো',
		'sub'     => 'প্ল্যান বেছে নেওয়া থেকে প্রথম লেসন — পুরো প্রসেস দুই মিনিটের।',
		'items'   => array(
			array(
				'icon'  => 'pen-line',
				'title' => 'প্ল্যান বেছে নাও',
				'text'  => 'Player বা Pro — নিজের দরকার অনুযায়ী Access Now চাপো।',
				'ill'   => array( 'input' => 'Player Pro Edition · ৳৪,৯৯০', 'chips' => array( 'Player', 'Pro' ) ),
			),
			array(
				'icon'  => 'sparkles',
				'title' => 'পেমেন্ট করো',
				'text'  => 'বিকাশ, নগদ, রকেট বা কার্ড — SSLCOMMERZ-এর মাধ্যমে নিরাপদ পেমেন্ট।',
				'ill'   => array( 'chip' => 'bKash · Nagad · Card', 'pct' => 78 ),
			),
			array(
				'icon'  => 'git-branch',
				'title' => 'সাথে সাথে শুরু করো',
				'text'  => 'পেমেন্টের পরই ড্যাশবোর্ডে এনরোলড — প্রথম লেসন থেকেই কাজ শুরু।',
				'ill'   => array( 'tag' => 'vip.sraik.com', 'chip' => 'Enrolled · Lifetime' ),
			),
		),
	),

	/* ───────────────────────── MENTORSHIP (integrations layout) ───────────────────────── */
	'mentor' => array(
		'eyebrow' => 'Direct Access',
		'title'   => 'সরাসরি সামসের সাথে কথা বলো',
		'text'    => 'গুগল মিট ও হোয়াটসঅ্যাপে যুক্ত হয়ে নিজের প্রতিটি ডাউট ক্লিয়ার করার সুযোগ — সপ্তাহে ৫ দিন, দুপুর ৩টা থেকে ৫টা।',
		'link'    => array( 'Player Pro Edition দেখো', '#pricing' ),
		'badge'   => '৫ দিন · ৩টা–৫টা',
	),

	/* ───────────────────────── WALL OF LOVE ───────────────────────── */
	'love' => array(
		'eyebrow' => 'Real Feedback',
		'title'   => 'স্টুডেন্টরা নিজেরাই বলছে',
		'sub'     => 'Training চলাকালীন স্টুডেন্টদের সরাসরি ফিডব্যাক — কোনো এডিট নেই, WhatsApp থেকে সরাসরি।',
		'rating'  => '4.9/5',
		'reviews' => 'based on 1,763 reviews',
		'more'    => 'আরও দেখুন',
	),

	/* ───────────────────────── PRICING ───────────────────────── */
	'pricing' => array(
		'eyebrow' => 'Investment',
		'title'   => 'তোমার প্রিপারেশন অনুযায়ী প্ল্যান',
		'sub'     => 'কোনো মাসিক ফি নেই — এক পেমেন্টে লাইফটাইম এক্সেস। অফার শেষে দাম রেগুলার প্রাইসে ফিরে যাবে।',
		'toggle'  => array( 'offer' => 'অফার প্রাইস', 'regular' => 'রেগুলার প্রাইস' ),
		'plans'   => array(
			array(
				'name'     => 'Free',
				'price'    => array( 'offer' => '৳০', 'regular' => '৳০' ),
				'period'   => array( 'forever' ),
				'desc'     => 'শুরু করার আগে স্বাদ নিতে চাইলে',
				'primary'  => array( 'WhatsApp-এ যুক্ত হও', 'whatsapp' ),
				'second'   => array( 'FAQ দেখো', '/faq/' ),
				'feat_l'   => 'যা পাচ্ছো:',
				'features' => array( 'দাগানো বই PDF কালেকশন', 'Past year questions', 'ডেইলি রুটিন PDF', 'AI প্রশ্নের স্যাম্পল' ),
			),
			array(
				'name'     => 'Player',
				'price'    => array( 'offer' => '৳১,৯৯০', 'regular' => '৳৩,০০০' ),
				'period'   => array( 'এককালীন' ),
				'desc'     => 'নিজে পড়ে নিজে এগোতে পারো, শুধু রোডম্যাপ দরকার',
				'primary'  => array( 'শুরু করো', 'player' ),
				'second'   => array( 'কারিকুলাম দেখো', '/features/#curriculum' ),
				'feat_l'   => 'Free-এর সব, সাথে:',
				'features' => array( 'কমপ্লিট ৮ মডিউল ট্রেনিং', '১০০+ মেডিকেল স্ট্যান্ডার্ড টেস্ট', 'MCQ Solver ও Playmaker Gem', 'মিলিটারি গ্রেড রুটিন' ),
			),
			array(
				'name'     => 'Pro',
				'badge'    => 'Popular',
				'price'    => array( 'offer' => '৳৪,৯৯০', 'regular' => '৳৮,০০০' ),
				'period'   => array( 'এককালীন', '২ মাস মেন্টরশিপ' ),
				'desc'     => 'সরাসরি কথা বলা আর ফিডব্যাক চাইলে',
				'primary'  => array( 'সিট বুক করো', 'pro' ),
				'second'   => array( 'WhatsApp-এ অর্ডার', 'whatsapp' ),
				'feat_l'   => 'Player-এর সব, সাথে:',
				'features' => array( 'সামসের সাথে ওয়ান টু ওয়ান', 'উইকলি লাইভ মাস্টারক্লাস', 'ম্যাট কোশ্চেন ল্যাব', 'প্রাইভেট গ্রুপ এক্সেস' ),
				'popular'  => true,
			),
			array(
				'name'     => 'Live Only',
				'price'    => array( 'offer' => 'Custom', 'regular' => 'Custom' ),
				'period'   => array(),
				'desc'     => 'শুধু লাইভ সেশনে জয়েন করতে চাইলে',
				'primary'  => array( 'WhatsApp Hotline', 'wa_live' ),
				'second'   => array( 'লাইভ সেশন দেখো', '/features/#live' ),
				'feat_l'   => 'যা পাচ্ছো:',
				'features' => array( '১২টি লাইভ সেশন', 'মেডিকেল, ISSB ও Digital ক্যারিয়ার রোডম্যাপ', 'সকল লাইভের রেকর্ড', 'লাইফটাইম রেকর্ড এক্সেস' ),
			),
		),
		'note'    => '',
	),

	/* ───────────────────────── FAQ (first six of /faq/) ───────────────────────── */
	'faq' => array(
		'eyebrow' => 'Frequently Asked Questions',
		'title'   => 'যা জানতে চাও, সব এখানে',
		'sub'     => 'প্রোগ্রাম, দাম আর ভর্তি নিয়ে সবচেয়ে কমন প্রশ্নগুলোর সরাসরি জবাব। বাকি সব পাবে FAQ পেজে।',
		/* Question ids from inc/content/faq.php, shown in this order. */
		'ids'     => array( 'what-is', 'first-year', 'results-when', 'player-vs-pro', 'price', 'how-enroll' ),
	),

	/* ───────────────────────── BLOG ROW ───────────────────────── */
	'blog' => array(
		'eyebrow' => 'From the Blog',
		'title'   => 'SRAIK টিমের লেখা',
		'sub'     => 'মেডিকেল এডমিশন স্ট্র্যাটেজি, স্টাডি সিস্টেম আর স্টুডেন্টদের গল্প — যারা এই সিস্টেম বানিয়েছে তাদের লেখা।',
		'button'  => 'সব পোস্ট দেখো',
	),

	/* ───────────────────────── CTA ───────────────────────── */
	'cta' => array(
		'eyebrow'   => 'Ready to Play?',
		'title'     => 'তোমার মেডিকেল সিট এক সিদ্ধান্ত দূরে।',
		'sub'       => 'তুমি নিজেও জানো, টাইম বেশি নাই, নিজের ভালো নিজেকেই বুঝতে হবে। ফি আমানিল্লাহ!',
		'primary'   => array( 'যুক্ত হও!', '#pricing' ),
		'secondary' => array( 'WhatsApp-এ কথা বলো', 'https://wa.me/8801601013241?text=chat' ),
		'checks'    => array( 'লাইফটাইম এক্সেস', 'এককালীন পেমেন্ট', 'ইনস্ট্যান্ট এক্সেস' ),
	),
);
