<?php
/**
 * content/mbhsc.php — every word on /mbhsc/ (Mission: Bypass HSC).
 *
 * Same array shape as content/home.php so the front page's parts render it
 * unchanged; the extra keys (program, pain, curriculum, live, outcomes,
 * about, faq items) feed parts/mbhsc/*. Copy is the live sraik.com/mbhsc
 * copy, trimmed to the length each template slot was designed for.
 *
 * Section order: hero → trust → program → pain → inside → why → curriculum
 * → live sessions → how to join → mentorship → outcomes → mentor →
 * wall of love → pricing → FAQ → CTA.
 *
 * Inline tags allowed in strings: <span class="hl">, <br>, <strong>, <em>, <a>.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sraik_mb_wa = 'https://wa.me/8801601013241?text=chat';

return array(

	/* ───────────────────────── HERO ───────────────────────── */
	'hero' => array(
		'badge_tag'   => 'Live',
		'badge_text'  => 'Enrollment is Live Now — যুক্ত হও আজই',
		/* The live page's offer ended 11 Jul 2026; no countdown until a new one. */
		'deadline'    => '',
		'badge_href'  => '#pricing',
		'title'       => 'তুমি কী <span class="hl">Player</span><br>নাকি দর্শক?',
		'sub'         => 'গতানুগতিক শিক্ষাব্যবস্থা, এডটেক, Backshot ও সাজেশনের ফাঁদ bypass করে রেকর্ড সময়ে Self Dependent হওয়ার এবং এইচএসসি ও অ্যাডমিশনে কাঁপানোর একমাত্র action based training system.',
		'primary'     => array( 'যুক্ত হও!', '#pricing' ),
		'secondary'   => array( 'ভিডিওটি দেখো', '#intro' ),
		'note'        => '★ 4.9/5 based on 1,763 reviews · Trusted by 8,756+ learners',

		'window'      => array(
			'tab_1'    => 'Mission: Bypass HSC · Intro',
			'tab_2'    => 'hsc-roadmap.pdf',
			'status'   => 'Enrollment is Live',
			'prompt_l' => 'Program',
			'prompt'   => 'অন্যের ওপর নির্ভরশীলতা থেকে বের হয়ে নিজে নিজে পড়ালেখা গুছিয়ে নেওয়া আর ভাবতে শেখার ফুল সিস্টেম।',
			'toggle'   => array( 'Player', 'Pro' ),
			'stack_l'  => 'Subjects',
			'stack'    => array( 'English', 'Physics', 'Chemistry', 'Biology', 'Higher Math' ),
			'checks_l' => 'Included',
			'checks'   => array( '7 Gemini Gems — ডিজিটাল টুলকিট', '৫০+ অ্যাকশন ভিত্তিক ভিডিও লেসন', 'AI-Powered Military-Grade Routine' ),
			'video'    => 'ueIPzpYgl-M',
			'start'    => 983,
			'poster'   => 'https://sraik.com/wp-content/uploads/2026/07/big2.webp',
			'caption'  => 'Mission: Bypass HSC — ইন্ট্রোডাকশন',
			'yt_link'  => 'https://www.youtube.com/watch?v=ueIPzpYgl-M&t=983s',
		),
	),

	/* ───────────────────────── TRUST MARQUEE (same crests as the front page) ───────────────────────── */
	'trust' => array_merge(
		sraik_content( 'home' )['trust'],
		array( 'title' => 'Trusted by learners from' )
	),

	/* ───────────────────────── THE PROGRAM (+ editorial quote) ───────────────────────── */
	'program' => array(
		'eyebrow' => 'The Program',
		'title'   => 'মিশন: বাইপাস এইচএসসি কী?',
		'paras'   => array(
			'এটি সারা বাংলাদেশের এইচএসসি লেভেলের স্টুডেন্টদের জন্য বানানো এমন এক মেন্টরশিপ প্রোগ্রাম, যা তোমাকে অন্যের ওপর নির্ভরশীলতা থেকে বের করে নিজে নিজে পড়ালেখা গুছিয়ে নেওয়ার এবং ভাবতে শেখার ফুল সিস্টেম দেয়।',
			'তোমার মেধা, সহনশীলতা ও সক্ষমতাকে কাজে লাগিয়ে মাত্র ১ মাসের মধ্যে নিজের <span class="hl">৪ গুণ থেকে ৩০ গুণ</span> পর্যন্ত ইম্প্রুভমেন্ট দেখার ডিরেক্ট অ্যাকশন প্রোটোকল এটি।',
		),
		'link'    => array( 'কারিকুলাম দেখো', '#curriculum' ),
		'quote'   => '“এই এডুকেশন সিস্টেম, আমাদেরকে ইউজ করে আমাদের তাদের খেলার দর্শক বানিয়ে রেখেছে।”',
		'cite'    => 'S A Khan Shams',
		'role'    => 'Lead Mentor, SRAIK',
		'image'   => 'https://sraik.com/wp-content/uploads/2026/08/sakhanshams.webp',
	),

	/* ───────────────────────── PAIN POINTS ───────────────────────── */
	'pain' => array(
		'eyebrow' => 'Does This Sound Like You?',
		'title'   => 'এটা কি তোমার গল্প?',
		'sub'     => '',
		'cards'   => array(
			array( 'monitor-play', 'ঘন্টার পর ঘন্টা অনলাইনে ওয়ানশট ম্যারাথন বা লাইভ ক্লাস দেখছো ঠিকই, কিন্তু পরের দিন সকালে নিজে বই খুলে পড়তে গেলে আর কিছুই মাথায় ঢুকছে না।' ),
			array( 'file-text', 'সিনিয়র ভাইদের ‘১০০% কমন সাজেশন’ আর ডিরেক্ট পিডিএফ ডাউনলোড করতে করতে পড়ার টেবিল জমিয়ে ফেলেছ, কিন্তু আসল পড়াটাই আর গোছানো হয়নি।' ),
			array( 'circle-alert', 'প্রশ্নপত্রটা উল্টানোর সাথে সাথে মাথা ব্ল্যাঙ্ক হয়ে যায়, কারণ মুখস্ত করা চলক বা প্যাটার্ন একটু ঘুরিয়ে দিলেই আর কিছুই পারো না।' ),
			array( 'compass', 'বুঝতে পারছো পড়াশোনার সিস্টেমে কোথাও একটা বড় সমস্যা হচ্ছে, কিন্তু এই ট্র্যাপ থেকে বের হওয়ার কোনো সঠিক রাস্তা খুঁজে পাচ্ছো না।' ),
		),
	),

	/* ───────────────────────── WHAT'S INSIDE (6 cards) ───────────────────────── */
	'inside' => array(
		'eyebrow' => "What's Inside the Training",
		'title'   => 'ট্রেনিং এর ভেতরে কী আছে',
		'sub'     => 'শুধু ক্লাস দেখে গ্যালারির দর্শক হয়ে বসে থাকার দিন শেষ — প্রতিটি টুল আর লেসন তোমাকে মাঠের আসল প্লেয়ার বানানোর জন্য।',
		'cards'   => array(
			array( 'gem', '7 Gemini Gems', 'HSC একাডেমিক লাইফের ডিজিটাল পার্টনার ও কমপ্লিট টুলকিট — মুখস্থ বিদ্যা ছেড়ে প্রবলেম সলভিং ক্যাপাবিলিটি বাড়ানোর ব্লুপ্রিন্ট।' ),
			array( 'circle-play', '৫০+ অ্যাকশন ভিত্তিক ভিডিও', 'টপারদের আসল সিক্রেট রিভিল করা লেসন — কোনো ফাতরামি বা টাইম ওয়েস্ট ছাড়া একদম কনসাইজ।' ),
			array( 'alarm-clock', 'Military-Grade Routine', 'এক্স-ক্যাডেটের ডিসিপ্লিনড প্রোটোকলে বানানো AI-Powered রুটিন, যা জোর ছাড়াই অলসতা কাটায়।' ),
			array( 'clipboard-check', 'অ্যাসাইনমেন্ট ও ট্র্যাকিং', 'প্রতিটি লেসনের পর ডিরেক্ট অ্যাকশন ড্রিল, অ্যাসাইনমেন্ট আর পার্সোনাল প্রগ্রেস ট্র্যাকিং।' ),
			array( 'users', 'Live Mentor Access', 'Pro Players-দের জন্য সপ্তাহে ৫ দিন দুপুর ৩টা–৫টা সরাসরি সামসের সাথে WhatsApp-এ One to One।' ),
			array( 'radio', '১২টি মেগা লাইভ সেশন', 'মেডিকেল, ডিফেন্স/ISSB আর ডিজিটাল ক্যারিয়ার — ৩টি ফিল্ডে ডোমিনেট করার ডিরেক্ট গাইডেন্স।' ),
		),
	),

	/* ───────────────────────── WHY (bento) ───────────────────────── */
	'why' => array(
		'eyebrow' => 'Why We Are Different',
		'title'   => 'কেন আমরা আলাদা?',
		'sub'     => 'বিচ্ছিন্ন টুলস আর কোর্সের ঝামেলা শেষ — সবকিছু একটাই সিস্টেমে।',
		'cards'   => array(
			array(
				'tag'   => 'All-in-One System',
				'icon'  => 'layers',
				'title' => 'সব কিছু এক জায়গায়',
				'text'  => 'ইউটিউবের ফ্রি ক্লাস বা সাইকেল কোর্সের চক্করে টাইম ওয়েস্ট বন্ধ। নোট করার ‘হাইব্রিড করনেল মেথড’ থেকে টেস্ট পেপার সলভিং মেথড — সব এক জায়গায়।',
				'orbit' => array( 'gem', 'circle-play', 'alarm-clock', 'clipboard-check', 'users', 'radio' ),
			),
			array(
				'tag'   => 'No-Motivation Protocol',
				'icon'  => 'activity',
				'title' => 'মোটিভেশন নয়, সিস্টেম',
				'text'  => 'মোটিভেশনের দৌড় সর্বোচ্চ ২ দিন। এই সিস্টেম সম্পূর্ণ অ্যাকশন আর Military সিস্টেম-ড্রিভেন — মুড খারাপ থাকলেও তোমাকে লক্ষ্যে ধরে রাখবে।',
				'gauge' => array( '২ দিন', 'Motivation' ),
				'chip'  => 'Action · Military System',
			),
			array(
				'tag'   => 'Lifetime Access',
				'icon'  => 'shield-check',
				'title' => 'একবার পেমেন্টে লাইফটাইম Access',
				'text'  => 'জয়েন করবা একবার, Free Update পাবা আজীবন। অন্যান্য জায়গার মতো মাসিক পেমেন্ট সিস্টেম আমাদের নেই।',
				'chips' => array(
					array( 'wallet', 'এককালীন পেমেন্ট' ),
					array( 'infinity', 'লাইফটাইম এক্সেস' ),
					array( 'refresh-cw', 'Free Update' ),
				),
			),
			array(
				'tag'   => 'Instant Access',
				'icon'  => 'zap',
				'title' => 'Instant Access on Enrollment',
				'text'  => 'জয়েন করার সাথে সাথে কাজ শুরু — Time waste করার মতো Time আমাদের নাই।',
				'diff'  => array( 'checkout · place order', 'dashboard · access' ),
			),
		),
	),

	/* ───────────────────────── TRAINING CURRICULUM ───────────────────────── */
	'curriculum' => array(
		'id'      => 'curriculum',
		'eyebrow' => 'Training Curriculum',
		'title'   => 'দর্শক থেকে প্লেয়ার হওয়ার কারিকুলাম',
		'sub'     => 'গ্যালারির দর্শক থেকে মাঠের আসল প্লেয়ার হওয়ার রেকর্ডেড মডিউল, যা তোমার পড়ার ধরন সম্পূর্ণ পাল্টে দেবে।',
		'badges'  => array( array( '8', 'Modules' ), array( '50+', 'Lessons' ), array( 'Lifetime', 'Access' ) ),
		'note'    => 'উল্লেখ্য ভিডিওর সংখ্যা on demand বাড়ানো হবে।',
		'icon'    => 'circle-play',
		'modules' => array(
			array( 'দ্য কিকঅফ: দর্শক থেকে প্লেয়ার হওয়ার ফর্মুলা', 'Module 1', array( 'Announcement for Players', 'নিজের সাথে নিজের চুক্তি', 'কিকঅফ ডায়াগনস্টিক টুল এর মাধ্যমে নিজের বর্তমান অবস্থা যাচাই', 'তোমার রানওয়ে ম্যাপ কী হবে?', 'Friction, Dopamine Trap ও Spectator Trap এর রিলেশন', '[Bonus] পড়ালেখায় Friction Principle কাজে লাগানো', '[Bonus] Research On Dopamine Loop', 'নিজের Win চিনে নেয়া', 'HSC Exclusive', 'HSC 2025 Full Roadmap, Guideline & Suggestion' ) ),
			array( 'দ্য গ্রাউন্ড: একটা Bulletproof পরিবেশ তৈরি করা', 'Module 2', array( 'Military Grade Routine দিয়ে নিজের রুটিন বানানো', '[Bonus] Military Routine+AI', 'Submarine প্রোটোকল', 'Attention ও ফোকাস বাড়ানোর ফর্মুলা', 'ডিপ রেস্ট অপ্টিমাইজেশন', 'বাজেটে হাই পারফরম্যান্স খাবার', 'Anti Burnout Protocol' ) ),
			array( 'শেখার আসল ইঞ্জিন', 'Module 3', array( 'পড়ালেখার ম্যাটেরিয়ালস ও টুলস পরিচিতি', 'সাতটি প্লেয়ার জেম এর ব্যবহার ও AI Learning নিয়ে বিস্তারিত', 'অ্যাক্টিভ অনলাইন ক্লাস কনজাম্পশন', 'Part 2 অ্যাক্টিভ অনলাইন ক্লাস কনজাম্পশন', 'কোর্স কিনে Vs না কিনে পড়া (Honest Comparison)', 'ইনফরমেশন এনকোডিং ও দ্রুত পড়ার কৌশল', 'রিট্রিভাল অ্যান্ড স্পেসিং এর মাধ্যমে ভুলে যাওয়া এড়ানো', '[Bonus] মনে রাখার বিভিন্ন কৌশল', '৮০/২০ এফিসিয়েন্সি রুল' ) ),
			array( 'সেরা প্রিপারেশনের জন্য Subject Specific Roadmap', 'Module 4', array( 'সবার সাথে আগাতে গেলে তুমি আগাতে পারবেনা!', 'Part 1 ইংলিশ পড়ার ইফেক্টিভ স্ট্র্যাটেজি A to Z', 'Part 2 ইংলিশ পড়ার ইফেক্টিভ স্ট্র্যাটেজি A to Z', 'Part 1 বাংলা পড়ার ইফেক্টিভ স্ট্র্যাটেজি A to Z', 'Part 2 বাংলা পড়ার ইফেক্টিভ স্ট্র্যাটেজি A to Z', 'ফিজিক্স পড়ার ইফেক্টিভ স্ট্র্যাটেজি (A to Z)', 'কেমিস্ট্রি পড়ার ইফেক্টিভ স্ট্র্যাটেজি (A to Z)', 'বায়োলজি (Zoology and Botany) পড়ার ইফেক্টিভ স্ট্র্যাটেজি (A to Z)', 'Higher Maths পড়ার ইফেক্টিভ স্ট্র্যাটেজি (A to Z)', 'ICT পড়ার ইফেক্টিভ স্ট্র্যাটেজি (A to Z)' ) ),
			array( 'পড়ালেখার ময়নাতদন্ত', 'Module 5', array( 'লেয়ার মেথডে পড়ালেখা', 'বোর্ড কোয়েশ্চেন ইফেক্টিভ ভাবে সলভ করবা যেভাবে', 'CQ/MCQ প্যাটার্ন ম্যাপিং', 'শুরু থেকেই চাপ ছাড়া অ্যাডমিশন এর জন্য যেভাবে পড়বে', '১০০% কমন এর Scam and Reality', 'Build Your Own Suggestion (BYOS)' ) ),
			array( 'পরীক্ষার হলের খেলা', 'Module 6', array( 'বাসায় কোল্ড-ওপেন ড্রিল ও এক্সাম হল সিমুলেশন', 'MCQ মাস্টারি', 'MCQ Bonus', 'সর্বোচ্চ দক্ষতায় MCQ শুরু করার কৌশল', 'কনফিউজিং প্রশ্ন সমাধানের উপায়', 'ট্রিকি প্রশ্নে সঠিক উত্তর দেওয়ার কৌশল', 'প্রায় অসম্ভব প্রশ্নেও কীভাবে সুযোগ খুঁজতে হয়', 'কোনটা উত্তর দেবে, কোনটা এড়িয়ে যাবে', 'CQ তে ফুল মার্ক্স এর কৌশল', 'পেসিং অ্যান্ড লেখার স্পিড' ) ),
			array( 'দ্য ইনার গেম', 'Module 7', array( 'মোটিভেশন ছাড়া Motivated থাকার রহস্য', 'অ্যাংজাইটি ও প্যানিক ম্যানেজমেন্ট', 'পরিবার, বন্ধু ও বাইরের প্রেশার হ্যান্ডেল করা', 'রিলেশনশিপ ও বয়সের দোষ নিয়ে আলোচনা', 'তোমার Purpose খুঁজে বের করা', 'নিজের passion খুঁজে পাওয়া', 'Experience কিভাবে বাড়াবে' ) ),
			array( 'HSC-র ওপারে আসল দুনিয়া', 'Module 8', array( 'একাডেমিক বনাম স্কিল অ্যালাইনমেন্ট', 'Passion থেকে অর্থ উপার্জনের রোডম্যাপ', 'Bonus Video', 'যেকোনো ফিল্ডে ভালো করার তিনটি গোপন রাস্তা' ) ),
			array( 'Bonus From Pro Edition', 'Bonus', array( 'এখন থেকে কিভাবে মেডিকেল এর জন্য পড়বে', 'টাকা আয়ের বিভিন্ন সোর্স' ) ),
		),
	),

	/* ───────────────────────── LIVE SESSION CURRICULUM ───────────────────────── */
	'live' => array(
		'id'      => 'live',
		'eyebrow' => 'Live Session Curriculum',
		'title'   => '১২টি মেগা লাইভ সেশন',
		'sub'     => 'মেডিকেল, ডিফেন্স এবং ডিজিটাল দুনিয়া — ৩টি ভিন্ন ফিল্ডে ডোমিনেট করার জন্য কমপ্লিট ডিরেক্ট গাইডেন্স।',
		'badges'  => array( array( '12', 'Live Sessions' ), array( '3', 'Fields' ) ),
		'note'    => 'রবিবার ও মঙ্গলবার বাদে বাকি সব দিন লাইভ থাকবে। দিনের কখন লাইভ হবে তা স্টুডেন্টদের সাথে আলোচনা করে ঠিক করা হবে।',
		'icon'    => 'radio',
		'modules' => array(
			array( 'মেডিকেল অ্যাডমিশন মেগা লাইভ রুটিন', 'Live Session 1 · 4 lessons', array( array( 'মেডিকেল লাইফ আসলে কেমন ও এর ভবিষ্যৎ', '1 hr' ), array( 'এখন থেকে কিভাবে মেডিকেল এর জন্য পড়বে', '1 hr' ), array( 'একসাথে Live Area Marking Training', '1.5 hr' ), array( 'Feedback সেশন', '45 min' ) ) ),
			array( 'ডিফেন্স / ISSB উইক', 'Live Session 2 · 4 lessons', array( array( 'ডিফেন্স লাইফ আসলে কেমন ও এর ভবিষ্যৎ', '1 hr' ), array( 'রিটেন ও প্রিলিমিনারি সিলেকশন প্রিপারেশন', '1 hr' ), array( 'এখন থেকে কিভাবে ISSB এর জন্য প্রস্তুত হবে: সাইকোলজিক্যাল, GTO ও ভাইভা', '1.5 hr' ), array( 'Feedback সেশন', '45 min' ) ) ),
			array( 'ডিজিটাল ওয়ার্ল্ড ক্যারিয়ার', 'Live Session 3 · 4 lessons', array( array( 'স্কিল সিলেকশন ও মডার্ন ইকোনমি', '1 hr' ), array( 'স্কিল শেখা ও পোর্টফোলিও ইঞ্জিনিয়ারিং', '1.5 hr' ), array( 'টাকা ইনকামের সোর্স ও মনিটাইজেশন ব্লুপ্রিন্ট', '1 hr' ), array( 'পারসোনাল ব্র্যান্ড তৈরি করার উপায় ও ফিডব্যাক', '45 min' ) ) ),
		),
	),

	/* ───────────────────────── HOW TO JOIN (3 steps, from the enrolment FAQ) ───────────────────────── */
	'steps' => array(
		'eyebrow' => 'How to Join',
		'title'   => 'তিন ধাপে যুক্ত হও',
		'sub'     => 'Access Now থেকে প্রথম লেসন — পে করার সাথে সাথেই Website-এ তোমার access।',
		'items'   => array(
			array(
				'icon'  => 'pen-line',
				'title' => 'প্ল্যান বেছে নাও',
				'text'  => 'পছন্দের প্রোগ্রামের Access Now-এ ক্লিক করো — Player বা Player Pro Edition।',
				'ill'   => array( 'input' => 'Player Pro Edition · ৳৭,৯৯০', 'chips' => array( 'Player', 'Pro' ) ),
			),
			array(
				'icon'  => 'sparkles',
				'title' => 'Checkout পূরণ করো',
				'text'  => 'ভ্যালিড gmail, user name, password, ফোন নাম্বার ও নাম লিখে Place Order-এ ক্লিক করো।',
				'ill'   => array( 'chip' => 'Checkout · Place Order', 'pct' => 78 ),
			),
			array(
				'icon'  => 'git-branch',
				'title' => 'সাথে সাথে শুরু করো',
				'text'  => 'পে করার সাথে সাথে Website-এ তোমার access — জয়েন করার সাথে সাথেই কাজ শুরু।',
				'ill'   => array( 'tag' => 'vip.sraik.com', 'chip' => 'Enrolled · Lifetime' ),
			),
		),
	),

	/* ───────────────────────── LIVE MENTORSHIP (integrations layout) ───────────────────────── */
	'mentor' => array(
		'eyebrow' => 'Direct Access',
		'title'   => 'Live Mentorship — সরাসরি সামসের সাথে',
		'text'    => 'সরাসরি মিটিংয়ে জয়েন করে ক্যামেরা অন করে কথা বলার এবং ফিডব্যাক নেওয়ার সুযোগ — রবি ও মঙ্গলবার বাদে প্রতিদিন দুপুর ৩টা থেকে বিকেল ৫টা, শুধু Pro Players-দের জন্য।',
		'link'    => array( 'Player Pro Edition দেখো', '#pricing' ),
		'badge'   => '5 Days · 3–5 PM',
	),

	/* ───────────────────────── OUTCOMES ───────────────────────── */
	'outcomes' => array(
		'eyebrow' => 'Outcomes',
		'title'   => 'ট্রেনিং শেষে তুমি কেমন হবে?',
		'sub'     => '',
		'cards'   => array(
			array( 'user-check', 'আত্মনির্ভরশীল হয়ে উঠো', 'নিজেই নিজের পড়াশোনা গুছিয়ে নেওয়া এবং ভাবতে শিখবে। মোটিভেশন, গাইডলাইন ভিডিও বা সাইকেল কোর্সের চক্করে আর সময় নষ্ট হবে না।' ),
			array( 'brain', 'যেকোনো পরিস্থিতিতে মাথা ঠান্ডা', 'হাই প্রেশার সিচুয়েশন বা পরীক্ষার হলে প্রশ্ন একটু ঘুরিয়ে দিলেও প্যানিক না করে মাথা ঠাণ্ডা রেখে কাঁপায় দিয়ে আসতে পারবে।' ),
			array( 'calendar-check', 'Disciplined জীবনযাপন', 'প্রতিদিন নিজের win চিনে নিতে শিখবে। সঠিক সিস্টেমের কারণে কোনো জোর ছাড়াই তোমার ডেইলি রুটিন অটোমেটিক রান করবে।' ),
			array( 'sparkles', 'মাইন্ড Reprogram', 'সোশ্যাল মিডিয়া ড্রামা ও নয়েজ মাথা থেকে রিমুভ হবে। রিয়াল প্লেয়ারের মতো নিজের মেধা ও সক্ষমতার ওপর আত্মবিশ্বাস ফিরে আসবে।' ),
		),
	),

	/* ───────────────────────── MEET YOUR MENTOR ───────────────────────── */
	'about' => array(
		'eyebrow'   => 'The Mentor',
		'title'     => 'Meet Your Mentor',
		'name'      => 'S A Khan Shams',
		'role'      => 'Lead Mentor, SRAIK',
		'paras'     => array(
			'আমি একজন এক্স ক্যাডেট এবং এক্স অফিসার ক্যাডেট। বাংলাদেশ আর্মিতে আমি আমাদের ফুল কোর্সে ৪র্থ হই এবং আমাকে চায়নাতে ‘ইনফ্যান্ট্রি এলিমেন্টারি কমান্ডিং কোর্স’ এর জন্য নমিনেট করা হয়েছিল। বর্তমানে আমি চট্টগ্রাম মেডিকেল কলেজের একজন শিক্ষার্থী।',
			'এইচএসসির পর পড়াশোনার সাথে সম্পূর্ণ যোগাযোগ না থাকা সত্ত্বেও, জাস্ট সঠিক স্ট্র্যাটেজি এবং আল্লাহর অশেষ রহমতে মাত্র <span class="hl">২২ দিনে</span> কোনো কোচিং বা প্রাইভেট টিচার ছাড়া আমি মেডিকেল ক্র্যাক করি।',
			'২০২০ সাল থেকে ভিডিও এডিটিং, মার্কেটিং, ওয়েব ডেভেলপমেন্ট এবং ডিজিটাল স্ট্র্যাটেজি নিয়ে মাল্টিপল ন্যাশনাল ও ইন্টারন্যাশনাল ব্র্যান্ডের সাথে কাজ করার প্রাক্টিক্যাল এক্সপেরিয়েন্স আমার আছে।',
		),
		'link'      => array( 'আরো জানো', '/about/' ),
		'image'     => 'https://sraik.com/wp-content/uploads/2026/06/s-a-khan-shams.jpg',
		'signature' => 'https://sraik.com/wp-content/uploads/2026/06/signature.png',
		'socials'   => array(
			array( 'whatsapp', 'WhatsApp', $sraik_mb_wa ),
			array( 'facebook', 'Facebook', 'https://facebook.com/sraikbyshams' ),
			array( 'mail', 'Email', 'mailto:shamsfccbd@gmail.com' ),
		),
	),

	/* ───────────────────────── WALL OF LOVE (default wa-proof set, as on the live page) ───────────────────────── */
	'love' => array(
		'eyebrow' => 'Social Proof',
		'title'   => 'আমাদের স্টুডেন্টদের সাফল্য',
		'sub'     => 'আমাদের Training শেষে স্টুডেন্টরা কী বলছে জেনে নাও — WhatsApp থেকে সরাসরি।',
		'rating'  => '4.9/5',
		'reviews' => 'based on 1,763 reviews',
		'more'    => 'আরও দেখুন',
	),

	/* ───────────────────────── PRICING ───────────────────────── */
	'pricing' => array(
		'eyebrow' => 'Investment',
		'title'   => 'তোমার মিশন অনুযায়ী প্ল্যান বেছে নাও',
		'sub'     => 'কোনো মাসিক সিস্টেম নেই — এক পেমেন্টে লাইফটাইম access, আর জয়েন করার সাথে সাথেই কাজ শুরু।',
		'plans'   => array(
			array(
				'name'     => 'Player',
				'badge'    => 'Instant Access',
				'price'    => '৳২,৯৯০',
				'period'   => array( 'lifetime' ),
				'desc'     => 'Basic Plan · Player Edition — ওয়েবসাইটের মাধ্যমে Automatic সব কিছুর Access',
				'primary'  => array( 'শুরু করো', 'https://vip.sraik.com/checkout/?add-to-cart=119' ),
				'second'   => array( 'কারিকুলাম দেখো', '#curriculum' ),
				'feat_l'   => 'যা পাচ্ছো:',
				'features' => array( '৭টি জেমিনি জেমস, পড়ালেখার কমপ্লিট টুলকিট', '৫০টির বেশি অ্যাকশন ভিত্তিক ভিডিও লেসন', 'প্রতিটি ট্রেনিং এর পর অ্যাসাইনমেন্ট', 'এআই চালিত মিলিটারি গ্রেড ডেইলি রুটিন', 'ট্রেনিং রিসোর্স', 'লাইফটাইম অ্যাক্সেস + মাসিক আপডেট' ),
			),
			array(
				'name'     => 'Pro',
				'badge'    => 'Most Popular',
				'price'    => '৳৭,৯৯০',
				'period'   => array( 'lifetime', '২ মাস মেন্টরশিপ' ),
				'desc'     => 'Pro Plan · Player Pro Edition — সরাসরি কথা বলা আর ফিডব্যাক চাইলে',
				'primary'  => array( 'সিট বুক করো', 'https://vip.sraik.com/checkout/?add-to-cart=120' ),
				'second'   => array( 'WhatsApp-এ কথা বলো', $sraik_mb_wa ),
				'feat_l'   => 'Player-এর সব, সাথে:',
				'features' => array( 'লাইভ মেন্টর অ্যাক্সেস (৩টা–৫টা, সপ্তাহে ৫ দিন)', '১২টি মেগা লাইভ সেশন কারিকুলাম', 'সামস ভাইয়ার সাথে সরাসরি প্রশ্নোত্তর পর্ব', 'প্রো প্রাইভেট গ্রুপ অ্যাক্সেস', 'প্রোগ্রেস ট্র্যাকিং এবং ফিডব্যাক সেশন', 'প্রায়োরিটি সাপোর্ট এবং অ্যাকাউন্টেবিলিটি' ),
				'popular'  => true,
			),
			array(
				'name'     => 'Live Only',
				'price'    => 'Custom',
				'period'   => array(),
				'desc'     => 'শুধুমাত্র লাইভ সেশনে জয়েন করতে চাইলে — আলাদা করে WhatsApp Hotline-এ যোগাযোগ করো',
				'primary'  => array( 'WhatsApp Hotline', 'https://wa.me/8801601013241?text=LVS%20%7Bjust%20click%20send%7D' ),
				'second'   => array( 'লাইভ সেশন দেখো', '#live' ),
				'feat_l'   => 'যা পাচ্ছো:',
				'features' => array( '১২টি মেগা লাইভ সেশন', 'মেডিকেল, ডিফেন্স/ISSB ও ডিজিটাল ক্যারিয়ার', 'সকল লাইভের Record', 'রেকর্ডে লাইফটাইম Access' ),
			),
		),
		/* "Watch before you join" — the checkout walkthrough (YouTube Short, 9:16). */
		'video'   => array(
			'title'   => 'যুক্ত হবার পূর্বে অবশ্যই এই ভিডিওটি দেখে নাও',
			'id'      => 'A9vmEPvs2z4',
			'start'   => 0,
			'poster'  => 'brand/video-thumbnail.webp',
			'yt_link' => 'https://youtu.be/A9vmEPvs2z4',
			'yt_text' => 'ভিডিওটি ইউটিউব থেকে দেখে নিতে এখানে ক্লিক করো',
		),
	),

	/* ───────────────────────── FAQ (the live page's own nine) ───────────────────────── */
	'faq' => array(
		'eyebrow' => 'Support',
		'title'   => 'সচারচর জিজ্ঞাসা',
		'sub'     => 'যা জানতে চাও, সরাসরি জবাব নিচে।',
		'items'   => array(
			array(
				'id' => 'mb-ssc',
				'q'  => 'ভাইয়া এস এস সি ব্যাচ কী এই প্রোগ্রামে জয়েন হতে পারবে?',
				'a'  => '<p>সরি ভাই, এই প্রোগ্রাম শুধুমাত্র যেকোনো HSC ব্যাচের জন্য বানানো, তোমার আগ্রহের জন্য ধন্যবাদ।</p>',
			),
			array(
				'id' => 'mb-payment',
				'q'  => 'পেমেন্ট কী এককালিন নাকি মাসিক?',
				'a'  => '<p>আমাদের প্রোগ্রামে কোনো মাসিক সিস্টেম নেই, অর্থাৎ এক পেমেন্টে লাইফটাইম access।</p>',
			),
			array(
				'id' => 'mb-player-vs-pro',
				'q'  => 'তাহলে Player আর Player Pro এর মধ্যে পার্থক্য কী?',
				'a'  => '<p>Player Edition এ তোমাকে ওয়েবসাইটের মাধ্যমে Automatic সব কিছুর Access দেয়া হবে। সবকিছু বলতে সকল main curriculum এর ভিডিও Lesson, AI Tools, Customised Military Grade Routine, Assignments ইত্যাদি। আরও জানতে <a href="#inside">এখানে ক্লিক করো</a>।</p><p>তবে Player Pro তে Player Edition এর সবকিছুর access এর পাশাপাশি সামস ভাইয়ার সাথে দুপুর ৩ টা থেকে বিকাল ৫ টা পর্যন্ত One To One কথা বলা যাবে এনরোলের পর ২ মাস পর্যন্ত। এছাড়া ১২ টি লাইভ সেশন যেখানে মেডিকাল, ISSB ও Digital Field এ Career গড়ার Roadmap দেয়া হবে।</p>',
			),
			array(
				'id' => 'mb-live-only',
				'q'  => 'শুধুমাত্র লাইভ সেশনে জয়েন করা যাবে?',
				'a'  => '<p>যাবে, তবে সেই ক্ষেত্রে আলাদা করে WhatsApp Hotline এ যোগাযোগ করতে হবে। <a href="https://wa.me/8801601013241?text=LVS%20%7Bjust%20click%20send%7D" target="_blank" rel="noopener noreferrer">এখানে ক্লিক করলে</a> তোমাকে WhatsApp এ নিয়ে যাওয়া হবে।</p>',
			),
			array(
				'id' => 'mb-after',
				'q'  => 'তাহলে মেন্টরশিপের ২ মাস পর কী হবে?',
				'a'  => '<p>এর পর তোমার লগিন Dashboard এ লাইভ সেশনের সকল লাইভের Record পেয়ে যাবে যেটাও তোমার কাছে Lifetime Access থাকবে।</p>',
			),
			array(
				'id' => 'mb-talk-after',
				'q'  => 'এর পর কী সামস ভাইয়ার সাথে কথা বলা যাবেনা?',
				'a'  => '<p>সামস ভাইয়া এরই মধ্যে তোমাকে ইন শা আল্লাহ এমন ভাবে তৈরি করে দিবে তোমার ভাইয়ের সাথে কথা না বলেই নিজে কাজ করতে পারবা। অফিসিয়ালি আমাদের one to one mentorship ২ মাসের মধ্যেই শেষ।</p>',
			),
			array(
				'id' => 'mb-enroll',
				'q'  => 'ভাই এনরোল কিভাবে করবো?',
				'a'  => '<p>প্রথমে তোমার পছন্দের প্রোগ্রামের <a href="#pricing">Access Now</a> এ ক্লিক করবা। তোমাকে checkout এ নিয়ে যাওয়া হবে, ওখানে নির্ভুল ভাবে নিজের ভ্যালিড gmail id, user name, password, ফোন নাম্বার ও নাম লিখেই Place Order এ ক্লিক করবা। পে করার সাথে সাথে Website এ তোমার access পেয়ে যাবে। <a href="#pay-video">ভিডিও টিউটোরিয়াল দেখতে এখানে ক্লিক করো</a>।</p>',
			),
			array(
				'id' => 'mb-hsc26',
				'q'  => 'ভাই আমি HSC 26 ব্যাচ, আমি কী জয়েন হতে পারবো?',
				'a'  => '<p>হ্যাঁ, যে অবস্থাতেই থাকোনা কেনো, তুমি যেকোনো প্রোগ্রামে জয়েন হতে পারবে ২৭ ও ২৮ ব্যাচের সাথে।</p>',
			),
			array(
				'id' => 'mb-support',
				'q'  => 'ট্রেনিং এ এনরোলের পর কোনো issue face করলে কোথায় জানাবো?',
				'a'  => '<p>তোমার enrollment এর username জানালেই হবে আমাদের <a href="https://wa.me/8801601013241?text=chat" target="_blank" rel="noopener noreferrer">01601013241 WhatsApp Number</a> এ।</p>',
			),
		),
		'more'    => array( 'আরও প্রশ্ন আছে? সরাসরি WhatsApp এ চ্যাট করো', $sraik_mb_wa ),
	),

	/* ───────────────────────── CTA ───────────────────────── */
	'cta' => array(
		'eyebrow'   => 'Ready to Play?',
		'title'     => 'Ready to <span class="hl">Play?</span>',
		'sub'       => 'তুমি নিজেও জানো, টাইম বেশি নাই, নিজের ভালো নিজেকেই বুঝতে হবে। ফি আমানিল্লাহ!',
		'primary'   => array( 'যুক্ত হও!', '#pricing' ),
		'secondary' => array( 'WhatsApp-এ কথা বলো', $sraik_mb_wa ),
		'checks'    => array( 'লাইফটাইম এক্সেস', 'এককালীন পেমেন্ট', 'ইনস্ট্যান্ট এক্সেস' ),
	),
);
