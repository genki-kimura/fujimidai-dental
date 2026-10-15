<?php
/**
 * ブロック：監修者トグル（slug: supervisor）
 *
 * フィールド
 *   supervisor-img      画像（丸く切り抜いて表示）
 *   supervisor-position 監修者肩書き
 *   supervisor-name     監修者名
 *   supervisor-text     内容（Inner Blocks／トグルを開くと表示）
 *
 * 開閉は script.js の「FAQブロックの開閉」と共通（.supervisor-box-q も対象）
 */

$supervisor_img      = block_value( 'supervisor-img' );      // 画像ID
$supervisor_position = block_value( 'supervisor-position' );
$supervisor_name     = block_value( 'supervisor-name' );
$supervisor_id       = wp_unique_id( 'supervisor-box-a-' );  // aria-controls 用（ページ内に複数あっても重ならない）
?>
<div class="supervisor-box">
  <button type="button" class="supervisor-box-q" aria-expanded="false" aria-controls="<?php echo esc_attr( $supervisor_id ); ?>">
    <span class="supervisor-box-photo">
      <?php
      // 画像未設定のときは、グレーの丸だけ表示
      if ( $supervisor_img ) {
        echo wp_get_attachment_image(
          $supervisor_img,
          'medium',
          false,
          array(
            'class'   => 'supervisor-box-photo-img',
            'loading' => 'lazy',
          )
        );
      }
      ?>
    </span>

    <span class="supervisor-box-info">
      <?php if ( $supervisor_position ) : ?>
        <span class="supervisor-box-position"><?php echo esc_html( $supervisor_position ); ?></span>
      <?php endif; ?>
      <?php if ( $supervisor_name ) : ?>
        <span class="supervisor-box-name"><?php echo esc_html( $supervisor_name ); ?></span>
      <?php endif; ?>
    </span>

    <span class="supervisor-box-icon" aria-hidden="true"></span>
  </button>

  <div class="supervisor-box-a" id="<?php echo esc_attr( $supervisor_id ); ?>">
    <div class="supervisor-box-a-inner">
      <div class="supervisor-box-a-body">
        <?php block_field( 'supervisor-text' ); ?>
      </div>
    </div>
  </div>
</div>
