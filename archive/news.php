<?php
// お知らせ(CPT: news)一覧ページ(archive.php から読み込まれる)
// 投稿タイプのアーカイブ・お知らせカテゴリーのアーカイブの両方で使う
$news_object = get_post_type_object( 'news' );
$news_title  = $news_object ? $news_object->labels->name : 'お知らせ';
?>

<section class="page-common-head">
  <div class="page-common-head__inner">
    <h1 class="page-common-head__title"><?php echo esc_html( $news_title ); ?></h1>
  </div>
</section>

<?php if ( function_exists( 'yoast_breadcrumb' ) ) : ?>
  <?php yoast_breadcrumb( '<div id="breadcrumbs">', '</div>' ); ?>
<?php endif; ?>

<section class="page-common-content">
  <div class="page-common-content__inner">

    <?php if ( have_posts() ) : ?>

      <ul class="news-archive-list">
        <?php
        while ( have_posts() ) :
            the_post();
            $taxonomies = get_object_taxonomies( get_post_type() );
            $terms      = $taxonomies ? get_the_terms( get_the_ID(), $taxonomies[0] ) : false;
        ?>
          <li class="news-archive-list__li">
            <a class="news-archive-item" href="<?php the_permalink(); ?>">
              <time class="news-archive-item__date" datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>">
                <?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?>
              </time>
              <?php if ( $terms && ! is_wp_error( $terms ) ) : ?>
                <span class="news-archive-item__cat"><?php echo esc_html( $terms[0]->name ); ?></span>
              <?php endif; ?>
              <span class="news-archive-item__title"><?php the_title(); ?></span>
            </a>
          </li>
        <?php endwhile; ?>
      </ul>

      <?php
      $pagination = paginate_links( array(
          'type'      => 'list',
          'mid_size'  => 1,
          'prev_text' => '‹',
          'next_text' => '›',
      ) );
      if ( $pagination ) :
      ?>
        <nav class="news-archive-pagination" aria-label="ページネーション">
          <?php echo $pagination; ?>
        </nav>
      <?php endif; ?>

    <?php else : ?>
      <p>現在、お知らせはありません。</p>
    <?php endif; ?>

  </div>
</section>

