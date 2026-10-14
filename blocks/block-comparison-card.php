<?php
/**
 * Genesis Custom Blocks テンプレート:比較カードブロック
 * 配置先: wp-content/themes/fujimidai-dental/blocks/block-comparison-card.php
 *
 * 値の取得には Genesis Custom Blocks の関数 block_value() / block_field() を使う
 * (このプラグインは $attributes を渡さない)
 *
 * 現在のフィールド
 *   comparison-card-img        画像(添付ファイルID)
 *   comparison-card-title      見出し   例)ジルコニアインレー
 *   comparison-card-fee        料金     例)◯◯,◯◯◯円〜 / 保険適用
 *   comparison-card-guarantee  料金の補足(料金ボックスの右側の文字。入力した文字がそのまま出る)
 *   comparison-card-text       概要(Inner Blocks)
 *   comparison-card-change     切り替え(Select)デザインを切り替える
 *                              ジルコニアインレー / 保険のクリーニング / オフィスホワイトニング
 *
 * 料金ボックスの右側の文字(guarantee に入力した文字が、どのデザインでもそのまま出る。空なら非表示)
 *   ジルコニアインレー     例)税込／保証 ◯年
 *   保険のクリーニング     例)所要時間 約◯分／通院目安 ◯ヶ月ごと
 *   オフィスホワイトニング 例)税込／1回あたり・所要時間 約◯分
 *
 * あとから追加できるフィールド(任意。追加しなければデザインごとの既定値で表示)
 *   comparison-card-badge        ピルの文字(Text)
 *   comparison-card-en           英字の小見出し(Text)
 *   comparison-card-star-1 〜 -4 星の数 0〜5(Number)  評価の左から1〜4番目
 *   comparison-card-recommend / -merit / -demerit
 *                                箇条書き(Textarea・1行1項目)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ---------- 値の取得(Genesis Custom Blocks) ----------
/**
 * フィールド値を取得。未設定・空なら $default を返す
 * (フィールド名のハイフンは内部でアンダースコアになるので両方試す)
 */
$cc_get = static function ( $name, $default = '' ) {
	if ( ! function_exists( 'block_value' ) ) {
		return $default;
	}
	foreach ( array( $name, str_replace( '-', '_', $name ) ) as $key ) {
		$value = block_value( $key );
		if ( null !== $value && '' !== $value && false !== $value ) {
			return $value;
		}
	}
	return $default;
};

// 概要(Inner Blocks)の HTML
$content = '';
if ( function_exists( 'block_field' ) ) {
	$content = (string) block_field( 'comparison-card-text', false );
}

/**
 * 星(0〜5)
 */
$cc_stars = static function ( $count ) {
	$count = max( 0, min( 5, (int) $count ) );
	$html  = '<span class="comparison-card-stars" role="img" aria-label="5段階中' . $count . '">';
	for ( $i = 1; $i <= 5; $i++ ) {
		$html .= '<span class="comparison-card-star' . ( $i <= $count ? ' is-on' : '' ) . '" aria-hidden="true">★</span>';
	}
	return $html . '</span>';
};

/**
 * 改行区切りテキスト → 配列
 */
$cc_lines = static function ( $value, $default ) {
	if ( is_array( $value ) ) {
		$lines = $value;
	} elseif ( is_string( $value ) && '' !== trim( $value ) ) {
		$lines = preg_split( '/\r\n|\r|\n/', $value );
	} else {
		return $default;
	}
	$lines = array_filter( array_map( 'trim', $lines ), 'strlen' );
	return $lines ? array_values( $lines ) : $default;
};

// ---------- デザインの切り替え ----------
// 「切り替え」(Select)の値 → zirconia / cleaning / whitening
$change = $cc_get( 'comparison-card-change', '' );
$change = is_scalar( $change ) ? (string) $change : '';

if ( false !== strpos( $change, 'クリーニング' ) || 'cleaning' === $change ) {
	$design = 'cleaning';
} elseif ( false !== strpos( $change, 'ホワイトニング' ) || 'whitening' === $change ) {
	$design = 'whitening';
} else {
	$design = 'zirconia'; // 未選択・その他は従来のデザイン
}

/**
 * デザインごとの既定値
 *   badge      ピルの文字
 *   en         英字の小見出し(空なら非表示)
 *   ratings    評価4項目 [項目名, 補足(空なら非表示), 星の既定値]
 *   recommend / merit / demerit  箇条書きの既定値
 */
$cc_presets = array(
	'zirconia' => array(
		'badge'     => '自費詰め物',
		'en'        => 'ZIRCONIA',
		'ratings'   => array(
			array( '強度',   '丈夫さ',             5 ),
			array( '耐久性', 'どれだけ長持ちするか', 5 ),
			array( '美しさ', '見た目の仕上がり',     4 ),
			array( '安全性', '生体適合性',           5 ),
		),
		'recommend' => array( '丈夫な白い詰め物を希望する方', '噛む力が強い方', '歯ぎしり・食いしばりがある方' ),
		'merit'     => array( '割れにくく丈夫', '金属アレルギーの心配がない', '汚れが付きにくい' ),
		'demerit'   => array( '費用が高めになりやすい', '硬さにより噛み合う歯がすり減ることがある' ),
	),
	'cleaning' => array(
		'badge'     => 'クリーニング',
		'en'        => '',
		'ratings'   => array(
			array( '歯石除去',     '', 4 ),
			array( '着色除去',     '', 2 ),
			array( 'つるつる感',   '', 2 ),
			array( '所要時間の短さ', '', 4 ),
		),
		'recommend' => array( '歯石が気になる方', '歯ぐきから出血がある方', '定期検診を受けたい方' ),
		'merit'     => array( '保険適用で受けられる', '歯周病の予防・治療につながる' ),
		'demerit'   => array( '着色除去は範囲が限られる', '回数を分けて行うことがある' ),
	),
	'whitening' => array(
		'badge'     => 'オススメ！',
		'en'        => 'OFFICE WHITENING',
		'ratings'   => array(
			array( '白さ',   '', 3 ),
			array( '即効性', '', 5 ),
			array( '持続性', '', 2 ),
			array( '手軽さ', '', 4 ),
		),
		'recommend' => array( '結婚式など、近い予定に向けて白くしたい方', '自宅でのケアが難しい方' ),
		'merit'     => array( '短期間で効果を実感しやすい', '歯科医院で管理しながら行える' ),
		'demerit'   => array( '白さの後戻りが比較的早い', '知覚過敏が出ることがある' ),
	),
);
$preset = $cc_presets[ $design ];

// ---------- 値の取得 ----------
$title     = $cc_get( 'comparison-card-title' );
$fee       = $cc_get( 'comparison-card-fee' );
$guarantee = $cc_get( 'comparison-card-guarantee' );
$guarantee = is_scalar( $guarantee ) ? trim( (string) $guarantee ) : '';
$badge     = $cc_get( 'comparison-card-badge', $preset['badge'] );
$en        = $cc_get( 'comparison-card-en', $preset['en'] );

// 料金ボックス右側の文字(入力した文字そのまま)
$fee_note = $guarantee;

// 画像(配列 / JSON文字列 のどちらでも対応)
$img = $cc_get( 'comparison-card-img', array() );
if ( is_numeric( $img ) ) {
	$img = array( 'id' => (int) $img );
} elseif ( is_string( $img ) ) {
	$decoded = json_decode( $img, true );
	$img     = is_array( $decoded ) ? $decoded : array( 'url' => $img );
}
$img_id  = ! empty( $img['id'] ) ? (int) $img['id'] : 0;
$img_url = ! empty( $img['url'] ) ? $img['url'] : '';
$img_alt = ! empty( $img['alt'] ) ? $img['alt'] : ( $img_id ? get_post_meta( $img_id, '_wp_attachment_image_alt', true ) : '' );
if ( '' === $img_alt ) {
	$img_alt = $title;
}
$has_img = ( $img_id || $img_url );

// 評価(4項目)。星の数は comparison-card-star-1〜4 で上書きできる
$ratings = array();
foreach ( $preset['ratings'] as $i => $rating ) {
	$ratings[] = array(
		$rating[0],
		$rating[1],
		$cc_get( 'comparison-card-star-' . ( $i + 1 ), $rating[2] ),
	);
}

// 3つの箇条書き
$lists = array(
	array(
		'class' => 'recommend',
		'title' => 'こんな方におすすめ',
		'items' => $cc_lines( $cc_get( 'comparison-card-recommend' ), $preset['recommend'] ),
	),
	array(
		'class' => 'merit',
		'title' => 'メリット',
		'items' => $cc_lines( $cc_get( 'comparison-card-merit' ), $preset['merit'] ),
	),
	array(
		'class' => 'demerit',
		'title' => 'デメリット',
		'items' => $cc_lines( $cc_get( 'comparison-card-demerit' ), $preset['demerit'] ),
	),
);
?>
<div class="comparison-card comparison-card--<?php echo esc_attr( $design ); ?><?php echo $has_img ? '' : ' comparison-card--no-img'; ?>">

	<?php /* ===== 上段:画像 + 基本情報 ===== */ ?>
	<div class="comparison-card-top">

		<?php if ( $has_img ) : ?>
			<div class="comparison-card-image">
				<?php
				if ( $img_id ) {
					echo wp_get_attachment_image( $img_id, 'large', false, array( 'alt' => $img_alt, 'loading' => 'lazy' ) );
				} else {
					echo '<img src="' . esc_url( $img_url ) . '" alt="' . esc_attr( $img_alt ) . '" loading="lazy">';
				}
				?>
			</div>
		<?php endif; ?>

		<div class="comparison-card-info">

			<?php if ( $badge ) : ?>
				<span class="comparison-card-badge"><?php echo esc_html( $badge ); ?></span>
			<?php endif; ?>

			<div class="comparison-card-heading">
				<span class="comparison-card-number" aria-hidden="true"></span>
				<div class="comparison-card-title"><?php echo esc_html( $title ); ?></div>
			</div>

			<?php if ( $en ) : ?>
				<div class="comparison-card-en"><?php echo esc_html( $en ); ?></div>
			<?php endif; ?>

			<dl class="comparison-card-fee">
				<dt class="comparison-card-fee-label">料金</dt>
				<dd class="comparison-card-fee-price"><?php echo esc_html( $fee ); ?></dd>
				<?php if ( '' !== $fee_note ) : ?>
					<dd class="comparison-card-fee-note"><?php echo esc_html( $fee_note ); ?></dd>
				<?php endif; ?>
			</dl>

		</div>
	</div>

	<?php /* ===== 評価(星) ===== */ ?>
	<ul class="comparison-card-ratings">
		<?php foreach ( $ratings as $rating ) : ?>
			<li class="comparison-card-rating">
				<span class="comparison-card-rating-name"><?php echo esc_html( $rating[0] ); ?></span>
				<?php if ( '' !== $rating[1] ) : ?>
					<span class="comparison-card-rating-sub">(<?php echo esc_html( $rating[1] ); ?>)</span>
				<?php endif; ?>
				<?php echo $cc_stars( $rating[2] ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			</li>
		<?php endforeach; ?>
	</ul>

	<?php /* ===== 概要(Inner Blocks) ===== */ ?>
	<div class="comparison-card-summary">
		<div class="comparison-card-summary-title">概要</div>
		<div class="comparison-card-text">
			<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput ?>
		</div>
	</div>

	<?php /* ===== おすすめ / メリット / デメリット ===== */ ?>
	<div class="comparison-card-lists">
		<?php foreach ( $lists as $list ) : ?>
			<div class="comparison-card-list comparison-card-list--<?php echo esc_attr( $list['class'] ); ?>">
				<div class="comparison-card-list-title"><?php echo esc_html( $list['title'] ); ?></div>
				<ul>
					<?php foreach ( $list['items'] as $item ) : ?>
						<li><?php echo esc_html( $item ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endforeach; ?>
	</div>

</div>
