<?php
/**
 * about/mentor.php — the founder card (photo, the live #mentor bio,
 * signature, social links) and the leadership row from the live about
 * page. The careers template has no slot for a person, so the card is
 * built from its own pieces: glossy card, mono kicker, tag pills.
 *
 * $s = content/about.php ['mentor']
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="sec" id="mentor">
  <div class="sec-in ab-sec">
    <?php echo sraik_sh( array( 'eyebrow' => $s['eyebrow'], 'icon' => 'sparkles', 'title' => $s['title'], 'sub' => $s['sub'] ) ); // phpcs:ignore ?>

    <div class="ab-mentor-wrap">
      <article class="card ab-mentor" data-appear>
        <figure class="ab-mentor-ph">
          <img src="<?php echo esc_url( $s['photo'][0] ); ?>" alt="<?php echo esc_attr( $s['photo'][1] ); ?>" width="<?php echo (int) $s['photo'][2]; ?>" height="<?php echo (int) $s['photo'][3]; ?>" loading="lazy" decoding="async">
        </figure>
        <div class="ab-mentor-body">
          <p class="ab-kicker"><?php echo esc_html( $s['kicker'] ); ?></p>
          <h3 class="t-h4b"><?php echo esc_html( $s['name'] ); ?></h3>
          <p class="ab-mentor-role"><?php echo esc_html( $s['full'] . ' — ' . $s['role'] ); ?></p>
          <ul class="ab-tags" aria-label="<?php echo esc_attr( 'Background' ); ?>">
            <?php foreach ( $s['chips'] as $ch ) : ?>
            <li class="ab-tag"><?php sraik_i( $ch[0], 12, 2 ); ?><?php echo esc_html( $ch[1] ); ?></li>
            <?php endforeach; ?>
          </ul>
          <div class="ab-bio">
            <?php foreach ( $s['bio'] as $para ) : ?>
            <p><?php echo esc_html( $para ); ?></p>
            <?php endforeach; ?>
          </div>
          <div class="ab-mentor-foot">
            <img class="ab-sign" src="<?php echo esc_url( $s['sign'][0] ); ?>" alt="<?php echo esc_attr( $s['sign'][1] ); ?>" width="<?php echo (int) $s['sign'][2]; ?>" height="<?php echo (int) $s['sign'][3]; ?>" loading="lazy" decoding="async">
            <?php echo sraik_socials(); // phpcs:ignore ?>
          </div>
        </div>
      </article>

      <div class="ab-team" data-appear style="--ad:.08s">
        <div class="ab-head">
          <span class="gloss ab-gloss" aria-hidden="true"><?php sraik_i( 'users', 16, 2 ); ?></span>
          <h3 class="ab-head-l"><?php echo esc_html( $s['team_l'] ); ?></h3>
          <span class="ab-rule" aria-hidden="true"></span>
        </div>
        <ul class="ab-team-grid">
          <?php foreach ( $s['team'] as $m ) : ?>
          <li class="ab-member"><span class="ab-member-n"><?php echo esc_html( $m[0] ); ?></span><span class="ab-member-r"><?php echo esc_html( $m[1] ); ?></span></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</section>
