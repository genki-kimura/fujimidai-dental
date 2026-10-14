<?php
get_header();

$this_slug = get_post_field('post_name', get_the_ID());

global $post;
$slug = $post->post_name;
$parent_id = $post->post_parent;
?>
<?php
if ($parent_id) {
    $parent_slug = get_post($parent_id)->post_name;
    if ($parent_slug == 'service') {
        get_template_part('page/service/' . $slug);
    } else {
        get_template_part('page/' . $slug);
    }
} else {
    get_template_part('page/' . $slug);
}
?>

<section class="page-common-head">
    <div class="page-common-head__inner inner860">
        <h1 class="page-common-head__title"><?php the_title(); ?></h1>
    </div>
    <img class="page-common-head__image" src="<?php echo get_template_directory_uri(); ?>/img/Group 518.webp" alt="">
</section>
<?php if (function_exists('yoast_breadcrumb')) {
    yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
} ?>

<section class="page-common-content page-common-content-template">
    <div class="page-common-content__inner inner860">
        <?php the_content(); ?>
    </div>
</section>

<?php get_footer(); ?>