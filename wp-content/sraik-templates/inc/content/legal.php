<?php
/**
 * content/legal.php — /privacy-policy/, /terms/, /refund-policy/ (one
 * array per slug, rendered by templates/page-legal.php).
 *
 * The legal text ('en' / 'bn' of every section, table rows, list items) is
 * copied VERBATIM from the live sraik.com pages; only the grouping into
 * numbered sections is new. The section numbers of the live text ("1.",
 * "১.") are dropped because the layout numbers sections itself (§02 …).
 * 'title', 'note', 'tldr' and 'meta' are short summaries of that text and
 * must never promise more than the text does.
 *
 * Section 'en' / 'bn' are HTML: <p>, <ul>, <li>, <strong> only.
 * 'table' rows: array( label_en, text_en, label_bn, text_bn, chip ).
 * 'cards': array( kicker, title, text, foot ).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(

	/* Shared chrome */
	'_tabs'    => array(
		'privacy-policy' => array( 'Privacy', 'eye-off' ),
		'terms'          => array( 'Terms', 'file-text' ),
		'refund-policy'  => array( 'Refund', 'receipt' ),
	),
	'_ui'      => array(
		'readonly' => 'read-only',
		'reading'  => 'reading time',
		'owner'    => 'owner',
		'language' => 'language',
		'langs'    => array( 'en' => 'English', 'bn' => 'বাংলা' ),
		'tldr'     => 'TL;DR',
		'tldr_r'   => 'The short version',
		'contents' => 'Contents',
		'related'  => 'Related',
		'note'     => 'Plain English',
		'contact'  => 'Contact',
		'wa'       => 'WhatsApp',
	),
	'_related' => array(
		array( 'Privacy Policy', '/privacy-policy/' ),
		array( 'Terms and Conditions', '/terms/' ),
		array( 'Refund Policy', '/refund-policy/' ),
		array( 'Support', '/support/' ),
	),

	/* ------------------------------------------------------------------ */
	'privacy-policy' => array(
		'eyebrow' => 'Legal · Privacy',
		'title'   => 'Privacy, <span class="hl">in plain English.</span>',
		'sub'     => 'What Sraik collects, how it is used and how it is protected — with a plain-English summary next to every section.',
		'file'    => 'privacy-policy.md',
		'meta'    => array(
			array( 'effective', 'May 22, 2026' ),
			array( 'organization', 'Sraik' ),
			array( 'website', 'sraik.com' ),
		),
		'tldr'    => array(
			array( 'ban', 'Never sold', 'We do not sell or share your personal data without your explicit consent.' ),
			array( 'database', 'Only what training needs', 'Account details, basic technical data and the messages you send us.' ),
			array( 'lock', 'Passwords encrypted', 'Passwords are secured with industry-standard encryption.' ),
			array( 'key-round', 'Your login, your duty', 'Keep your credentials private and reset them if anything looks wrong.' ),
		),
		'sections' => array(
			array(
				'id'    => 'about',
				'title' => array( 'About this policy', 'এই নীতি সম্পর্কে' ),
				'note'  => 'What Sraik collects, how it is used and how it is kept safe.',
				'en'    => '<p>At <strong>Sraik</strong>, the privacy and security of your personal data are of paramount importance. This Privacy Policy outlines the nature of the information we collect, the methodology of its usage, and the rigorous measures we employ to safeguard your digital assets.</p>',
				'bn'    => '<p>কার্যকরী তারিখ: ২২ মে, ২০২৬<br>প্রতিষ্ঠান: Sraik<br>ওয়েবসাইট: sraik.com</p><p><strong>Sraik</strong>-এ আপনার ব্যক্তিগত তথ্যের গোপনীয়তা এবং নিরাপত্তা আমাদের কাছে অত্যন্ত গুরুত্বপূর্ণ। এই গোপনীয়তা নীতিতে ব্যাখ্যা করা হয়েছে যে আমরা কী ধরনের তথ্য সংগ্রহ করি, কীভাবে তা ব্যবহার করি এবং কীভাবে আপনার তথ্য সুরক্ষিত রাখি।</p>',
			),
			array(
				'id'    => 'collect',
				'title' => array( 'Information we collect', 'আমরা যে তথ্য সংগ্রহ করি' ),
				'note'  => 'Your account details, basic device and log data, and what you send to support.',
				'en'    => '<p>We collect necessary personal and technical data to facilitate the delivery of our training and programs:</p>',
				'bn'    => '<p>আমাদের ট্রেনিং এবং প্রোগ্রামগুলো সুষ্ঠুভাবে পরিচালনার জন্য আমরা নিম্নোক্ত ব্যক্তিগত ও প্রযুক্তিগত তথ্য সংগ্রহ করতে পারি:</p>',
				'table' => array(
					'title' => 'data · collected',
					'cols'  => array( 'Type', 'Includes', 'Gathered via' ),
					'rows'  => array(
						array( 'Personal Information', 'Full name, email address, phone number, residential address, profile imagery, and any additional details provided during account registration or through direct communication.', 'ব্যক্তিগত তথ্য', 'পূর্ণ নাম, ইমেইল ঠিকানা, ফোন নম্বর, বাসার ঠিকানা, প্রোফাইল ছবি এবং অ্যাকাউন্ট তৈরির সময় বা আমাদের সাথে যোগাযোগ করার সময় আপনার প্রদান করা অন্যান্য তথ্য।', 'Registration' ),
						array( 'Technical Information', 'Data such as IP addresses, browser specifications, device identifiers, and access timestamps, gathered via log files and cookies to optimize platform performance.', 'প্রযুক্তিগত তথ্য', 'আইপি অ্যাড্রেস, ব্রাউজার ও ডিভাইসের ধরন, ওয়েবসাইট অ্যাক্সেসের সময় ইত্যাদি (লগ ফাইল এবং কুকিজের মাধ্যমে)।', 'Logs · cookies' ),
						array( 'Communication Data', 'Correspondence logs, including emails, messages, and attachments submitted when engaging with our support infrastructure.', 'যোগাযোগের তথ্য', 'ইমেইল, মেসেজ, সংযুক্ত ফাইল বা আমাদের সাথে যোগাযোগের সময় আপনার পাঠানো যেকোনো তথ্য।', 'Support' ),
					),
				),
			),
			array(
				'id'    => 'usage',
				'title' => array( 'How we use information', 'আপনার তথ্য যেভাবে ব্যবহৃত হয়' ),
				'note'  => 'To run the platform, help you and improve the training. Never sold.',
				'en'    => '<p>Your information is utilized solely to enhance your experience and maintain the integrity of our services:</p><ul><li>Operating, maintaining, and scaling our digital platform.</li><li>Personalizing and refining the user experience.</li><li>Providing comprehensive support and resolving technical inquiries.</li><li>Notifying users of updates, new training modules, or service enhancements.</li><li>Ensuring platform security and preventing fraudulent activity.</li><li>Optimizing the quality of our training materials and content.</li></ul><p>Sraik maintains a strict non-disclosure policy; we do not sell or disseminate your personal data to third parties without your explicit consent.</p>',
				'bn'    => '<p>আপনার ব্যক্তিগত তথ্য নিম্নলিখিত উদ্দেশ্যে ব্যবহৃত হতে পারে:</p><ul><li>আমাদের ওয়েবসাইট পরিচালনা ও রক্ষণাবেক্ষণ।</li><li>ব্যবহারকারীর অভিজ্ঞতা উন্নত করা।</li><li>ব্যবহারকারীকে সহায়তা প্রদান এবং জিজ্ঞাসার উত্তর দেওয়া।</li><li>নতুন ফিচার, ট্রেনিং বা সার্ভিস সম্পর্কে আপডেট প্রদান।</li><li>নিরাপত্তা নিশ্চিত করা এবং জালিয়াতি প্রতিরোধ।</li><li>আমাদের ট্রেনিং ও কন্টেন্ট উন্নত করা।</li></ul><p>আপনার সুস্পষ্ট সম্মতি ছাড়া আমরা আপনার ব্যক্তিগত তথ্য কোনো তৃতীয় পক্ষের কাছে বিক্রি বা শেয়ার করি না।</p>',
			),
			array(
				'id'    => 'security',
				'title' => array( 'Password & account security', 'পাসওয়ার্ড ও অ্যাকাউন্টের নিরাপত্তা' ),
				'note'  => 'Passwords are encrypted. Keeping your login secret is up to you.',
				'en'    => '<p>Account security is a shared responsibility. While we employ industry-standard encryption to secure your passwords, ensuring the confidentiality of your login credentials remains the user\'s obligation. Should you suspect any unauthorized access, you are advised to reset your password immediately or contact our support team.</p>',
				'bn'    => '<p>আমরা আপনার অ্যাকাউন্টের পাসওয়ার্ড নিরাপদে এনক্রিপ্ট করে রাখি, যাতে আমরা নিজেও এটি দেখতে না পারি। আপনার পাসওয়ার্ড গোপনীয় রাখা আপনার দায়িত্ব। যদি আপনার মনে হয় কেউ আপনার পাসওয়ার্ড জেনে ফেলেছে, তবে দ্রুত তা পরিবর্তন করুন অথবা আমাদের সাপোর্ট টিমের সাথে যোগাযোগ করুন।</p>',
			),
			array(
				'id'    => 'consent',
				'title' => array( 'Consent & contact', 'সম্মতি ও যোগাযোগ' ),
				'note'  => 'Using sraik.com means you accept this policy. Questions go to our email.',
				'en'    => '<p>By accessing sraik.com, you acknowledge and consent to this Privacy Policy. For inquiries regarding data protection, please contact us at <strong>shamsfccbd@gmail.com</strong>.</p>',
				'bn'    => '<p>আমাদের ওয়েবসাইট ব্যবহার করার মাধ্যমে ধরে নেওয়া হয় যে আপনি এই গোপনীয়তা নীতি গ্রহণ করেছেন। আপনার কোনো প্রশ্ন থাকলে বা সহায়তার প্রয়োজন হলে, নির্দ্বিধায় আমাদের সাথে যোগাযোগ করুন (shamsfccbd@gmail.com)। Sraik আপনার তথ্যের গোপনীয়তা রক্ষা করতে সর্বদা প্রতিশ্রুতিবদ্ধ।</p>',
			),
		),
		'side'    => array( 'Privacy questions?', 'Email us about your data, or message the support team on WhatsApp.', 'Email us' ),
		'contact' => array(
			'title' => 'Questions about your data?',
			'text'  => 'For inquiries regarding data protection, email us or message the support team on WhatsApp.',
			'btn'   => 'Email us',
		),
	),

	/* ------------------------------------------------------------------ */
	'terms' => array(
		'eyebrow' => 'Legal · Terms',
		'title'   => 'Terms, <span class="hl">in plain English.</span>',
		'sub'     => 'The rules for using Sraik\'s training, content and platforms — with a plain-English summary next to every section.',
		'file'    => 'terms.md',
		'meta'    => array(
			array( 'effective', 'May 22, 2026' ),
			array( 'website', 'sraik.com' ),
		),
		'tldr'    => array(
			array( 'user-check', 'One account, one person', 'Your account is personal: no sharing, one device at a time.' ),
			array( 'file-lock', 'Content stays ours', 'Learn from every lesson; copying or re-uploading it is prohibited.' ),
			array( 'credit-card', 'Pay through official channels', 'Use the website or an authorized gateway. Access opens right after.' ),
			array( 'receipt', 'Purchases are final', 'All purchases are final and non-refundable.' ),
		),
		'sections' => array(
			array(
				'id'    => 'agreement',
				'title' => array( 'Agreement', 'সম্মতি' ),
				'note'  => 'Using any Sraik training, content or platform means you accept these terms.',
				'en'    => '<p>By accessing or utilizing the educational infrastructure, content, or digital platforms provided by <strong>Sraik (sraik.com)</strong>, you formally acknowledge and agree to the following terms.</p>',
				'bn'    => '<p>কার্যকরী তারিখ: ২২ মে, ২০২৬</p><p>আপনি যখন <strong>Sraik (sraik.com)</strong>-এর কোনো ট্রেনিং, কন্টেন্ট বা ডিজিটাল প্ল্যাটফর্ম ব্যবহার করেন, তখন ধরে নেওয়া হয় যে আপনি নিম্নলিখিত শর্তাবলি মেনে নিয়েছেন।</p>',
			),
			array(
				'id'    => 'account',
				'title' => array( 'Account & user integrity', 'অ্যাকাউন্ট ও ব্যবহারকারী নীতি' ),
				'note'  => 'One account, one person, one device at a time. Use your real details.',
				'en'    => '<p>Your Sraik account is strictly personal and non-transferable. Unauthorized sharing of credentials is prohibited and may result in the permanent termination of your access. Each enrollment is designated solely for the individual purchaser; usage by siblings, family members, or third parties is not permitted. Concurrent logins are restricted; you may access your training materials from one device at a time. Users are responsible for providing accurate registration data (full name, email, etc.), as this information is used for official certification. The provision of fraudulent or inaccurate data constitutes a violation of our policy and will lead to immediate suspension.</p>',
				'bn'    => '<p>আপনার অ্যাকাউন্ট (ইউজারনেম ও পাসওয়ার্ড) কঠোরভাবে ব্যক্তিগত এবং হস্তান্তরযোগ্য নয়। অন্যদের সাথে অ্যাকাউন্ট শেয়ার করা হলে তা বাতিল করা হতে পারে। প্রতিটি ট্রেনিং শুধুমাত্র আপনার ব্যক্তিগত ব্যবহারের জন্য—সহোদর বা পরিবারের অন্য কোনো সদস্য এটি ব্যবহার করতে পারবেন না। আপনি এক সময়ে শুধুমাত্র একটি ডিভাইস থেকে ট্রেনিংয়ের উপকরণগুলোতে লগ ইন করতে পারবেন। রেজিস্ট্রেশনের সময় প্রদানকৃত তথ্য (নাম, ইমেইল ইত্যাদি) অবশ্যই সঠিক হতে হবে, কারণ আপনার সার্টিফিকেট এই তথ্যের ভিত্তিতে তৈরি করা হবে। ভুল বা মিথ্যা তথ্য প্রদান করা হলে Sraik আপনার অ্যাক্সেস স্থগিত করার অধিকার রাখে।</p>',
			),
			array(
				'id'    => 'copyright',
				'title' => array( 'Intellectual property & copyright', 'কন্টেন্ট ও কপিরাইট' ),
				'note'  => 'Every lesson belongs to Sraik. Learn from it; don\'t copy, share or re-upload it.',
				'en'    => '<p>All content—including but not limited to video lectures, audio files, and textual materials—is the exclusive intellectual property of Sraik. Unauthorized reproduction, distribution, or uploading of this content to external platforms is strictly prohibited and subject to legal action. Digital assets may feature embedded watermarks for security purposes. Content is licensed for individual educational use only; users may not, under any circumstances, claim ownership or attempt to redistribute our materials.</p>',
				'bn'    => '<p>Sraik-এর ট্রেনিংয়ের ভিডিও, অডিও বা টেক্সট কন্টেন্ট অনুমতি ছাড়া কপি করা, শেয়ার করা বা অন্য কোথাও আপলোড করা আইনত দণ্ডনীয় অপরাধ। প্রতিটি ভিডিওতে আপনার ইমেইল ওয়াটারমার্ক হিসেবে থাকতে পারে এবং এই কন্টেন্টের মালিকানা সম্পূর্ণভাবে Sraik-এর। আপনি কন্টেন্টগুলো শুধুমাত্র শেখার উদ্দেশ্যে ব্যবহার করতে পারবেন, কিন্তু এগুলোর মালিকানা দাবি করতে পারবেন না।</p>',
			),
			array(
				'id'    => 'payment',
				'title' => array( 'Payment & service provision', 'পেমেন্ট ও সেবা প্রদান' ),
				'note'  => 'Pay only on the website or an authorized gateway. Access opens once payment is verified.',
				'en'    => '<p>Payments must be processed exclusively through our official website or authorized payment gateways. Sraik accepts no liability for transactions conducted through unofficial channels. Upon successful verification of payment, access to your selected program will be granted immediately.</p>',
				'bn'    => '<p>পেমেন্ট শুধুমাত্র আমাদের ওয়েবসাইট বা অনুমোদিত পেমেন্ট গেটওয়ের মাধ্যমে করুন। অন্য কোনো উপায়ে করা পেমেন্টের দায়িত্ব Sraik বহন করবে লালন করবে না। অনলাইন পেমেন্ট সম্পন্ন হওয়ার পর আপনি অবিলম্বে আপনার প্রোগ্রামে অ্যাক্সেস পাবেন।</p>',
			),
			array(
				'id'    => 'support',
				'title' => array( 'Support & code of conduct', 'সাপোর্ট ও আচরণবিধি' ),
				'note'  => 'Support runs daily, 9 AM to 9 PM. Be respectful in every group and chat.',
				'en'    => '<p>We are committed to providing technical support with a resolution target of 24 hours. Our support services are operational daily from 9:00 AM to 9:00 PM. We maintain a zero-tolerance policy regarding disrespectful behavior. Members must observe professional decorum in all community forums, chats, and social groups. Prohibited conduct, including personal attacks, political discourse, or spam, will lead to the immediate revocation of platform privileges.</p>',
				'bn'    => '<p>আমরা সাধারণত ২৪ ঘণ্টার মধ্যে ট্রেনিং-সংক্রান্ত সমস্যা সমাধান করার চেষ্টা করি। আমাদের সাপোর্ট টিম প্রতিদিন সকাল ৯টা থেকে রাত ৯টা পর্যন্ত সক্রিয় থাকে। গ্রুপ, চ্যাট বা যেকোনো কমিউনিটিতে মার্জিত, শ্রদ্ধাশীল এবং ইতিবাচক আচরণ বজায় রাখুন। ব্যক্তিগত আক্রমণ, রাজনৈতিক মন্তব্য বা স্প্যামিংয়ের মতো কর্মকাণ্ডে লিপ্ত হলে অ্যাকাউন্ট স্থগিত করা হতে পারে।</p>',
				'cards' => array(
					array( 'support · hours', '9:00 AM – 9:00 PM', 'Support is operational every day.', 'সকাল ৯টা – রাত ৯টা' ),
					array( 'support · target', '24 hours', 'Resolution target for technical issues.', '২৪ ঘণ্টা' ),
				),
			),
			array(
				'id'    => 'policies',
				'title' => array( 'Operational policies', 'অন্যান্য নীতি' ),
				'note'  => 'Purchases are final. Mentorships run 1–3 months. These terms can be updated.',
				'en'    => '<p>All purchases are final and non-refundable. Mentorship programs range from 1 to 3 months, as specified during enrollment. Any detection of suspicious activity, such as multiple device abuse or systematic account sharing, will trigger an automated limitation of access. Sraik reserves the right to modify these terms periodically to reflect operational changes. Continued use of the platform constitutes acceptance of all current and updated terms.</p>',
				'bn'    => '<p>একবার কোনো ট্রেনিং বা প্রোগ্রাম কেনা হলে তা পরিবর্তন বা রিফান্ড করা সম্ভব নয়। আমাদের মেন্টরশিপ প্রোগ্রামের মেয়াদ সাধারণত ১ থেকে ৩ মাস পর্যন্ত হয়ে থাকে। একাধিক ডিভাইসে লগ ইন করা বা সন্দেহজনক কার্যক্রম পরিলক্ষিত হলে আপনার অ্যাক্সেস সীমিত করা হতে পারে। Sraik যেকোনো সময় এই শর্তাবলি পরিবর্তন বা আপডেট করার অধিকার রাখে। আপনি যখন আমাদের প্ল্যাটফর্ম ব্যবহার করেন, তখন ধরে নেওয়া হয় যে আপনি এই সকল শর্তাবলিতে সম্মত হয়েছেন।</p>',
			),
		),
		'side'    => array( 'Questions about the terms?', 'Email us, or message the support team on WhatsApp.', 'Email us' ),
		'contact' => array(
			'title' => 'Questions about these terms?',
			'text'  => 'Email us or message the support team on WhatsApp. Support is operational daily from 9:00 AM to 9:00 PM.',
			'btn'   => 'Email us',
		),
	),

	/* ------------------------------------------------------------------ */
	'refund-policy' => array(
		'eyebrow' => 'Legal · Refund',
		'title'   => 'Refunds, <span class="hl">in plain English.</span>',
		'sub'     => 'How payments, refunds and program exchanges work at Sraik — with a plain-English summary next to every section.',
		'file'    => 'refund-policy.md',
		'meta'    => array(
			array( 'effective', 'May 22, 2026' ),
			array( 'organization', 'Sraik' ),
			array( 'website', 'sraik.com' ),
		),
		'tldr'    => array(
			array( 'ban', 'No refunds', 'Payments are final, whether the program is online or offline.' ),
			array( 'repeat', 'No exchanges', 'A purchased program cannot be swapped for another.' ),
			array( 'headphones', 'Problems get fixed', 'If a program has an issue, the team works to resolve it.' ),
			array( 'receipt', 'Final at purchase', 'Every sale is final at the time of purchase.' ),
		),
		'sections' => array(
			array(
				'id'    => 'welcome',
				'title' => array( 'Welcome', 'স্বাগতম' ),
				'note'  => 'Thanks for joining. Here is how purchases work at Sraik.',
				'en'    => '<p>Welcome to Sraik. Thank you for your interest in our programs. We are dedicated to ensuring you have a positive and productive experience throughout your journey with our training and educational materials.</p>',
				'bn'    => '<p>কার্যকরী তারিখ: ২২ মে, ২০২৬<br>প্রতিষ্ঠান: Sraik<br>ওয়েবসাইট: sraik.com</p><p>Sraik এ আপনাকে স্বাগতম। আমাদের ট্রেনিং প্রোগ্রামের প্রতি আগ্রহ প্রকাশ করার জন্য আপনাকে ধন্যবাদ। আমরা চাই যে আমাদের বিভিন্ন প্রোগ্রাম এবং লার্নিং ম্যাটেরিয়াল ব্যবহারের মাধ্যমে আপনি একটি চমৎকার ও ইতিবাচক অভিজ্ঞতা অর্জন করুন।</p>',
			),
			array(
				'id'    => 'refunds',
				'title' => array( 'Refund policy', 'রিফান্ড পলিসি' ),
				'note'  => 'No refunds, online or offline. If something is wrong, we help fix it.',
				'en'    => '<p>Upon the purchase of any Sraik program, payments are final. We do not issue refunds for any reason, whether the engagement is online or offline. Should you encounter any issues with a program, our team will work to resolve them for you, but financial refunds will not be provided under any circumstances.</p>',
				'bn'    => '<p>আমাদের প্রোগ্রামগুলো কেনার পর, কোনো অবস্থাতেই রিফান্ড দেওয়া হয় না, তা অনলাইন হোক বা অফলাইন। প্রোগ্রামে কোনো সমস্যা দেখা দিলে আমরা তা সমাধানের সর্বোচ্চ চেষ্টা করব, কিন্তু কোনো অবস্থাতেই টাকা ফেরত দেওয়া হবে না।</p>',
			),
			array(
				'id'    => 'exchange',
				'title' => array( 'Program exchange policy', 'প্রোগ্রাম এক্সচেঞ্জ পলিসি' ),
				'note'  => 'Once bought, a program cannot be changed or swapped for another.',
				'en'    => '<p>We do not facilitate the exchange of programs. Once a program is purchased, it cannot be modified or swapped for another. We do not offer or support the exchange of any services once an enrollment is confirmed.</p>',
				'bn'    => '<p>আমরা প্রোগ্রাম এক্সচেঞ্জ করার সুযোগও প্রদান করি না। একবার কোনো প্রোগ্রাম কেনা হলে, তা পরিবর্তন বা অন্য কোনো প্রোগ্রামের সাথে বিনিময় করা সম্ভব নয়। আমাদের প্রোগ্রামগুলোর ক্ষেত্রে কোনো সার্ভিস এক্সচেঞ্জ আমরা উৎসাহিত করি না।</p>',
			),
			array(
				'id'    => 'finality',
				'title' => array( 'Policy finality', 'পলিসির চূড়ান্ত সিদ্ধান্ত' ),
				'note'  => 'Every sale is final when you buy, so there is no refund timeline.',
				'en'    => '<p>Please note that all sales are considered final at the time of purchase. We do not offer any processing timelines for refunds as we maintain a strict no refund policy for all users.</p><p>Thank you for your understanding and adherence to our policy.</p>',
				'bn'    => '<p>দয়া করে মনে রাখবেন যে আমাদের রিফান্ড প্রদানের কোনো ব্যবস্থা নেই। যেহেতু আমরা কঠোরভাবে কোনো রিফান্ড প্রদান করি না, তাই রিফান্ড প্রসেসিংয়ের কোনো সময়সীমাও প্রযোজ্য নয়।</p><p>আমাদের পলিসি বোঝার জন্য এবং সহযোগিতা করার জন্য আপনাকে ধন্যবাদ।</p>',
			),
		),
		'side'    => array( 'Problem with a program?', 'Tell us what went wrong. The team works to resolve program issues.', 'Email us' ),
		'contact' => array(
			'title' => 'Questions about a purchase?',
			'text'  => 'Email us or message the support team on WhatsApp. Support is operational daily from 9:00 AM to 9:00 PM.',
			'btn'   => 'Email us',
		),
	),
);
