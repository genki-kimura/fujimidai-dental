<?php
// お知らせ(CPT: news)個別ページ
// 構造は固定ページと同じ: .page-common-head(紫のバナー) → パンくず → .page-common-content(本文)
while ( have_posts() ) : the_post();

    // お知らせカテゴリー(タクソノミー名を決め打ちせず、newsに紐づく最初のものを使う)
    $taxonomies = get_object_taxonomies( get_post_type() );
    $terms      = $taxonomies ? get_the_terms( get_the_ID(), $taxonomies[0] ) : false;
?>

<section class="page-common-head">
  <div class="page-common-head__inner">
    <h1 class="page-common-head__title"><?php the_title(); ?></h1>
  </div>
</section>

<?php if ( function_exists( 'yoast_breadcrumb' ) ) : ?>
  <?php yoast_breadcrumb( '<div id="breadcrumbs">', '</div>' ); ?>
<?php endif; ?>

<section class="page-common-content">
  <div class="page-common-content__inner">

    <div class="news-single-meta">
      <time class="news-single-meta__date" datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>">
        <?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?>
      </time>
      <?php if ( $terms && ! is_wp_error( $terms ) ) : ?>
        <?php foreach ( $terms as $term ) : ?>
          <span class="news-single-meta__cat"><?php echo esc_html( $term->name ); ?></span>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <div class="news-single-body">
      <?php the_content(); ?>
    </div>

    <div class="news-single-back">
      <div class="wp-block-buttons">
        <div class="wp-block-button internal-btn">
          <a class="wp-block-button__link" href="<?php echo esc_url( get_post_type_archive_link( 'news' ) ); ?>">お知らせ一覧へ</a>
        </div>
      </div>
    </div>

  </div>
</section>

<?php endwhile; ?>
