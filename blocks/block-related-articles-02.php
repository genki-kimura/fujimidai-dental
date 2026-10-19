<?php
/**
 * ブロック: 関連記事の紹介(カード全体がリンク)
 * Genesis Custom Blocks: block-related-articles-02
 *
 * フィールド
 *   related-articles-02-img    画像(未設定なら、グレーの背景を表示)
 *   related-articles-02-tag    見出しタグ(select)
 *   related-articles-02-title  見出し(カードの文章)
 *   related-articles-02-btn    ボタン(URL)→ カードのどこを押しても、このURLへ移動
 *
 * ※ URL が空のときは、リンクなしのカードとして表示します。
 * ※ 見出しが空のときは、見出しを表示しません。
 */

// ---- 値の取り出し ------------------------------------------------------------------
//   次の順に探す。
//   ① block_value()
//   ② プラグインが今まさに描画に使っている値(編集画面のプレビューでも「入力した最新の値」が取れる)
//   ③ 投稿に保存されているブロックのデータ(公開側の表示のときだけ)
//   ②③は、保存名と slug で大文字小文字・ハイフン・アンダーバーが違っても同じ項目として扱う
//   (例: related-articles-02-title / related_articles_02_title / relatedArticles02Title)

if ( ! function_exists( 'fujimidai_ra02_collect_attrs' ) ) {
	// 投稿本文の中から、このブロックの保存データを出てくる順に集める
	function fujimidai_ra02_collect_attrs( $blocks, &$found ) {
		foreach ( $blocks as $b ) {
			if ( ! empty( $b['blockName'] ) && false !== strpos( $b['blockName'], 'related-articles-02' ) ) {
				$found[] = is_array( $b['attrs'] ) ? $b['attrs'] : array();
			}
			if ( ! empty( $b['innerBlocks'] ) ) {
				fujimidai_ra02_collect_attrs( $b['innerBlocks'], $found );
			}
		}
	}

	// 名前の表記ゆれをなくす(英数字だけにして小文字にする)
	function fujimidai_ra02_normalize( $name ) {
		return preg_replace( '/[^a-z0-9]/', '', strtolower( (string) $name ) );
	}

	function fujimidai_ra02_filled( $value ) {
		return null !== $value && '' !== $value && false !== $value;
	}

	// 配列から slug に対応する値を探す(なければ null)。表記が完全に一致するものを優先する
	function fujimidai_ra02_pick( $slug, $source ) {
		if ( ! is_array( $source ) ) {
			return null;
		}
		$variants = array(
			$slug,
			str_replace( '-', '_', $slug ),
			lcfirst( str_replace( ' ', '', ucwords( str_replace( '-', ' ', $slug ) ) ) ),
		);
		foreach ( $variants as $v ) {
			if ( isset( $source[ $v ] ) && fujimidai_ra02_filled( $source[ $v ] ) ) {
				return $source[ $v ];
			}
		}
		$want = fujimidai_ra02_normalize( $slug );
		foreach ( $source as $key => $value ) {
			if ( fujimidai_ra02_normalize( $key ) === $want && fujimidai_ra02_filled( $value ) ) {
				return $value;
			}
		}
		return null;
	}
}

// ② プラグインが描画に使っている値
$live_attrs = null;
foreach ( array( 'genesis_custom_blocks', 'block_lab' ) as $plugin_fn ) {
	if ( function_exists( $plugin_fn ) ) {
		$plugin_obj = call_user_func( $plugin_fn );
		if ( is_object( $plugin_obj ) && isset( $plugin_obj->loader ) && is_object( $plugin_obj->loader ) && method_exists( $plugin_obj->loader, 'get_data' ) ) {
			$data = $plugin_obj->loader->get_data( 'attributes' );
			if ( is_array( $data ) ) {
				$live_attrs = $data;
				break;
			}
		}
	}
}

// ③ 投稿に保存されている値(編集画面のプレビューでは使わない:古い値になるため)
$is_editor_request = ( defined( 'REST_REQUEST' ) && REST_REQUEST ) || is_admin();
$saved_attrs       = null;
if ( ! $is_editor_request ) {
	if ( ! isset( $GLOBALS['fujimidai_ra02_index'] ) ) {
		$GLOBALS['fujimidai_ra02_index'] = 0;
	}
	$ra02_index = $GLOBALS['fujimidai_ra02_index'];
	$post_obj   = get_post();
	if ( $post_obj && ! empty( $post_obj->post_content ) ) {
		$all_saved = array();
		fujimidai_ra02_collect_attrs( parse_blocks( $post_obj->post_content ), $all_saved );
		$saved_attrs = isset( $all_saved[ $ra02_index ] ) ? $all_saved[ $ra02_index ] : null;
	}
	++$GLOBALS['fujimidai_ra02_index'];
}

$fields = array();
foreach ( array( 'img', 'tag', 'title', 'btn' ) as $suffix ) {
	$slug  = 'related-articles-02-' . $suffix;
	$value = block_value( $slug );
	if ( ! fujimidai_ra02_filled( $value ) ) {
		$value = fujimidai_ra02_pick( $slug, $live_attrs );
	}
	if ( ! fujimidai_ra02_filled( $value ) ) {
		$value = fujimidai_ra02_pick( $slug, $saved_attrs );
	}
	$fields[ $suffix ] = $value;
}

$img_id  = $fields['img'];
$tag     = $fields['tag'];
$title   = is_string( $fields['title'] ) ? trim( $fields['title'] ) : '';
$btn_url = is_string( $fields['btn'] ) ? trim( $fields['btn'] ) : '';

// 見出しタグは許可したものだけ(それ以外は p)
$allowed_tags = array( 'h2', 'h3', 'h4', 'h5', 'p', 'div' );
$tag          = in_array( $tag, $allowed_tags, true ) ? $tag : 'p';

// 画像は設定されているときだけ出力(未設定のときは空。グレーの背景は CSS 側)
$img_html = $img_id
	? wp_get_attachment_image(
		(int) $img_id,
		'medium_large',
		false,
		array(
			'class'   => 'related-articles-02-img',
			'loading' => 'lazy',
		)
	)
	: '';

// URL があれば <a>、なければ <div>
$wrapper = $btn_url ? 'a' : 'div';
$attrs   = $btn_url ? ' href="' . esc_url( $btn_url ) . '"' : '';
?>
<<?php echo $wrapper; // phpcs:ignore WordPress.Security.EscapeOutput ?> class="related-articles-02"<?php echo $attrs; // phpcs:ignore WordPress.Security.EscapeOutput ?>>

	<?php // 画像エリアは常に出す(未設定のときは、CSS のグレーの背景だけが見える) ?>
	<div class="related-articles-02-thumb">
		<?php echo $img_html; // phpcs:ignore WordPress.Security.EscapeOutput ?>
	</div>

	<?php if ( '' !== $title ) : ?>
		<div class="related-articles-02-body">
			<<?php echo esc_attr( $tag ); ?> class="related-articles-02-title"><?php echo esc_html( $title ); ?></<?php echo esc_attr( $tag ); ?>>
		</div>
	<?php endif; ?>

	<?php
	// ▼▼ 確認用:ページのURLの最後に ?ra02_debug=1 を付けたときだけ、ログイン中のユーザーに表示 ▼▼
	if ( isset( $_GET['ra02_debug'] ) && current_user_can( 'edit_posts' ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		echo '<pre style="margin:0;padding:12px;font-size:12px;line-height:1.5;white-space:pre-wrap;background:#fff3cd;color:#000;">';
		echo esc_html( "[確認用]\n" );
		echo esc_html( 'block_value(title) = ' . var_export( block_value( 'related-articles-02-title' ), true ) . "\n" );
		echo esc_html( '描画に使われている値 = ' . ( null === $live_attrs ? '(取得できない)' : print_r( $live_attrs, true ) ) . "\n" );
		echo esc_html( '投稿に保存されている値 = ' . ( null === $saved_attrs ? '(使っていない/見つからない)' : print_r( $saved_attrs, true ) ) . "\n" );
		echo esc_html( '使った見出し = ' . var_export( $title, true ) );
		echo '</pre>';
	}
	// ▲▲ ここまで ▲▲
	?>

</<?php echo $wrapper; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
