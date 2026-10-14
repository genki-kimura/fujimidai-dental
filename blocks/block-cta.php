<?php
/**
 * Block Template: CTA(お問い合わせ誘導ブロック)
 *
 * 置き場所: wp-content/themes/fujimidai-dental/blocks/block-cta.php
 *
 * フィールド(スラッグ)
 *   cta-lead-text                : リードテキスト(テキスト)
 *   cta-title                    : 見出し(テキスト)
 *   cta-text                     : 内容(リッチテキスト)
 *   WEB-reservation-btn          : ボタン1 = Web予約のURL
 *   whitening-reservation-btn    : ボタン2 = ホワイトニング予約のURL
 *   telephone-number-btn         : ボタン3 = 電話のURL(例: tel:0358489373)
 *
 * ボタンの見た目は _block.scss の「CTAボタン」セクション(.WEB-reservation-btn など)を再利用。
 * ボタンの文言・補足文・受付時間は SCSS(::before)側で出しているので、ここでは URL だけ受け取る。
 */

// 値の取得
$cta_lead  = block_value( 'cta-lead-text' );
$cta_title = block_value( 'cta-title' );
$cta_text  = block_value( 'cta-text' );

$cta_web   = block_value( 'WEB-reservation-btn' );
$cta_white = block_value( 'whitening-reservation-btn' );
$cta_tel   = block_value( 'telephone-number-btn' );

// 電話は URL 未入力でも押せるようにフォールバック(番号を変えるときはここも)
if ( empty( $cta_tel ) ) {
	$cta_tel = 'tel:0358489373';
}

// エディタの「追加CSSクラス」を引き継ぐ
$cta_class = 'cta-box';
if ( ! empty( $attributes['className'] ) ) {
	$cta_class .= ' ' . $attributes['className'];
}
?>
<section class="<?php echo esc_attr( $cta_class ); ?>">

	<?php if ( $cta_lead ) : ?>
		<p class="cta-box-lead"><?php echo esc_html( $cta_lead ); ?></p>
	<?php endif; ?>

	<?php if ( $cta_title ) : ?>
		<div class="cta-box-title"><?php echo esc_html( $cta_title ); ?></div>
	<?php endif; ?>

	<?php if ( $cta_text ) : ?>
		<div class="cta-box-text"><?php echo wp_kses_post( $cta_text ); ?></div>
	<?php endif; ?>

	<?php if ( $cta_web || $cta_white || $cta_tel ) : ?>
		<div class="wp-block-buttons cta-box-buttons">

			<?php if ( $cta_web ) : ?>
				<div class="wp-block-button WEB-reservation-btn">
					<a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $cta_web ); ?>">WEB予約はこちらから</a>
				</div>
			<?php endif; ?>

			<?php if ( $cta_white ) : ?>
				<div class="wp-block-button whitening-reservation-btn">
					<a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $cta_white ); ?>">ホワイトニング予約</a>
				</div>
			<?php endif; ?>

			<?php if ( $cta_tel ) : ?>
				<div class="wp-block-button telephone-number-btn">
					<a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $cta_tel ); ?>">03-5848-9373</a>
				</div>
			<?php endif; ?>

		</div>
	<?php endif; ?>

</section>
