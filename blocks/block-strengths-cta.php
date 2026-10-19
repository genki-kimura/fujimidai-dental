<?php
/**
 * Genesis Custom Blocks: block-strengths-cta(強みCTA)
 *
 * ■ 作成済みのフィールド
 *   - strengths-cta-tag         : 見出しタグ(Select。h2〜h5 / p / div)
 *   - strengths-cta-title       : 見出し(Text。例:施術名がはいります。)
 *   - strengths-cta-img         : 画像(Image。未設定ならグレーの四角)
 *   - strengths-cta-attention   : 注意(Text。例:※ こちらに注意書きが…)
 *   - strengths-cta-text        : 内容(Inner Blocks。段落ブロックなど)
 *   - WEB-reservation-btn       : ボタン1(URL)  Web予約
 *   - whitening-reservation-btn : ボタン2(URL)  ホワイトニング予約
 *   - telephone-number-btn      : ボタン3(URL)  電話(例:tel:0358489373)
 *
 * ■ キャッチコピーとポイント3つは、フィールドではなくこのファイル内に直接書いています
 *   (文言を変えるときは、下の $catch / $points を編集)
 */

// ---- 画像ファイルをテーマ内から探す --------------------------------
// ★ Logo.webp / Logo02-solid.webp を、下のどれかのフォルダに置いてください(上から順に探します)
$strengths_cta_find = function ( $file ) {
	foreach ( array( 'img/', 'assets/img/', 'images/', 'assets/images/' ) as $dir ) {
		if ( file_exists( get_theme_file_path( $dir . $file ) ) ) {
			return get_theme_file_uri( $dir . $file );
		}
	}
	return '';
};

$logo_url = $strengths_cta_find( 'Logo.webp' );        // 上の「ロゴ + の」
$icon_url = $strengths_cta_find( 'Logo02-solid.webp' ); // ポイントの丸いアイコン

// ---- 見出し ------------------------------------------------------------
$allowed_tags = array( 'h2', 'h3', 'h4', 'h5', 'p', 'div' );
$title_tag    = block_value( 'strengths-cta-tag' );
if ( ! in_array( $title_tag, $allowed_tags, true ) ) {
	$title_tag = 'h2';
}
$title     = block_value( 'strengths-cta-title' );
$attention = block_value( 'strengths-cta-attention' );

// ---- 画像(未設定なら空 → グレーの四角) --------------------------------
$img_id   = block_value( 'strengths-cta-img' );
$img_html = $img_id
	? wp_get_attachment_image( $img_id, 'large', false, array( 'class' => 'strengths-cta-photo-img', 'loading' => 'lazy', 'decoding' => 'async' ) )
	: '';

// ---- キャッチコピー・ポイント(固定の文言。ここを編集) --------------------
$catch = 'キャッチコピー';

// ポイント3つ(\n で2行に改行)
$points = array(
	"富士見台駅\n徒歩3分・土曜も診療",
	"認定専門医による\nインプラント治療",
	"予防から審美・\n訪問診療まで対応",
);

// ---- ボタン ----------------------------------------------------------------
$url_web   = block_value( 'WEB-reservation-btn' );
$url_white = block_value( 'whitening-reservation-btn' );
$url_tel   = block_value( 'telephone-number-btn' );
if ( ! $url_tel ) {
	$url_tel = 'tel:0358489373';
}

// 追加CSSクラス(ブロックの「高度な設定」で入れたもの)
$extra_class = block_value( 'className' );
$class       = 'strengths-cta' . ( $extra_class ? ' ' . esc_attr( $extra_class ) : '' );
?>
<section class="<?php echo $class; ?>">

	<?php if ( $logo_url ) : ?>
		<div class="strengths-cta-logo">
			<img class="strengths-cta-logo-img" src="<?php echo esc_url( $logo_url ); ?>" alt="富士見台さくら歯科" width="426" height="101" loading="lazy" decoding="async">
			<span class="strengths-cta-logo-no" aria-hidden="true">の</span>
		</div>
	<?php endif; ?>

	<?php if ( $title ) : ?>
		<<?php echo $title_tag; ?> class="strengths-cta-title"><?php echo esc_html( $title ); ?></<?php echo $title_tag; ?>>
	<?php endif; ?>

	<div class="strengths-cta-main">

		<?php // 左:画像(未設定ならグレーの四角) ?>
		<div class="strengths-cta-photo<?php echo $img_html ? '' : ' is-empty'; ?>">
			<?php echo $img_html; ?>
		</div>

		<?php // 右:キャッチ → ポイント → 注意 → 区切り線 → 内容 ?>
		<div class="strengths-cta-info">

			<div class="strengths-cta-catch"><?php echo esc_html( $catch ); ?></div>

			<ul class="strengths-cta-points">
				<?php foreach ( $points as $point ) : ?>
					<li class="strengths-cta-point">
						<?php if ( $icon_url ) : ?>
							<span class="strengths-cta-point-icon" aria-hidden="true">
								<span class="strengths-cta-point-icon-frame">
									<img class="strengths-cta-point-icon-img" src="<?php echo esc_url( $icon_url ); ?>" alt="" width="64" height="64" loading="lazy" decoding="async">
								</span>
							</span>
						<?php endif; ?>
						<span class="strengths-cta-point-label"><?php echo nl2br( esc_html( $point ) ); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>

			<?php if ( $attention ) : ?>
				<p class="strengths-cta-attention"><?php echo esc_html( $attention ); ?></p>
			<?php endif; ?>

			<div class="strengths-cta-text">
				<?php block_field( 'strengths-cta-text' ); // Inner Blocks ?>
			</div>

		</div>
	</div>

	<?php // ボタン3つ(見た目は _block.scss の「CTAボタン」をそのまま使う) ?>
	<div class="strengths-cta-buttons wp-block-buttons">
		<?php if ( $url_web ) : ?>
			<div class="wp-block-button WEB-reservation-btn">
				<a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $url_web ); ?>">Web予約はこちらから</a>
			</div>
		<?php endif; ?>

		<?php if ( $url_white ) : ?>
			<div class="wp-block-button whitening-reservation-btn">
				<a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $url_white ); ?>">ホワイトニング予約</a>
			</div>
		<?php endif; ?>

		<div class="wp-block-button telephone-number-btn">
			<a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $url_tel ); ?>">03-5848-9373</a>
		</div>
	</div>

</section>
