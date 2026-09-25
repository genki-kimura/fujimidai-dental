<?php
    get_header();
    $post_type = get_query_var( 'post_type' );
?>
    <?php if($post_type == 'news'): ?>
        <?php get_template_part('single/news'); ?>
    <?php else: ?>
        <?php get_template_part('single/post'); ?>
    <?php endif; ?>
<?php get_footer(); ?>