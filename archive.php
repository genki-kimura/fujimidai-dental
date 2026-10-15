<?php
    get_header();

    // お知らせ(CPT: news)の一覧か?
    //   get_query_var('post_type') はカテゴリー別一覧では空になるため、
    //   投稿タイプのアーカイブ + newsに紐づくタクソノミーのアーカイブ の両方で判定する
    $news_taxonomies = get_object_taxonomies( 'news' );
    $is_news = is_post_type_archive( 'news' )
        || ( ! empty( $news_taxonomies ) && is_tax( $news_taxonomies ) );
?>
    <?php if ( $is_news ) : ?>
        <?php get_template_part('archive/news'); ?>
    <?php else : ?>
        <?php get_template_part('archive/post'); ?>
    <?php endif; ?>
<?php get_footer(); ?>
