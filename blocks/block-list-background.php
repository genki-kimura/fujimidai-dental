<?php
// 見出しタグ(許可リスト以外は p にフォールバック)
$tag = block_value('list-background-title-tag');
$allowed_tags = array('h2', 'h3', 'h4', 'h5', 'h6', 'p');
if (! in_array($tag, $allowed_tags, true)) {
    $tag = 'p';
}

// 切り替え(white = 白地+枠線 / purple = 紫〜ピンクのグラデ背景)。未選択時は white
$variant = block_value('list-background-change') === 'purple' ? 'purple' : 'white';

$title = block_value('list-background-title');
?>
<div class="list-background list-background--<?php echo esc_attr($variant); ?>">

    <?php if ($title) : ?>
        <div class="list-background-head">
            <<?php echo $tag; ?> class="list-background-title"><?php echo esc_html($title); ?></<?php echo $tag; ?>>
        </div>
    <?php endif; ?>

    <div class="list-background-text">
        <?php echo wp_kses_post(block_value('list-background-text')); ?>
    </div>

</div>
