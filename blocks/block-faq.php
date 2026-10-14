<?php
/**
 * Genesis Custom Blocks テンプレート:FAQブロック(質問と回答 1組ぶん)
 * 配置先: wp-content/themes/fujimidai-dental/blocks/block-faq.php
 *
 * 見た目は front-page.php の <section class="FAQ"> と同じ(_block.scss の「FAQブロック」)
 * 開閉は script.js の「FAQブロックの開閉」で動く
 * ブロックを縦に並べると、質問が1つずつ並ぶ
 *
 * 値の取得には Genesis Custom Blocks の関数 block_value() / block_field() を使う
 * (このプラグインは $attributes を渡さない)
 *
 * 現在のフィールド
 *   faq-tag       見出しタグ(Select)       質問を囲むタグ。h2 / h3 / h4 / h5 / h6 など
 *                 ※ 選択肢は「h2」「h3」のようにタグ名で入れる(未選択・不明な値は h3)
 *   faq-question  質問(Text)               例)予約なしでも受診できますか?
 *   faq-answer    回答(Inner Blocks)       段落ごとに入力する
 *                 ※ Textarea でも動く(改行で段落が分かれる)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ---------- 値の取得(Genesis Custom Blocks) ----------
/**
 * テキスト系フィールドの値を取得(フィールド名のハイフンは内部でアンダースコアになるので両方試す)
 */
$faq_get = static function ( $name ) {
	if ( ! function_exists( 'block_value' ) ) {
		return '';
	}
	foreach ( array( $name, str_replace( '-', '_', $name ) ) as $key ) {
		$value = block_value( $key );
		if ( is_scalar( $value ) && '' !== trim( (string) $value ) ) {
			return trim( (string) $value );
		}
	}
	return '';
};

// 質問
$question = $faq_get( 'faq-question' );

// 見出しタグ(h1〜h6 / p / div のみ許可。未選択・不明な値は h3)
$tag = strtolower( $faq_get( 'faq-tag' ) );
if ( ! preg_match( '/^(h[1-6]|p|div)$/', $tag ) ) {
	$tag = 'h3';
}

// 回答(Inner Blocks の HTML)
$answer = '';
if ( function_exists( 'block_field' ) ) {
	$answer = (string) block_field( 'faq-answer', false );
}
// HTMLが入っていない(Textarea など)ときは、改行を段落に変える
if ( '' !== trim( $answer ) && false === strpos( $answer, '<' ) ) {
	$answer = wpautop( esc_html( $answer ) );
}

// ブロックごとに違うIDにする(質問と回答をつなぐため)
$faq_id   = function_exists( 'wp_unique_id' ) ? wp_unique_id( 'faq-box-' ) : uniqid( 'faq-box-' );
$faq_q_id = $faq_id . '-q';
$faq_a_id = $faq_id . '-a';
?>
<div class="faq-box">

	<?php /* ===== 質問(押すところ) ===== */ ?>
	<<?php echo esc_attr( $tag ); ?> class="faq-box-heading">
		<button type="button" class="faq-box-q" id="<?php echo esc_attr( $faq_q_id ); ?>" aria-expanded="false" aria-controls="<?php echo esc_attr( $faq_a_id ); ?>">
			<span class="faq-box-mark" aria-hidden="true">Q.</span>
			<span class="faq-box-q-text"><?php echo esc_html( $question ); ?></span>
			<span class="faq-box-icon" aria-hidden="true"></span>
		</button>
	</<?php echo esc_attr( $tag ); ?>>

	<?php /* ===== 回答(開閉する部分) ===== */ ?>
	<div class="faq-box-a" id="<?php echo esc_attr( $faq_a_id ); ?>" role="region" aria-labelledby="<?php echo esc_attr( $faq_q_id ); ?>">
		<div class="faq-box-a-inner">
			<div class="faq-box-a-body">
				<span class="faq-box-mark faq-box-mark--a" aria-hidden="true">A.</span>
				<div class="faq-box-a-text">
					<?php echo $answer; // phpcs:ignore WordPress.Security.EscapeOutput ?>
				</div>
			</div>
		</div>
	</div>

</div>
