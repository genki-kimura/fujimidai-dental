<?php
    get_header();

    $this_slug = get_post_field( 'post_name', get_the_ID() );

    global $post;
    $slug = $post->post_name;
    $parent_id = $post->post_parent; 
?>
    <?php
        if($parent_id) {
            $parent_slug = get_post($parent_id)->post_name;
            if($parent_slug == 'service') {
                get_template_part('page/service/'.$slug);
            } else {
                get_template_part('page/'.$slug);
            }
        } else {
            get_template_part('page/'.$slug);
        }
    ?>
<?php get_footer(); ?>