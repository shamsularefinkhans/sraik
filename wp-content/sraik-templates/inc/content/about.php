<?php
/**
 * content/about.php — every word on /about/, on the Code Craft careers layout.
 *
 * Section order follows the template: hero + photo collage → (mentor, an
 * addition the template has no slot for) → benefits (6 orb cards) → how we
 * work (3 principles) → open roles (programs) → hiring process (a
 * student's journey) → open application (WhatsApp). The careers page has
 * no CTA card, so neither does this one.
 *
 * Copy is the live sraik.com about page, the #mentor section and the
 * Mission: Bypass HSC page, trimmed to each template slot's length.
 * Inline tags allowed in strings: <span class="hl">, <br>, <strong>, <em>, <a>.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(

	/* ───────────────────────── HERO ───────────────────────── */
	'hero' => array(
		'eyebrow'   => 'About SRAIK',
		'title'     => 'Training should be about <span class="hl">real execution</span>',
		'sub'       => 'A disciplined modern training ecosystem for ambitious individuals. At SRAIK we built it to help you learn, thrive and repeat.',
		'primary'   => array( 'View programs', '#programs' ),
		'secondary' => array( 'Meet the mentor', '#mentor' ),
		/* Three frames, left → right. The middle one is the tall frame and
		   the only one shown on phones. */
		'photos'    => array(
			array( 'https://sraik.com/wp-content/uploads/2026/06/s-a-khan-shams.jpg', 'S A Khan Shams, founder of SRAIK', 1000, 1000 ),
			array( 'https://sraik.com/wp-content/uploads/2026/10/live-mentorship-with-students.webp', 'A live SRAIK mentorship session with students', 1920, 1080 ),
			array( 'https://sraik.com/wp-content/uploads/2026/06/doubt-clear.jpg', 'Students in a SRAIK doubt-clearing session', 1280, 720 ),
		),
	),

	/* ───────────────────────── MENTOR ───────────────────────── */
	'mentor' => array(
		'eyebrow' => 'The Mentor',
		'title'   => 'Meet Your Mentor',
		'sub'     => 'তোমার মেন্টরকে চেনো',
		'kicker'  => 'Founder · Lead Trainer',
		'name'    => 'S A Khan Shams',
		'full'    => 'Shamsul Arefin Khan Shams',
		'role'    => 'Lead Mentor, SRAIK',
		'photo'   => array( 'https://sraik.com/wp-content/uploads/2026/05/passport-s-a-khan-shams-copy.webp', 'Shamsul Arefin Khan Shams', 1086, 1448 ),
		'chips'   => array(
			array( 'shield', 'Ex-Cadet' ),
			array( 'medal', 'Ex-Officer Cadet' ),
			array( 'stethoscope', 'Chattogram Medical College' ),
			array( 'timer', 'Medical in 22 days' ),
		),
		/* The live #mentor bio, word for word, split into paragraphs. */
		'bio'     => array(
				'বর্তমান বিশ্বে টিকে থাকতে পড়াশোনার পাশাপাশি স্কিলের যে কোনো বিকল্প নেই তা আমরা জানি, তবে মানি কজন? অনেক ক্ষেত্রে বাংলাদেশের Backdated Education System থেকে Skill Based Lifestyle অনেক বেশি rewarding। এর বাস্তব প্রমাণ আমরা আশে পাশে চোখ ঘোরালেই দেখতে পাই। তবে তারা আসলে অন্যদের শেখাতে চায়না বা পারেনা। এখানেই আসল সমস্যা। উন্নত বিশ্বে খেয়াল করলে দেখবেন তারা নিজে যা পারে সেটা অন্যকে সেখায়, আর আমরা দেশে নামাজের কাতার বাদে কাউকে আগাতে দেই না। কেন? দুই দিনের দুনিয়ায় তিন দিনই ঝগড়া বিবাদ ও Toxicity তে ডুবে থাকি। চাইলে কী আমরা পারিনা এটা চেঞ্জ করতে? অবশ্যই সম্ভব ইন শা আল্লাহ। সেই লক্ষে আমার পথচলা।',
				'আমি একজন এক্স ক্যাডেট এবং এক্স অফিসার ক্যাডেট। বাংলাদেশ আর্মিতে আমি আমাদের ফুল কোর্সে ৪র্থ হই এবং আমাকে চায়নাতে \'ইনফ্যান্ট্রি এলিমেন্টারি কমান্ডিং কোর্স\' এর জন্য নমিনেট করা হয়েছিল। বর্তমানে আমি চট্টগ্রাম মেডিকেল কলেজের একজন শিক্ষার্থী। এইচএসসির পর পড়াশোনার সাথে সম্পূর্ণ যোগাযোগ না থাকা সত্ত্বেও, জাস্ট সঠিক স্ট্র্যাটেজি এবং আল্লাহর অশেষ রহমতে মাত্র ২২ দিনে কোনো কোচিং বা প্রাইভেট টিচার ছাড়া আমি মেডিকেল ক্র্যাক করি, যা বাংলাদেশে ফার্স্ট।',
				'এছাড়া ২০২০ সাল থেকে ভিডিও এডিটিং, মার্কেটিং, ওয়েব ডেভেলপমেন্ট এবং ডিজিটাল স্ট্র্যাটেজি নিয়ে মাল্টিপল ন্যাশনাল ও ইন্টারন্যাশনাল ব্র্যান্ডের সাথে কাজ করার প্রাক্টিক্যাল এক্সপেরিয়েন্স আমার আছে। আমার নিজের ইউটিউব চ্যানেলের প্রত্যেকটা ভিডিও এর স্পষ্ট দলিল। ভিডিওর প্রথম থেকে শেষ সবটাই আমি করি আলহামদুলিল্লাহ। কষ্ট হয়, তাও করি, কারণ আমি একপ্রকার ভালোবেসে ফেলেছি আমার এই ফিল্ডের কাজগুলো।',
				'আর আমি চাই এই ভালোবাসা মানুষের মাঝে ছড়িয়ে দিতে, যাতে আমরা সবাই, বিশেষ করে বাংলাদেশের Youth দের কে শেখানো কিভাবে ভালোবেসে কোনো কাজ শিখতে হয়, জানতে হয়। স্রেফ করার জন্য করে আসলে লাভ নেই। বরং নিজ থেকে ভালোবেসে কোনো কাজ করাতেই আসল তৃপ্তি। আমার জন্য দুয়া করবেন, আসসালামু আলাইকুম।',
		),
		'sign'    => array( 'https://sraik.com/wp-content/uploads/2026/06/signature.png', 'Shams signature', 538, 370 ),
		'team_l'  => 'The Leadership',
		'team'    => array(
			array( 'Mohammad Kutub Uddin Khan', 'Chairman' ),
			array( 'Tanjil Khan', 'Chief Technology Officer' ),
			array( 'Rina Khan', 'Principal Advisor' ),
			array( 'Mohammad Zia Uddin Khan', 'Patron' ),
			array( 'Mohammad Nasir Uddin Khan', 'Benefactor' ),
		),
	),

	/* ───────────────────────── WHAT WE STAND FOR (benefits) ───────────────────────── */
	'values' => array(
		'eyebrow' => 'What We Stand For',
		'title'   => 'কেন আমরা আলাদা?',
		'sub'     => 'বিচ্ছিন্ন টুলস আর কোর্সের ঝামেলা শেষ — সবকিছু একটাই সিস্টেমে।',
		'items'   => array(
			array( 'infinity', 'Lifetime Access', 'জয়েন করবা একবার, Free Update পাবা আজীবন। অন্যান্য জায়গার মতো মাসিক প্যামেন্ট সিস্টেম আমাদের নেই।' ),
			array( 'zap', 'Instant Access', 'জয়েন করার সাথে সাথে কাজ শুরু, Time waste করার মতো, Time আমাদের নাই।' ),
			array( 'layers', 'All-in-One System', 'হাইব্রিড করনেল মেথড থেকে শুরু করে টেস্ট পেপার সলভিং মেথড — সব কিছু এক জায়গায়।' ),
			array( 'flame', 'No-Motivation Protocol', 'ফেক মোটিভেশন নয় — সম্পূর্ণ অ্যাকশন আর Military সিস্টেম-ড্রিভেন, মুড খারাপ থাকলেও।' ),
			array( 'alarm-clock', 'Military-Grade Routine', 'এক্স-ক্যাডেটের ডিসিপ্লিনড প্রোটোকল আর মেডিকেল স্টুডেন্টের রুটিনের মিশেলে তৈরি।' ),
			array( 'bot', '7 AI Gems', 'রিয়েল টাইম প্রশ্ন, MCQ সলভার আর ২৪/৭ ডাউট ক্লিয়ারিং — পড়াশোনার ডিজিটাল পার্টনার।' ),
		),
	),

	/* ───────────────────────── HOW WE WORK (3 principles) ───────────────────────── */
	'principles' => array(
		'eyebrow' => 'How We Work',
		'title'   => 'Learn. Thrive. Repeat.',
		'sub'     => 'Here is the thing. Training should be about real execution.',
		'items'   => array(
			array( 'target', 'Real execution', 'শুধু ক্লাস দেখে গ্যালারির দর্শক হয়ে বসে থাকার দিন শেষ — প্রতিটি লেসনের পর ডিরেক্ট অ্যাকশন ড্রিল।' ),
			array( 'users', 'Teach what you know', 'উন্নত বিশ্বে তারা নিজে যা পারে সেটা অন্যকে শেখায়। সেই লক্ষেই আমাদের পথচলা।' ),
			array( 'heart', 'Learn it with love', 'স্রেফ করার জন্য করে আসলে লাভ নেই। নিজ থেকে ভালোবেসে কোনো কাজ করাতেই আসল তৃপ্তি।' ),
		),
	),

	/* ───────────────────────── PROGRAMS (open roles) ───────────────────────── */
	'programs' => array(
		'eyebrow' => 'Programs',
		'title'   => 'Find your program',
		'sub'     => 'Every SRAIK training lives on vip.sraik.com — pick the one that fits your goal.',
		/* title, text, category (teal tag), array( icon, format ), third tag, href
		   (a config url key or a path). */
		'rows'    => array(
			array( 'MATACE 3.0 — Player Edition', 'মেডিকেল এডমিশনের কমপ্লিট সেলফ-পেসড সিস্টেম: কারিকুলাম, ১০০+ টেস্ট আর AI tools।', 'Medical', array( 'monitor', 'Self-paced' ), 'Lifetime', 'player' ),
			array( 'MATACE 3.0 — Player Pro Edition', 'Player-এর সবকিছু, সাথে ২ মাস সামসের সাথে সরাসরি ওয়ান টু ওয়ান মেন্টরশিপ।', 'Medical', array( 'users', '1:1 Mentorship' ), '2 months', 'pro' ),
			array( 'Mission: Bypass HSC', 'HSC স্টুডেন্টদের নিজে নিজে পড়ালেখা গুছিয়ে নেওয়ার আর ভাবতে শেখার ফুল সিস্টেম।', 'HSC', array( 'video', 'Action-based' ), 'Mentorship', '/mbhsc/' ),
			array( 'Live Sessions', '১২টি লাইভ সেশনে মেডিকেল, ISSB ও Digital Field-এ Career গড়ার Roadmap।', 'Live', array( 'radio', 'WhatsApp Hotline' ), '12 sessions', 'wa_live' ),
			array( 'English Training', 'SRAIK-এর English ট্রেনিং প্রোগ্রাম — বিস্তারিত দেখো vip.sraik.com/training-এ।', 'English', array( 'globe', 'Online' ), 'Training', 'training' ),
			array( 'ISSB Mentorship', 'ডিফেন্স ক্যারিয়ারের জন্য ISSB প্রস্তুতি: সাইকোলজিক্যাল, GTO ও ভাইভা।', 'Defence', array( 'shield', 'Online' ), 'Mentorship', 'training' ),
		),
	),

	/* ───────────────────────── A STUDENT'S JOURNEY (hiring process) ───────────────────────── */
	'journey' => array(
		'eyebrow' => 'Your Journey',
		'title'   => 'What to expect',
		'sub'     => 'Access Now চাপা থেকে লাইভ মেন্টরশিপ — একজন SRAIK স্টুডেন্টের পথ এমন।',
		'step_l'  => 'Step %d',
		'steps'   => array(
			array( 'Enroll', 'পছন্দের প্রোগ্রামে Access Now চাপো — পেমেন্টের সাথে সাথে dashboard-এ access।' ),
			array( 'Onboarding & MRI', 'Onboarding lesson আর Medical Readiness Index (MRI) 2.0 দিয়ে নিজের অবস্থান যাচাই।' ),
			array( 'Training + assignments', 'অ্যাকশন ভিত্তিক লেসন, প্রতিটির পর অ্যাসাইনমেন্ট আর পার্সোনাল প্রগ্রেস ট্র্যাকিং।' ),
			array( 'Mentorship & live', 'Pro-তে সপ্তাহে ৫ দিন দুপুর ৩টা–৫টা সরাসরি সামসের সাথে ওয়ান টু ওয়ান।' ),
		),
	),

	/* ───────────────────────── DIRECT LINE (open application) ───────────────────────── */
	'contact' => array(
		'kicker' => 'Direct Line',
		'title'  => 'Not sure which program fits?',
		'text'   => 'WhatsApp-এ সরাসরি মেসেজ দাও +8801601013241 নাম্বারে, অথবা মেইল করো shamsfccbd@gmail.com-এ।',
		'button' => array( 'WhatsApp-এ কথা বলো', 'whatsapp' ),
		/* Company registration, from the live about page. */
		'facts'  => array(
			array( 'building-2', 'IT Business' ),
			array( 'file-text', 'Trade Licence TRAD/CHTG/027528/2025' ),
			array( 'map-pin', '123 Sheikh Mujib Road, Chowmuhani, Agrabad, Chattogram' ),
		),
	),
);
