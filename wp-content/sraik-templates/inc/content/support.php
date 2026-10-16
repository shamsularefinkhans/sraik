<?php
/**
 * content/support.php — every word on /support/, on the Code Craft docs layout.
 *
 * Section order follows the template: sticky help-center sidebar, then
 * overview card + 4 quick cards → enrol on the website (4 numbered steps
 * with copyable boxes, "Quickstart") → Player vs Pro ("Core concepts") →
 * WhatsApp order (request / response panels, "REST API") → payment
 * methods ("SDKs") → payment video → help routes → contact form → CTA.
 *
 * Facts come from the live support page (contact details, the WhatsApp
 * form) and the FAQ answers in content/faq.php (enrolment, payment,
 * WhatsApp order). Inline tags allowed: <span class="hl">, <br>, <strong>, <em>, <a>.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(

	/* ───────────────────────── SIDEBAR ───────────────────────── */
	'side' => array(
		'title'  => 'Help Center',
		'meta'   => 'SRAIK · Support',
		'groups' => array(
			array(
				'label' => 'Get started',
				'links' => array(
					array( 'Overview', '#overview' ),
					array( 'Website-এ ভর্তি', '#enroll' ),
				),
			),
			array(
				'label' => 'Learn',
				'links' => array(
					array( 'Player vs Pro', '#editions' ),
				),
			),
			array(
				'label' => 'Reference',
				'links' => array(
					array( 'WhatsApp-এ ভর্তি', '#whatsapp-order' ),
					array( 'Payment', '#payment' ),
					array( 'Video tutorial', '#payment-video' ),
				),
			),
			array(
				'label' => 'Resources',
				'links' => array(
					array( 'Help & support', '#help' ),
					array( 'Contact form', '#contact' ),
					array( 'FAQ', '/faq/', true ),
				),
			),
		),
		'card'   => array(
			'title' => 'আটকে গেছো?',
			'text'  => 'WhatsApp-এ সরাসরি মেসেজ দাও, অথবা নিচের ফর্মটা পূরণ করো।',
			'link'  => array( 'WhatsApp-এ লেখো', 'whatsapp' ),
		),
	),

	/* ───────────────────────── OVERVIEW ───────────────────────── */
	'overview' => array(
		'crumbs'    => array( 'Support', 'Overview' ),
		'title'     => 'SRAIK <span class="hl">Help Center</span>',
		'sub'       => 'Whether you\'re facing a technical issue with the platform or have questions about a training module, our support team is ready to execute a solution.',
		'primary'   => array( 'ভর্তির ধাপগুলো দেখো', '#enroll' ),
		'secondary' => array( 'ভিডিও টিউটোরিয়াল', '#payment-video' ),
		'icon'      => 'headphones',
		/* icon, title, text, href */
		'cards'     => array(
			array( 'rocket', 'Enroll', 'Website-এ চার ধাপে ভর্তি।', '#enroll' ),
			array( 'wallet', 'Payment', 'বিকাশ, নগদ, card — SSLCOMMERZ।', '#payment' ),
			array( 'user-round', 'Account', 'Login আর তোমার dashboard।', 'dashboard' ),
			array( 'message-circle', 'WhatsApp order', 'Cash বা কিস্তিতে ভর্তি।', '#whatsapp-order' ),
		),
	),

	/* ───────────────────────── ENROL ON THE WEBSITE (quickstart) ───────────────────────── */
	'enroll' => array(
		'label' => 'Website-এ ভর্তি',
		'icon'  => 'rocket',
		'title' => 'Access Now থেকে dashboard, চার ধাপে',
		'sub'   => 'তোমার বিকাশ/নগদ/card-এ টাকা থাকলে website-এ checkout করো, এটাই সবচেয়ে সহজ আর সাথে সাথে access পাবে।',
		/* title, text, box (mono value), copy (true = copy button) */
		'steps' => array(
			array( 'Access Now চাপো', 'পছন্দের প্রোগ্রামের Access Now-এ click করো, তারপর Checkout। একসাথে একাধিক course নিতে View Cart।', 'vip.sraik.com/training/', true ),
			array( 'Checkout ফর্ম পূরণ করো', 'নির্ভুলভাবে valid Gmail, username, password, ফোন নাম্বার ও নাম লিখে Place Order চাপো।', 'Gmail · Username · Password · Phone · Name', false ),
			array( 'পেমেন্ট করো', 'Mobile Banking থেকে বিকাশ select করে Pay চাপো, তারপর verification code আর PIN — অথবা নগদ বা card।', 'bKash · Nagad · Rocket · Upay · Card · Bank', false ),
			array( 'Dashboard-এ শুরু করো', 'Payment-এর পর সরাসরি dashboard-এ নিয়ে যাবে, সেখানে দেখবে already enrolled। Start চাপলেই প্রথম ভিডিও।', 'vip.sraik.com/dashboard', true ),
		),
	),

	/* ───────────────────────── PLAYER VS PRO (core concepts) ───────────────────────── */
	'editions' => array(
		'label' => 'Player vs Pro',
		'icon'  => 'users',
		'title' => 'কোনটা তোমার জন্য?',
		'sub'   => 'নিজে পড়ে নিজে করতে পারলে, শুধু roadmap দেখিয়ে দিলেই হয়, তাহলে Player Edition। Live session, সরাসরি কথা আর feedback চাইলে Player Pro।',
		/* icon, title, text, link label, href */
		'cards' => array(
			array( 'monitor-play', 'Player Edition', 'সব training lesson, assignment, AI tools আর Military Grade Routine — recorded, self-paced।', 'ভিডিওতে দেখো', 'https://youtu.be/vbzhLZ7LNhw?t=276' ),
			array( 'headphones', 'Player Pro মেন্টরশিপ', 'Player-এর সবকিছু, সাথে ভর্তির দিন থেকে ২ মাস সামস ভাইয়ার সাথে সরাসরি কথা আর feedback।', 'ভিডিওতে দেখো', 'https://youtu.be/vbzhLZ7LNhw?t=223' ),
			array( 'bot', 'AI tools', 'MCQ Solver, Playmaker Gem আর Pro-তে ম্যাট কোশ্চেন ল্যাব — রিয়েল টাইম মেডিকেল স্ট্যান্ডার্ড প্রশ্ন।', 'ফিচারগুলো দেখো', '/features/' ),
		),
	),

	/* ───────────────────────── WHATSAPP ORDER (REST API) ───────────────────────── */
	'order' => array(
		'label'    => 'WhatsApp-এ ভর্তি',
		'icon'     => 'message-circle',
		'title'    => 'Order on WhatsApp',
		'sub'      => 'হাতে cash আছে কিন্তু account-এ নেই, বা ২-৩ ভাগে কিস্তিতে দিতে চাও? তাহলে website-এর বদলে Order on WhatsApp।',
		'method'   => 'Send',
		'endpoint' => 'wa.me/8801601013241',
		'text'     => 'Program-এর Access Now চেপে Order on WhatsApp-এ click করো। Form পূরণ করে Send on WhatsApp চাপলে message রেডি হয়ে WhatsApp খুলে যাবে, শুধু send করবে।',
		'fields_l' => 'Form fields',
		/* name, type, required?, text */
		'fields'   => array(
			array( 'নাম', 'text', true, 'তোমার নাম।' ),
			array( 'email', 'Gmail', true, 'যে email-এ access নিতে চাও।' ),
			array( 'mobile', 'number', false, 'Mobile number optional।' ),
			array( 'note', 'text', false, 'কিছু বলার থাকলে লিখবে, না থাকলে লাগবে না।' ),
		),
		'req_l'    => 'You send',
		'req_tag'  => 'WhatsApp',
		'request'  => array(
			array( 'Order on WhatsApp', '' ),
			array( 'নাম:', 'তোমার নাম' ),
			array( 'email:', 'access-এর Gmail' ),
			array( 'mobile:', 'optional' ),
			array( 'note:', 'optional' ),
		),
		'res_l'    => 'Auto reply',
		'res_tag'  => '৩টা কাজ',
		'response' => array(
			array( '১.', 'ওই email দিয়ে website-এ free student account খোলো' ),
			array( '২.', 'দেওয়া number-এ Send Money করো' ),
			array( '৩.', 'payment-এর screenshot পাঠাও' ),
		),
		'res_note' => 'Account manager payment verify করে তোমার email-এ program enroll করে দেবে।',
	),

	/* ───────────────────────── PAYMENT (SDKs) ───────────────────────── */
	'payment' => array(
		'label'   => 'Payment',
		'icon'    => 'credit-card',
		'title'   => 'যেভাবে পেমেন্ট করবে',
		'sub'     => 'Website-এ SSLCOMMERZ-এর মাধ্যমে payment হয়, যেটা বাংলাদেশের licensed payment gateway। বিকাশ, নগদ, রকেট, উপায়, bank, card সব দিয়েই করতে পারবে।',
		/* icon, name, meta, box */
		'methods' => array(
			array( 'smartphone', 'bKash', 'SSLCOMMERZ', 'Mobile Banking → bKash → Pay' ),
			array( 'wallet', 'Nagad', 'SSLCOMMERZ', 'Mobile Banking → Nagad → Pay' ),
			array( 'credit-card', 'Card & Bank', 'SSLCOMMERZ', 'Card / bank → instant access' ),
		),
		'badge'   => array( 'brand/sslcommerz-pay-with-logo.webp', 'Pay securely with SSLCOMMERZ' ),
	),

	/* ───────────────────────── VIDEO TUTORIAL ───────────────────────── */
	'video' => array(
		'label'   => 'Video tutorial',
		'icon'    => 'video',
		'title'   => 'ভর্তি আর পেমেন্ট — পুরোটা ভিডিওতে',
		'sub'     => 'Access Now থেকে checkout, বিকাশ পেমেন্ট আর dashboard পর্যন্ত প্রতিটা ধাপ স্ক্রিনে দেখানো আছে।',
		'id'      => 'vbzhLZ7LNhw',
		'start'   => 366,
		'poster'  => 'https://i.ytimg.com/vi/vbzhLZ7LNhw/maxresdefault.jpg',
		'caption' => 'ভর্তি ও পেমেন্ট টিউটোরিয়াল',
		'yt'      => 'https://youtu.be/vbzhLZ7LNhw?t=366',
	),

	/* ───────────────────────── STILL HAVE QUESTIONS (routes) ───────────────────────── */
	'help' => array(
		'label'  => 'Help & support',
		'icon'   => 'circle-help',
		'title'  => 'আরও প্রশ্ন আছে?',
		'sub'    => 'উত্তর পাওয়ার সবচেয়ে দ্রুত রাস্তাটা বেছে নাও।',
		/* icon, title, text, href */
		'routes' => array(
			array( 'mail', 'Contact support', 'shamsfccbd@gmail.com · Phone 01601013241 · WhatsApp +8801601013241', '#contact' ),
			array( 'newspaper', 'Blog পড়ো', 'মেডিকেল এডমিশন স্ট্র্যাটেজি, স্টাডি সিস্টেম আর স্টুডেন্টদের গল্প।', '/blog/' ),
			array( 'circle-help', 'FAQ', 'প্রোগ্রাম, দাম, ভর্তি আর পেমেন্ট নিয়ে সব প্রশ্নের সরাসরি উত্তর।', '/faq/' ),
			array( 'receipt', 'Refund policy', 'SRAIK-এর refund শর্ত আর কিভাবে request করবে।', '/refund-policy/' ),
		),
	),

	/* ───────────────────────── CONTACT FORM (live support form) ───────────────────────── */
	'contact' => array(
		'label'   => 'Contact form',
		'icon'    => 'send',
		'title'   => 'Need Assistance?',
		'sub'     => 'Fill out the details below to connect directly with us — the form opens WhatsApp with your message ready to send.',
		'form'    => array(
			'name'    => array( 'Full Name', 'Enter your full name' ),
			'phone'   => array( 'Phone Number', 'e.g. 01XXXXXXXXX' ),
			'subject' => array( 'Subject', 'Briefly describe your issue' ),
			'details' => array( 'Details', 'Provide as much context as possible so we can resolve this quickly.' ),
			'submit'  => 'Connect on WhatsApp',
		),
		'direct_l' => 'Direct Contact',
		'direct'   => array(
			array( 'Location', '123 Sheikh Mujib Road, Chowmuhani, Agrabad, Chittagong, Bangladesh', '' ),
			array( 'Phone Support', '01601013241', 'tel:+8801601013241' ),
			array( 'Email Support', 'shamsfccbd@gmail.com', 'mailto:shamsfccbd@gmail.com' ),
		),
		'net_l'    => 'Our Network',
	),
);
