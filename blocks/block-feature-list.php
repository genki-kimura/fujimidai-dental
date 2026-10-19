<?php
/**
 * Genesis Custom Blocks: block-feature-list(特徴リスト)
 *
 * フィールド
 *   - feature-list-text : Inner Blocks … 右の特徴テキスト(段落ブロックなど)
 *   ※ アイコンはフィールドではなく、テーマ内のロゴ画像(Logo02-solid.webp)を固定で表示
 */

// ---- 左のアイコン(テーマ内の画像を探す) -----------------------
// ★ Logo02-solid.webp を、下のどれかのフォルダに置いてください(上から順に探します)
$icon_file       = 'Logo02-solid.webp';
$icon_candidates = array( 'img/', 'assets/img/', 'images/', 'assets/images/' );
$icon_url        = '';

foreach ( $icon_candidates as $dir ) {
	if ( file_exists( get_theme_file_path( $dir . $icon_file ) ) ) {
		$icon_url = get_theme_file_uri( $dir . $icon_file );
		break;
	}
}

// 追加CSSクラス(ブロックの「高度な設定」で入れたもの)
$extra_class = block_value( 'className' );
$class       = 'feature-list' . ( $extra_class ? ' ' . esc_attr( $extra_class ) : '' );
?>
<div class="<?php echo $class; ?>">

	<?php if ( $icon_url ) : ?>
		<div class="feature-list-icon" aria-hidden="true">
			<span class="feature-list-icon-frame">
				<img class="feature-list-icon-img" src="<?php echo esc_url( $icon_url ); ?>" alt="" width="64" height="64" loading="lazy" decoding="async">
			</span>
		</div>
	<?php endif; ?>

	<div class="feature-list-text">
		<?php block_field( 'feature-list-text' ); // Inner Blocks ?>
	</div>

</div>
