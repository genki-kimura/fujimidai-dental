<?php
    $column_id = get_the_ID();
    $column_title = get_the_title($column_id);
    $column_permalink = get_permalink($column_id);
    $column_content = get_the_content($column_id);
    $column_image = get_the_post_thumbnail_url($column_id, 'full'); // アイキャッチ画像のURLを取得
    $column_date_published = get_the_time('Y-m-d');
    $column_date_modified = get_post_time('Y-m-d');
    $template_directory_uri = esc_url(get_template_directory_uri());

    $json_ld = array(
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => $column_title,
        'image' => array(
            '@type' => 'ImageObject',
            'url' => $column_image,
            'height' => 675,
            'width' => 1200
        ),
        'description' => wp_strip_all_tags($column_content),
        'url' => $column_permalink,
        'datePublished' => $column_date_published,
        'dateModified' => $column_date_modified,
        'author' => array(
            '@type' => 'Person',
            'name' => '',
            'url' => ''
        ),
        'publisher' => array(
            '@type' => 'Organization',
            'name' => '',
            'logo' => array(
                '@type' => 'ImageObject',
                'url' => $template_directory_uri . '/img/favicon.png',
                'width' => 112,
                'height' => 112
            )
        )
    );

    // JSON-LDを出力
    echo '<script type="application/ld+json">' . wp_json_encode($json_ld) . '</script>';
?>