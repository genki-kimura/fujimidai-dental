<?php
/**
 * ブロック: あわせて読みたい(関連記事)
 * Genesis Custom Blocks: block-related-articles
 *
 * フィールド
 *   related-articles-tag         見出しタグ(select)→ 左上の紫タブに使う
 *   related-articles-title       見出し(紫タブの文字。空のときは「あわせて読みたい」を表示)
 *   related-articles-img         画像(未設定なら画像エリアごと非表示)
 *   related-articles-page-title  タイトル(カード内の明朝の文字)
 *                                ※ 管理画面の「タイトル」の slug が見出しと重複しているので、
 *                                  related-articles-page-title に変更してください
 *   related-articles-text        内容(Inner Blocks)
 */

$tag        = block_value( 'related-articles-tag' );
$label      = block_value( 'related-articles-title' );
$img_id     = block_value( 'related-articles-img' );
$page_title = block_value( 'related-articles-page-title' );

// 見出しが空のときも、タブには「あわせて読みたい」を出す
$label = $label ? $label : 'あわせて読みたい';

// 見出しタグは許可したものだけ(それ以外は p)
$allowed_tags = array( 'h2', 'h3', 'h4', 'h5', 'p', 'div' );
$tag          = in_array( $tag, $allowed_tags, true ) ? $tag : 'p';

// 画像は設定されているときだけ出力
$img_html = $img_id
	? wp_get_attachment_image(
		$img_id,
		'medium_large',
		false,
		array(
			'class'   => 'related-articles-photo-img',
			'loading' => 'lazy',
		)
	)
	: '';

$section_class = 'related-articles' . ( $label ? ' has-label' : '' );
$box_class     = 'related-articles-box' . ( $img_html ? '' : ' is-no-photo' );
?>
<section class="<?php echo esc_attr( $section_class ); ?>">

	<?php if ( $label ) : ?>
		<<?php echo esc_attr( $tag ); ?> class="related-articles-label"><?php echo esc_html( $label ); ?></<?php echo esc_attr( $tag ); ?>>
	<?php endif; ?>

	<div class="<?php echo esc_attr( $box_class ); ?>">

		<?php if ( $img_html ) : ?>
			<div class="related-articles-photo">
				<?php echo $img_html; // phpcs:ignore WordPress.Security.EscapeOutput ?>
			</div>
		<?php endif; ?>

		<div class="related-articles-body">
			<?php if ( $page_title ) : ?>
				<p class="related-articles-title"><?php echo esc_html( $page_title ); ?></p>
			<?php endif; ?>

			<div class="related-articles-text">
				<?php block_field( 'related-articles-text' ); ?>
			</div>
		</div>

	</div>

</section>
