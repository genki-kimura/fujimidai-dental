<?php
/**
 * Genesis Custom Blocks: 吹き出し(block-speech-bubble)
 *
 * フィールド
 *   speech-bubble-img      画像(丸く切り抜いて表示)
 *   speech-bubble-position 監修者肩書き
 *   speech-bubble-name     監修者名
 *   speech-bubble-text     内容(Inner Blocks)
 */

$img_id   = block_value( 'speech-bubble-img' );
$position = block_value( 'speech-bubble-position' );
$name     = block_value( 'speech-bubble-name' );
?>
<div class="speech-bubble">

	<div class="speech-bubble-person">
		<div class="speech-bubble-photo">
			<div class="speech-bubble-photo-frame">
				<?php
				// 画像が設定されているときだけ表示(未設定ならグレーの丸のまま)
				if ( $img_id ) {
					echo wp_get_attachment_image(
						$img_id,
						'medium',
						false,
						array(
							'class' => 'speech-bubble-photo-img',
							'alt'   => $name ? $name : '',
						)
					);
				}
				?>
			</div>
		</div>

		<?php if ( $position ) : ?>
			<div class="speech-bubble-position"><?php echo esc_html( $position ); ?></div>
		<?php endif; ?>

		<?php if ( $name ) : ?>
			<div class="speech-bubble-name"><?php echo esc_html( $name ); ?></div>
		<?php endif; ?>
	</div>

	<div class="speech-bubble-body">
		<div class="speech-bubble-text">
			<?php block_field( 'speech-bubble-text' ); ?>
		</div>
	</div>

</div>
