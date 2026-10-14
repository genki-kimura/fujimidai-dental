<?php
// 見出しタグ(許可リスト以外は p にフォールバック)
$tag = block_value('flow-title-tag');
$allowed_tags = array('h2', 'h3', 'h4', 'h5', 'h6', 'p');
if (! in_array($tag, $allowed_tags, true)) {
    $tag = 'p';
}

// 切り替え(left = 画像左 / right = 画像右)。未選択時は left
$direction = block_value('flow-change') === 'right' ? 'right' : 'left';

$title  = block_value('flow-title');
$letter = block_value('flow-letter');
$number = block_value('flow-number');
$img_id = block_value('flow-img');
?>
<div class="flow-box flow-box--<?php echo esc_attr($direction); ?>">
    <div class="flow-box-inner">

        <div class="flow-box-img">
            <?php
            if ($img_id) {
                echo wp_get_attachment_image(
                    $img_id,
                    'large',
                    false,
                    array(
                        'class'   => 'flow-box-img1',
                        'alt'     => $title,
                        'loading' => 'lazy',
                    )
                );
            }
            ?>
        </div>

        <div class="flow-box-body">
            <?php if ($letter || $number) : ?>
                <div class="flow-box-step">
                    <span class="flow-box-step-letter"><?php echo esc_html($letter); ?></span>
                    <span class="flow-box-step-number"><?php echo esc_html($number); ?></span>
                </div>
            <?php endif; ?>

            <<?php echo $tag; ?> class="flow-box-title"><?php echo esc_html($title); ?></<?php echo $tag; ?>>

            <div class="flow-box-text">
                <?php echo wpautop(wp_kses_post(block_value('flow-text'))); ?>
            </div>
        </div>

    </div>
</div>
