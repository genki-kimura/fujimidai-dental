<?php
// 見出しタグ(許可リスト以外は p にフォールバック)
$tag = block_value('point-content-title-tag');
$allowed_tags = array('h2', 'h3', 'h4', 'h5', 'h6', 'p');
if (! in_array($tag, $allowed_tags, true)) {
    $tag = 'p';
}

$title  = block_value('point-content-title');
$letter = block_value('point-content-letter');
$number = block_value('point-content-number');
$img_id = block_value('point-content-img');

// 画像:設定されていて、実際に取得できたときだけ表示
$img_html = '';
if ($img_id) {
    $img_html = wp_get_attachment_image(
        $img_id,
        'large',
        false,
        array(
            'class'   => 'point-content-img1',
            'alt'     => $title,
            'loading' => 'lazy',
        )
    );
}
$has_img = $img_html !== '';
?>
<div class="point-content<?php echo $has_img ? ' point-content--has-img' : ''; ?>">

    <div class="point-content-body">
        <div class="point-content-head">
            <?php if ($letter || $number) : ?>
                <div class="point-content-step">
                    <span class="point-content-step-letter"><?php echo esc_html($letter); ?></span>
                    <span class="point-content-step-number"><?php echo esc_html($number); ?></span>
                </div>
            <?php endif; ?>

            <<?php echo $tag; ?> class="point-content-title"><?php echo esc_html($title); ?></<?php echo $tag; ?>>
        </div>

        <div class="point-content-text">
            <?php echo wpautop(wp_kses_post(block_value('point-content-text'))); ?>
        </div>
    </div>

    <?php if ($has_img) : ?>
        <div class="point-content-img">
            <?php echo $img_html; ?>
        </div>
    <?php endif; ?>

</div>
