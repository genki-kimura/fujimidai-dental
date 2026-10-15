<?php
    get_header();
?>
    <?php if ( get_post_type() === 'news' ) : ?>
        <?php get_template_part('single/news'); ?>
    <?php else : ?>
        <?php get_template_part('single/post'); ?>
    <?php endif; ?>
<?php get_footer(); ?>
