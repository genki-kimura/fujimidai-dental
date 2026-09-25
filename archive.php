<?php
    get_header();
    $post_type = get_query_var( 'post_type' );
    $category = get_queried_object();
?>
    <?php if($post_type == 'news'): ?>
        <?php get_template_part('archive/news'); ?>
    <?php else: ?>
        <?php get_template_part('archive/post'); ?>
    <?php endif; ?>
<?php get_footer(); ?>