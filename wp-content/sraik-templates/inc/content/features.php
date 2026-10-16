<?php
/**
 * content/features.php — every word on /features/ (the "Training" page).
 *
 * Section order follows the template's features page: hero → core
 * capabilities (5-card bento) → three deep-dive rows → curriculum → live
 * sessions → stats strip → outcomes (6 orb cards) → comparison table → CTA.
 * All copy is the live sraik.com MATACE 3.0 copy (parts/home-content.php
 * #program #pain #features #speciality #curriculum #live #mentorship #life),
 * trimmed to each template slot.
 *
 * Inline tags allowed in strings: <span class="hl">, <br>, <strong>, <em>, <a>.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(

	/* ───────────────────────── HERO ───────────────────────── */
	'hero' => array(
		'eyebrow'   => 'Training',
		'title'     => 'প্রস্তুতি থেকে মেডিকেল সিট —<br><span class="hl">সবকিছু এক সিস্টেমে</span>',
		'sub'       => 'দেশের প্রথম ফুল হাইব্রিড মেন্টরশিপ প্রোগ্রাম — অপ্রয়োজনীয় ক্লাস নয়, ফোকাস সেলফ স্টাডি, রিয়েল টাইম এমসিকিউ রিট্রিভাল আর সঠিক স্ট্র্যাটেজি।',
		'primary'   => array( 'যুক্ত হও!', '/#pricing' ),
		'secondary' => array( 'কারিকুলাম দেখো', '#curriculum' ),
		/* The five pillars: icon, label, anchor on this page. */
		'chips'     => array(
			array( 'bot', 'AI Gems', '#dd-ai' ),
			array( 'list-checks', 'Curriculum', '#curriculum' ),
			array( 'clipboard-check', 'Tests', '#capabilities' ),
			array( 'alarm-clock', 'Routine', '#dd-routine' ),
			array( 'users', 'Mentorship', '#live' ),
		),
	),

	/* ───────────────────────── CORE CAPABILITIES (bento) ───────────────────────── */
	'caps' => array(
		'eyebrow' => "What's Inside",
		'title'   => 'পাঁচটা টুল, একটাই লক্ষ্য',
		'sub'     => 'থিওরি ক্লাসের ফাতরামি নেই — ট্রেনিংয়ের প্রতিটি টুল আর লেসন বানানো একটাই লক্ষ্যে: মেডিকেলে তোমার সরকারি সিট।',
		'cards'   => array(
			/* 1 · wide: prompt → gem → generated MCQ set */
			array(
				'title' => '7 AI Gems — মেডিকেল এডমিশন এআই টুলকিট',
				'text'  => 'রিয়েল টাইম মেডিকেল স্ট্যান্ডার্ড প্রশ্নের ৫টি সাবজেক্ট জেম, ইউনিভার্সাল এমসিকিউ সলভার আর ২৪/৭ ডাউট সলভিংয়ের প্লেমেকার জেম।',
				'ill'   => array(
					'prompt' => 'কোষ বিভাজন থেকে MCQ বানাও…',
					'chips'  => array( 'Biology Gem', 'Medical Std' ),
					'file'   => 'universal-solver',
					'count'  => '×4',
				),
			),
			/* 2 · key + satellites */
			array(
				'title' => 'মিলিটারি গ্রেড রুটিন',
				'text'  => 'এক্স ক্যাডেটের অভিজ্ঞতায় তৈরি বায়োলজিক্যাল ক্লক প্রোটোকল — সকাল ১০টার পিক পারফরম্যান্সের জন্য।',
				'ill'   => array(
					'key'   => '১০AM',
					'icons' => array( 'sun', 'brain', 'moon', 'alarm-clock' ),
				),
			),
			/* 3 · checks */
			array(
				'title' => '১০০+ মডেল টেস্ট',
				'text'  => 'বিএমডিসি ও স্বাস্থ্য অধিদপ্তরের মানদণ্ডে চ্যাপ্টার, সাবজেক্ট ও ফুল মডেল টেস্ট — কোচিংয়ের আজাইরা কঠিন প্রশ্ন নয়।',
				'ill'   => array(
					'rows' => array(
						array( 'চ্যাপ্টার টেস্ট', 'chapter' ),
						array( 'সাবজেক্ট টেস্ট', 'subject' ),
						array( 'ফুল মডেল টেস্ট', '100 marks' ),
					),
				),
			),
			/* 4 · terminal window */
			array(
				'title' => 'অ্যাকশন ভিত্তিক কারিকুলাম',
				'text'  => 'সিঙ্গেল মেইন বই মাস্টার, এরিয়া মার্কিং আর ভুলের খাতায় গ্যাপ ফিলাপের স্টেপ বাই স্টেপ ব্লুপ্রিন্ট।',
				'ill'   => array(
					'cmd'  => 'module 1 · diagnostic',
					'done' => 'এসাইনমেন্ট জমা দাও',
					'chip' => '8 Modules · 50+ Lessons',
				),
			),
			/* 5 · orbit */
			array(
				'title' => 'লাইভ মেন্টরশিপ',
				'text'  => 'রবি ও মঙ্গলবার বাদে সপ্তাহে ৫ দিন, দুপুর ৩টা–৫টা সরাসরি সামসের সাথে ওয়ান টু ওয়ান ডিসকাশন।',
				'ill'   => array(
					'value' => '৫ দিন',
					'label' => '3–5 PM',
					'icons' => array( 'svg:whatsapp', 'video', 'headphones', 'message-circle', 'calendar-days', 'users' ),
				),
			),
		),
	),

	/* ───────────────────────── DEEP DIVES (alternating rows) ───────────────────────── */
	'deep' => array(
		array(
			'id'     => 'dd-curriculum',
			'icon'   => 'list-checks',
			'label'  => '01 / CURRICULUM',
			'title'  => '১৪টা বই নয়, একটা মেইন বই',
			'text'   => 'অতিরিক্ত মেটেরিয়ালসের লোডে মূল বই পড়াই অসম্পূর্ণ থেকে যায়। অথচ মেডিকেল এডমিশনের ৯৫% প্রশ্ন আসে একটা সিঙ্গেল টেক্সটবুক থেকে — কারিকুলাম তোমাকে সেটাই মাস্টার করায়।',
			'checks' => array(
				'সিঙ্গেল মেইন বই মাস্টার করার ব্লুপ্রিন্ট',
				'লাইভে একসাথে চ্যাপ্টার ধরে এরিয়া মার্কিং',
				'ভুলের খাতা মেইনটেইন করে গ্যাপ ফিলাপ',
			),
			'link'   => array( 'পুরো কারিকুলাম দেখো', '#curriculum' ),
			'panel'  => array(
				'img'  => 'https://sraik.com/wp-content/uploads/2026/10/training-dashboard.webp',
				'w'    => 1917,
				'h'    => 1078,
				'alt'  => 'vip.sraik.com-এ MATACE 3.0 ট্রেনিং ড্যাশবোর্ড',
				'chip' => 'vip.sraik.com · Dashboard',
				'tags' => array( 'এরিয়া মার্কিং', 'ভুলের খাতা' ),
			),
		),
		array(
			'id'     => 'dd-ai',
			'icon'   => 'bot',
			'label'  => '02 / AI GEMS',
			'title'  => 'একটি MCQ সলভ, চারটি প্রশ্ন শেখা',
			'text'   => 'শুধু উত্তর মুখস্থ নয় — বাকি তিনটি অপশন কেন হলো না আর সেগুলো কিসের উত্তর, তা বের করার অপশন এনালাইসিস। ফলে একটি এমসিকিউ সলভ করলেই চারটি প্রশ্ন শেখা হয়ে যায়।',
			'checks' => array(
				'৫টি সাবজেক্ট জেমে রিয়েল টাইম মেডিকেল স্ট্যান্ডার্ড প্রশ্ন',
				'ইউনিভার্সাল এমসিকিউ সলভারে অপশন এনালাইসিস',
				'প্লেমেকার জেমে ২৪/৭ যেকোনো ডাউট ক্লিয়ার',
			),
			'link'   => array( 'Medical AI LAB মডিউল দেখো', '#module-2' ),
			'panel'  => array(
				'img'  => 'https://sraik.com/wp-content/uploads/2026/10/universal-solver-copy.webp',
				'w'    => 1920,
				'h'    => 1080,
				'alt'  => 'ইউনিভার্সাল এমসিকিউ সলভার দিয়ে বায়োলজির প্রশ্ন বিশ্লেষণ করছেন S A Khan Shams',
				'chip' => 'Universal MCQ Solver',
				'tags' => array( 'Option Analysis', 'Playmaker Gem' ),
			),
		),
		array(
			'id'     => 'dd-routine',
			'icon'   => 'alarm-clock',
			'label'  => '03 / ROUTINE',
			'title'  => 'সকাল ১০টায় ব্রেন থাকবে পিকে',
			'text'   => 'মেডিকেল পরীক্ষা হয় শুক্রবার সকাল ১০টায়। রাত ৩টা পর্যন্ত জেগে পড়লে ঠিক তখনই আসে স্লো রিজনিং আর ঘুম ঘুম ভাব। Military Grade Routine 2.0 তোমার বায়োলজিক্যাল ক্লক সেই সময়ে সেট করে।',
			'checks' => array(
				'এক্স ক্যাডেট ও মেডিকেল শিক্ষার্থীর অভিজ্ঞতায় তৈরি',
				'প্রতিদিন ও সাপ্তাহিক Plan Mapping',
				'ফেক মোটিভেশন ছাড়াই প্রতিদিন কনসিস্টেন্ট',
			),
			'link'   => array( 'রুটিন মডিউল দেখো', '#module-3' ),
			'panel'  => array(
				'img'  => 'https://sraik.com/wp-content/uploads/2026/10/military-grade-study-routine.webp',
				'w'    => 1058,
				'h'    => 595,
				'alt'  => 'S A Khan Shams-এর Military Grade Study Routine',
				'chip' => 'Military Grade Routine 2.0',
				'tags' => array( 'Submarine প্রোটোকল', 'Plan Mapping' ),
			),
		),
	),

	/* ───────────────────────── CURRICULUM (accordion) ───────────────────────── */
	'curriculum' => array(
		'eyebrow' => 'Training Curriculum',
		'title'   => 'মেডিকেল এডমিশনের প্রমাণিত পিলার',
		'sub'     => '৮টি পিলার যা তোমার পুরো প্রিপারেশনকে গুছিয়ে আনবে — প্রতিটি লেসনের পর স্পেসিফিক অ্যাকশন ড্রিল ও অ্যাসাইনমেন্ট।',
		'badges'  => array(
			array( 'layers', '8', 'Modules' ),
			array( 'circle-play', '50+', 'Targeted Lessons' ),
			array( 'infinity', 'Lifetime', 'Access' ),
		),
		'note'    => 'উল্লেখ্য ভিডিওর সংখ্যা on demand বাড়ানো হবে।',
		/* Lessons: array( type, title ) — type 'video' or 'task' (assignment). */
		'modules' => array(
			array(
				'label'   => 'Module 1',
				'title'   => 'Diagnostic Phase: Medical Readiness Index (MRI) 2.0',
				'lessons' => array(
					array( 'video', 'ভাইয়া এখন কী করবো?' ),
					array( 'video', 'Onboarding: MAT ACE 3.0 থেকে Maximum ফায়দা বের করার নিয়ম' ),
					array( 'video', 'Admission Matrix: মেডিকেল ভর্তি পরীক্ষার আসল মেকানিজম ও Selection Dynamics' ),
					array( 'video', 'পার্সোনাল Weakness ও Blindspot আইসোলেশন' ),
					array( 'task', 'উপরের ট্রেনিংয়ের এসাইনমেন্ট জমা দাও' ),
					array( 'video', 'তোমার মেডিকেল এডমিশন ম্যাপ' ),
					array( 'video', 'তোমার রানওয়ে ম্যাপ কী হবে?' ),
					array( 'video', 'Master Contract: বর্তমান থেকে মেডিকেল পর্যন্ত নিজের সাথে চুক্তি' ),
					array( 'task', 'Contract এর প্রমাণ' ),
					array( 'video', '[Bonus] নিজের Win চিনে নেয়া' ),
					array( 'video', 'স্টুডেন্টদের সাথে Live Area Marking Training' ),
				),
			),
			array(
				'label'   => 'Module 2',
				'title'   => 'Medical AI LAB',
				'lessons' => array(
					array( 'video', 'Realtime AI powered Weakness Solving: কঠিন প্রশ্নের ইনস্ট্যান্ট ব্যাখ্যা ও ডাউট ক্লিয়ারিং' ),
					array( 'video', 'The Infinite Question LAB: আনলিমিটেড কাস্টম প্রশ্ন তৈরি ও সলভ' ),
					array( 'video', 'সাতটি প্লেয়ার জেম এর ব্যবহার ও AI Learning নিয়ে বিস্তারিত' ),
					array( 'video', 'Purpose of AI tools' ),
				),
			),
			array(
				'label'   => 'Module 3',
				'title'   => 'যুদ্ধের ময়দান সাজানো',
				'lessons' => array(
					array( 'video', 'One Target Rule ও ব্যাকাপ প্ল্যান' ),
					array( 'task', 'উপরের ট্রেনিংয়ের এসাইনমেন্ট জমা দাও' ),
					array( 'video', 'মেডিকেল এডমিশনের টেক্সটবুক, মেটেরিয়াল ও মিনিমাম দরকারি রিসোর্সের সর্বোচ্চ ব্যবহার' ),
					array( 'task', 'উপরের ট্রেনিংয়ের এসাইনমেন্ট জমা দাও' ),
					array( 'video', 'একসাথে Live Area Marking Training' ),
					array( 'task', 'উপরের ট্রেনিংয়ের এসাইনমেন্ট জমা দাও' ),
					array( 'video', 'রুটিন Ultra Pro Max' ),
					array( 'video', 'Military Grade Routine 2.0 পরিচিতি ও এপ্লিকেশন' ),
					array( 'video', 'Military Grade Routine দিয়ে নিজের রুটিন বানানো' ),
					array( 'task', 'উপরের ট্রেনিংয়ের এসাইনমেন্ট জমা দাও' ),
					array( 'video', '[Bonus] Military Routine+AI' ),
					array( 'video', 'Case Study: আমি যেভাবে Military Routine ব্যবহার করে চান্স পেয়েছিলাম' ),
					array( 'video', 'Submarine প্রোটোকল' ),
					array( 'video', 'Attention ও ফোকাস বাড়ানোর ফর্মুলা' ),
					array( 'task', 'উপরের ট্রেনিংয়ের এসাইনমেন্ট জমা দাও' ),
					array( 'video', 'ব্রেইন ফ্রেশ রাখা ও Rest কিভাবে নিবে?' ),
					array( 'task', 'উপরের ট্রেনিংয়ের এসাইনমেন্ট জমা দাও' ),
					array( 'video', 'Coaching Syncing: কোচিং প্রেসার সামলে নিজের পড়া গুছিয়ে নেওয়ার স্ট্র্যাটেজি' ),
					array( 'task', 'উপরের ট্রেনিংয়ের এসাইনমেন্ট জমা দাও' ),
					array( 'video', 'কোচিং এর সাথে ব্যালেন্স' ),
					array( 'task', 'উপরের ট্রেনিংয়ের এসাইনমেন্ট জমা দাও' ),
					array( 'video', 'প্রতিদিনের Plan Mapping' ),
					array( 'task', 'উপরের ট্রেনিংয়ের এসাইনমেন্ট জমা দাও' ),
					array( 'video', 'সাপ্তাহিক Plan Mapping' ),
					array( 'task', 'উপরের ট্রেনিংয়ের এসাইনমেন্ট জমা দাও' ),
					array( 'video', 'Backlog Elimination Engine: জমে থাকা পড়া দ্রুত শেষ করার সিক্রেট' ),
					array( 'task', 'উপরের ট্রেনিংয়ের এসাইনমেন্ট জমা দাও' ),
					array( 'video', 'Friction, Dopamine Trap ও Spectator Trap এর রিলেশন' ),
					array( 'task', 'উপরের ট্রেনিংয়ের এসাইনমেন্ট জমা দাও' ),
					array( 'video', 'Bonus [পড়ালেখায় Friction Principle কাজে লাগানো]' ),
					array( 'video', '[Bonus] Research On Dopamine Loop' ),
					array( 'video', 'বাজেটে হাই পারফরম্যান্স খাবার' ),
					array( 'video', 'Nutrition and brain optimisation' ),
					array( 'task', 'উপরের ট্রেনিংয়ের এসাইনমেন্ট জমা দাও' ),
					array( 'video', 'ঘুম সমস্যার সমাধান' ),
				),
			),
			array(
				'label'   => 'Module 4',
				'title'   => 'শেখার ইঞ্জিন',
				'lessons' => array(
					array( 'video', 'দিনে কয়টা সাবজেক্ট পড়বো?' ),
					array( 'task', 'উপরের ট্রেনিংয়ের এসাইনমেন্ট জমা দাও' ),
					array( 'video', 'কখন কোন সাবজেক্ট পড়বো?' ),
					array( 'video', 'Live Active Recall Drill: আমার সাথে সরাসরি অ্যাক্টিভ রিকল প্র্যাকটিস' ),
					array( 'task', 'উপরের ট্রেনিংয়ের এসাইনমেন্ট জমা দাও' ),
					array( 'video', 'ইনফরমেশন এনকোডিং ও দ্রুত পড়ার কৌশল' ),
					array( 'video', 'রিট্রিভাল অ্যান্ড স্পেসিং এর মাধ্যমে ভুলে যাওয়া এড়ানো' ),
					array( 'video', '[Bonus]মনে রাখার বিভিন্ন কৌশল' ),
				),
			),
			array(
				'label'   => 'Module 5',
				'title'   => 'বিষয় ভিত্তিক Approach',
				'lessons' => array(
					array( 'video', 'বায়োলজি কিভাবে পড়বো?' ),
					array( 'task', 'উপরের ট্রেনিংয়ের এসাইনমেন্ট জমা দাও' ),
					array( 'video', 'কেমসিট্রি কিভাবে পড়বো?' ),
					array( 'video', 'ফিজিক্স কিভাবে পড়বো?' ),
					array( 'video', 'জিকের বিশাল সিলেবাস সংক্ষেপে শেষ করার স্ট্র্যাটেজি?' ),
					array( 'video', 'মানবিক গুনাবলি কিভাবে পড়বো?' ),
					array( 'video', 'English কিভাবে পড়বো?' ),
					array( 'task', 'উপরের ট্রেনিংয়ের এসাইনমেন্ট জমা দাও' ),
					array( 'video', 'না পড়া টপিক ভালো কিভাবে করবো?' ),
					array( 'video', 'Smart revision and retention' ),
				),
			),
			array(
				'label'   => 'Module 6',
				'title'   => 'MCQ Mastery',
				'lessons' => array(
					array( 'video', 'MCQ ভালো করা একটা স্কিল' ),
					array( 'task', 'উপরের ট্রেনিংয়ের এসাইনমেন্ট জমা দাও' ),
					array( 'video', 'গরুর মতো পড়া না দিয়ে, স্মার্টলি MCQ সলভ করার উপায়' ),
					array( 'task', 'উপরের ট্রেনিংয়ের এসাইনমেন্ট জমা দাও' ),
					array( 'video', 'কিভাবে কনফিউজিং প্রশ্ন দাগাবো?' ),
					array( 'video', 'Tricky MCQ কিভাবে Answer করবে?' ),
					array( 'video', 'Almost 0 probability MCQ কিভাবে answer করবে?' ),
					array( 'task', 'উপরের ট্রেনিংয়ের এসাইনমেন্ট জমা দাও' ),
					array( 'video', 'কখন সব দাগাবা আর কখন বাদ দিবা?' ),
					array( 'video', 'Advanced Skipping Strategy' ),
					array( 'video', 'Giving exam immediately after reading' ),
					array( 'task', 'উপরের ট্রেনিংয়ের এসাইনমেন্ট জমা দাও' ),
					array( 'video', 'পরীক্ষা দেওয়ার পর কী করবো?' ),
					array( 'task', 'উপরের ট্রেনিংয়ের এসাইনমেন্ট জমা দাও' ),
				),
			),
			array(
				'label'   => 'Module 7',
				'title'   => 'Testing ও এক্সাম হল সিমুলেশন',
				'lessons' => array(
					array( 'video', 'লাইভে স্টুডেন্টদের সাথে মেডিকেল এক্সাম এক্সপোজ' ),
					array( 'task', 'উপরের ট্রেনিংয়ের এসাইনমেন্ট জমা দাও' ),
				),
			),
			array(
				'label'   => 'Module 8',
				'title'   => 'দুর্বলতা কাটানো',
				'lessons' => array(
					array( 'video', '“ভাইয়া, প্যানিক করি” অবস্থার সমাধান' ),
					array( 'task', 'উপরের ট্রেনিংয়ের এসাইনমেন্ট জমা দাও' ),
					array( 'video', 'কয়বার রিভিশন দিলে এনাফ হবে?' ),
					array( 'video', 'কিভাবে কনফিডেন্স বাড়াবো?' ),
					array( 'video', '[Bonus] Managing Anxiety' ),
					array( 'video', 'কিভাবে মাইন্ডসেট ঠিক করবো?' ),
					array( 'video', 'Residual Knowledge কিভাবে বাড়াবো' ),
					array( 'task', 'উপরের ট্রেনিংয়ের এসাইনমেন্ট জমা দাও' ),
				),
			),
			array(
				'label'   => 'Module 9',
				'title'   => 'নিজের সাথে নিজের লড়ায়',
				'lessons' => array(
					array( 'video', 'Motivation ছাড়া Motivated থাকার উপায়' ),
					array( 'video', 'পারিবারিক চাপ ও প্রত্যাশা সামলানো' ),
					array( 'video', '[Bonus] Family support and pressure' ),
					array( 'video', 'রিলেশনশিপ ও বয়সের দোষ নিয়ে আলোচনা' ),
					array( 'video', '[Bonus] Love & Relationship' ),
					array( 'video', 'Anti Burnout Protocol' ),
					array( 'video', '[Bonus] Anti Burnout Protocol' ),
					array( 'video', 'তোমার Purpose খুঁজে বের করা' ),
					array( 'task', 'উপরের ট্রেনিংয়ের এসাইনমেন্ট জমা দাও' ),
				),
			),
			array(
				'label'   => 'Module 10',
				'title'   => 'The Endgame',
				'lessons' => array(
					array( 'video', 'Final 30-Day Masterplan: শেষ ৩০ দিনের পাওয়ার রুটিন ও রিভিশন ম্যাপ' ),
					array( 'task', 'উপরের ট্রেনিংয়ের এসাইনমেন্ট জমা দাও' ),
					array( 'video', 'Signature 22 Days Planning' ),
					array( 'video', 'Last 7 Days Planning' ),
					array( 'video', 'এক্সামের আগের 24 hours কী করবে?' ),
					array( 'video', 'মেডিকেল লাইফ আসলে কেমন ও এর ভবিষ্যৎ' ),
				),
			),
			array(
				'label'   => 'Module 11',
				'title'   => 'Performance Tracking & Analytics',
				'lessons' => array(
					array( 'task', 'Daily & Weekly Mission: কাজের ট্র্যাকিং ও ডেইলি গোলস' ),
					array( 'task', 'Performance Analytics Dashboard: Speed, Accuracy, Error Rate ও Score Tracking' ),
				),
			),
		),
	),

	/* ───────────────────────── LIVE SESSIONS ───────────────────────── */
	'live' => array(
		'eyebrow'  => 'Live Sessions',
		'title'    => 'স্পেশাল লাইভ সেশন কারিকুলাম',
		'sub'      => 'সরাসরি লাইভে এসে স্ট্র্যাটেজি ঝালাই ও উইকলি স্প্রিন্ট প্ল্যানিং — এরিয়া মার্কিং, ভুলের খাতা অডিট আর এক্সাম হল সিমুলেশন, সবই সামসের সাথে।',
		'sessions' => array(
			array(
				'icon'  => 'pen-line',
				'orb'   => 'book-open',
				'chip'  => 'Main Book Surgery',
				'title' => 'লাইভ এরিয়া মার্কিং ও মেইন বুক সার্জারি',
				'text'  => 'আজমল, হাজারী নাগ ও ইসহাক স্যারের বইয়ের প্রতিটি চ্যাপ্টার থেকে প্রশ্ন কমন ফেলার লাইভ ডেমোস্ট্রেশন।',
			),
			array(
				'icon'  => 'notebook-pen',
				'orb'   => 'notebook-pen',
				'chip'  => 'Weekly Audit',
				'title' => 'উইকলি প্রগ্রেস ও ভুলের খাতা অডিট',
				'text'  => 'ভুলের খাতা সরাসরি লাইভে চেক করে দুর্বলতাগুলো দ্রুত রিকভার করার গাইডলাইন।',
			),
			array(
				'icon'  => 'timer',
				'orb'   => 'brain',
				'chip'  => 'Exam Hall Simulation',
				'title' => 'এক্সাম হল সিমুলেশন ও মাইন্ডসেট ওয়ার্কশপ',
				'text'  => 'অচেনা পরিবেশ, ভাঙা চেয়ার আর গরমেও মাথা ঠান্ডা রেখে সর্বোচ্চ স্কোর নিশ্চিত করার ট্যাকটিকাল ট্রেনিং।',
			),
		),
		'note'     => 'student ডিমান্ড অনুযায়ী আরো ৯টা, মোট ১২ টা লাইভ মিটিং আয়োজন করা হবে যাতে কোনো সমস্যাই অধরা না থাকে।',
	),

	/* ───────────────────────── STATS (real numbers only) ───────────────────────── */
	'stats' => array(
		array( '8,756+', 'লার্নারের ভরসা SRAIK-এর সিস্টেমে' ),
		array( '4.9/5', '১,৭৬৩টি রিভিউয়ের গড় রেটিং' ),
		array( '100+', 'মেডিকেল স্ট্যান্ডার্ড চ্যাপ্টার ও মডেল টেস্ট' ),
		array( '২২ দিন', 'কোচিং ছাড়াই সামসের মেডিকেল ক্র্যাক' ),
	),

	/* ───────────────────────── OUTCOMES (6 orb cards) ───────────────────────── */
	'outcomes' => array(
		'eyebrow' => 'Outcomes',
		'title'   => 'ট্রেনিং শেষে কী পরিবর্তন আসবে?',
		'sub'     => 'সমস্যা তোমার ব্রেনে না, সমস্যা তোমার মেথডে। আর মেথড ঠিক করতে বছর লাগে না, কয়েক সপ্তাহই যথেষ্ট — সঠিক সিস্টেমে প্রস্তুতি নিলে যা বদলে যাবে:',
		'cards'   => array(
			array( 'compass', 'কোচিং নির্ভরতা থেকে মুক্তি', 'কে কী দাগিয়ে দিলো তার পেছনে আর দৌড় নয় — যেকোনো চ্যাপ্টারের মূল প্রশ্ন এরিয়া নিজেই চিনবে।' ),
			array( 'target', '০.২৫ মার্কসের নিখুঁত নিয়ন্ত্রণ', 'কখন স্কিপ করবে আর কখন ক্যালকুলেটেড রিস্ক নেবে — নেগেটিভ মার্কিংয়ের ভয় কেটে যাবে।' ),
			array( 'sun', 'সকাল ১০টায় পিক ব্রেন', 'সার্কেডিয়ান রিদম ঠিক থাকায় পরীক্ষার পুরো ৭৫ মিনিট ব্রেন সর্বোচ্চ স্পিডে রিকল করবে।' ),
			array( 'shield-check', 'পাথরের মতো শান্ত আত্মবিশ্বাস', 'কোচিংয়ের অপ্রাসঙ্গিক রেজাল্টে ভেঙে পড়া নয় — মেডিকেল প্রশ্নের বাস্তব স্কেলে নিজেকে মাপবে।' ),
			array( 'trending-up', '১০ থেকে ১৫ মার্কস বুস্ট', 'সঠিক ট্র্যাকে মাত্র ২১ থেকে ৩০ দিনে টেস্ট স্কোর বাড়ানোর প্রমাণিত অ্যাকশন প্রোটোকল।' ),
			array( 'infinity', 'লাইফটাইম এক্সেস ও আপডেট', 'একবার এনরোলমেন্টেই এডমিশন টেস্টের শেষ দিন পর্যন্ত সব আপডেটের এক্সেস।' ),
		),
	),

	/* ───────────────────────── COMPARISON TABLE ───────────────────────── */
	'compare' => array(
		'eyebrow' => 'Why MATACE 3.0',
		'title'   => 'শুধু আরেকটা কোচিং না',
		'sub'     => 'কোচিং সেন্টার তোমাকে তাদের ওপর নির্ভরশীল রাখতে চায়। আমরা শেখাই এমন সিস্টেম, যাতে একটি একক সেন্ট্রাল সিস্টেমে তুমি নিজেই ফুল মেডিকেল প্রস্তুতি গুছিয়ে নিতে পারো।',
		'head'    => array( 'Feature', 'MATACE 3.0', 'গতানুগতিক কোচিং' ),
		/* Row: label, then the coaching cell — '' renders a dash, text renders mono. */
		'rows'    => array(
			array( 'সিঙ্গেল মেইন টেক্সটবুক ভিত্তিক প্রস্তুতি', '১৪টা বই' ),
			array( 'মেডিকেল প্রশ্নের বাস্তব স্কেলে মডেল টেস্ট', '' ),
			array( 'ডিপেন্ডেন্সি মুক্ত সেলফ স্টাডি সিস্টেম', '' ),
			array( 'রিয়েল টাইম AI প্রশ্ন জেনারেটর ও ডাউট সলভার', '' ),
			array( 'সামসের সাথে ওয়ান টু ওয়ান মেন্টরশিপ', '' ),
			array( 'এক পেমেন্টে শেষ দিন পর্যন্ত সব আপডেট', 'বারবার ফি' ),
		),
	),

	/* ───────────────────────── CTA ───────────────────────── */
	'cta' => array(
		'eyebrow'   => 'Ready to Play?',
		'title'     => 'তোমার মেডিকেল সিট এক সিদ্ধান্ত দূরে।',
		'sub'       => '৮,৭৫৬+ লার্নারের সাথে যুক্ত হও আর আজই তোমার রোডম্যাপ শুরু করো। ফি আমানিল্লাহ!',
		'primary'   => array( 'যুক্ত হও!', '/#pricing' ),
		'secondary' => array( 'WhatsApp-এ কথা বলো', 'https://wa.me/8801601013241?text=chat' ),
		'checks'    => array( 'লাইফটাইম এক্সেস', 'এককালীন পেমেন্ট', 'ইনস্ট্যান্ট এক্সেস' ),
	),
);
