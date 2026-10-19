<?php
/**
 * ブロック: プロフィール(執筆・監修者プロフィール)
 * Genesis Custom Blocks: block-profile
 *
 * フィールド
 *   profile-tag          見出しタグ(select: h2 / h3 / h4 / p など)
 *   profile-title        見出し
 *   profile-img          画像
 *   profile-dental-name  歯科名
 *   profile-position     監修者肩書き
 *   profile-name         監修者名
 *   profile-text         内容(Inner Blocks)
 *   profile-btn          ボタン(URL)
 */

$tag         = block_value( 'profile-tag' );
$title       = block_value( 'profile-title' );
$img_id      = block_value( 'profile-img' );
$dental_name = block_value( 'profile-dental-name' );
$position    = block_value( 'profile-position' );
$name        = block_value( 'profile-name' );
$btn_url     = block_value( 'profile-btn' );

// 見出しタグは許可したものだけ(それ以外は h2)
$allowed_tags = array( 'h2', 'h3', 'h4', 'h5', 'p', 'div' );
$tag          = in_array( $tag, $allowed_tags, true ) ? $tag : 'h2';
?>
<section class="profile-box">

	<?php if ( $title ) : ?>
		<<?php echo esc_attr( $tag ); ?> class="profile-box-title"><?php echo esc_html( $title ); ?></<?php echo esc_attr( $tag ); ?>>
	<?php endif; ?>

	<div class="profile-box-inner">

		<div class="profile-box-photo">
			<?php
			if ( $img_id ) {
				echo wp_get_attachment_image(
					$img_id,
					'large',
					false,
					array(
						'class'   => 'profile-box-photo-img',
						'loading' => 'lazy',
					)
				);
			}
			?>
		</div>

		<div class="profile-box-body">

			<?php if ( $dental_name ) : ?>
				<p class="profile-box-dental"><?php echo esc_html( $dental_name ); ?></p>
			<?php endif; ?>

			<?php if ( $position || $name ) : ?>
				<p class="profile-box-person">
					<?php if ( $position ) : ?>
						<span class="profile-box-position"><?php echo esc_html( $position ); ?></span>
					<?php endif; ?>
					<?php if ( $name ) : ?>
						<span class="profile-box-name"><?php echo esc_html( $name ); ?></span>
					<?php endif; ?>
				</p>
			<?php endif; ?>

			<div class="profile-box-text">
				<?php block_field( 'profile-text' ); ?>
			</div>

			<?php if ( $btn_url ) : ?>
				<a class="profile-box-btn" href="<?php echo esc_url( $btn_url ); ?>">
					<span class="profile-box-btn-icon" aria-hidden="true"></span>
					<span class="profile-box-btn-label">詳しくはこちら</span>
				</a>
			<?php endif; ?>

		</div>
	</div>

</section>
