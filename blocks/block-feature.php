<?php
/**
 * Genesis Custom Blocks: block-feature(特徴ブロック)
 *
 * フィールド
 *   - feature-tag   : 見出しタグ(Select。h2〜h5 / p など。値はタグ名そのまま)
 *   - feature-title : 見出し(Text。例:施術名の特徴)
 *   - feature-text  : 内容(Inner Blocks。中に「特徴リスト」ブロックを入れる)
 *
 * 出力イメージ
 *   [ロゴ + 「の」]
 *   施術名の特徴
 *   [ 特徴リスト ] [ 特徴リスト ] …
 */

// ---- 見出しタグ(許可するタグだけ。それ以外は h2) -------------
$allowed_tags = array( 'h2', 'h3', 'h4', 'h5', 'p', 'div' );
$title_tag    = block_value( 'feature-tag' );
if ( ! in_array( $title_tag, $allowed_tags, true ) ) {
	$title_tag = 'h2';
}

$title = block_value( 'feature-title' );

// ---- ロゴ(テーマ内の画像を探す) --------------------------------
// ★ Logo.webp を、下のどれかのフォルダに置いてください(上から順に探します)
$logo_file       = 'Logo.webp';
$logo_candidates = array( 'img/', 'assets/img/', 'images/', 'assets/images/' );
$logo_url        = '';

foreach ( $logo_candidates as $dir ) {
	if ( file_exists( get_theme_file_path( $dir . $logo_file ) ) ) {
		$logo_url = get_theme_file_uri( $dir . $logo_file );
		break;
	}
}

// 追加CSSクラス(ブロックの「高度な設定」で入れたもの)
$extra_class = block_value( 'className' );
$class       = 'feature' . ( $extra_class ? ' ' . esc_attr( $extra_class ) : '' );
?>
<section class="<?php echo $class; ?>">

	<?php if ( $logo_url ) : ?>
		<div class="feature-logo">
			<img class="feature-logo-img" src="<?php echo esc_url( $logo_url ); ?>" alt="富士見台さくら歯科" width="426" height="101" loading="lazy" decoding="async">
			<span class="feature-logo-no" aria-hidden="true">の</span>
		</div>
	<?php endif; ?>

	<?php if ( $title ) : ?>
		<<?php echo $title_tag; ?> class="feature-title"><?php echo esc_html( $title ); ?></<?php echo $title_tag; ?>>
	<?php endif; ?>

	<div class="feature-text">
		<?php block_field( 'feature-text' ); // Inner Blocks(特徴リストを並べる) ?>
	</div>

</section>
