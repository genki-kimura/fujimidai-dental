<?php
/* ----------------------------------------
   コラム一覧ページ
   archive.php から get_template_part('archive/post') で読み込まれます
   置き場所：テーマフォルダ / archive / post.php

   ・タイトル部分：既存の .page-common-head（_block.scss）
   ・パンくず　　：既存の #breadcrumbs
   ・カード　　　：トップの「SAKURA MAG」と同じ .Sakura-mag__〜（_sec15-Sakura-mag.scss）
   ※ 一覧の追加分のスタイルは _page02-column-single.scss（.Column-archive）にあります
---------------------------------------- */

// タイトル（カテゴリの一覧のときはカテゴリ名、それ以外は「コラム」）
$ca_title = is_category() ? single_cat_title('', false) : 'コラム一覧';
?>
<main>
    <!-- タイトル部分（既存：.page-common-head） -->
    <section class="page-common-head">
        <div class="page-common-head__inner">
            <h1 class="page-common-head__title"><?php echo esc_html($ca_title); ?></h1>
        </div>
    </section>

    <!-- パンくず（既存：#breadcrumbs / Yoast SEO） -->
    <?php if (function_exists('yoast_breadcrumb')) : ?>
        <?php yoast_breadcrumb('<div id="breadcrumbs">', '</div>'); ?>
    <?php endif; ?>

    <section class="Column-archive">
        <div class="Column-archive__inner">
            <?php if (have_posts()) : ?>
                <ul class="Sakura-mag__list">
                    <?php while (have_posts()) : the_post(); ?>
                        <?php
                        // カテゴリ名（デフォルトカテゴリ「未分類」は除く）
                        $ca_cat  = '';
                        $ca_cats = get_the_category();
                        if ($ca_cats) {
                            foreach ($ca_cats as $ca_term) {
                                if ((int) $ca_term->term_id !== (int) get_option('default_category')) {
                                    $ca_cat = $ca_term->name;
                                    break;
                                }
                            }
                        }
                        // 説明文（全角で約40文字まで）
                        $ca_excerpt = mb_strimwidth(wp_strip_all_tags(get_the_excerpt()), 0, 80, '…', 'UTF-8');
                        ?>
                        <li class="Sakura-mag__item">
                            <a class="Sakura-mag__card" href="<?php the_permalink(); ?>">
                                <div class="Sakura-mag__thumb">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php echo get_the_post_thumbnail(get_the_ID(), 'large', array('class' => 'Sakura-mag__img', 'loading' => 'lazy')); ?>
                                    <?php else : ?>
                                        <span class="Sakura-mag__noimg" aria-hidden="true"></span>
                                    <?php endif; ?>
                                </div>
                                <div class="Sakura-mag__body">
                                    <div class="Sakura-mag__meta">
                                        <time class="Sakura-mag__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('Y.m.d')); ?></time>
                                        <?php if ($ca_cat !== '') : ?>
                                            <span class="Sakura-mag__cat"><?php echo esc_html($ca_cat); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <p class="Sakura-mag__name"><span><?php the_title(); ?></span></p>
                                    <p class="Sakura-mag__text"><?php echo esc_html($ca_excerpt); ?></p>
                                </div>
                            </a>
                        </li>
                    <?php endwhile; ?>
                </ul>

                <?php
                // ページ送り（記事が多いとき）
                the_posts_pagination(array(
                    'mid_size'           => 1,
                    'prev_text'          => '←',
                    'next_text'          => '→',
                    'screen_reader_text' => 'ページ送り',
                ));
                ?>
            <?php else : ?>
                <p class="Sakura-mag__empty">現在、コラムはありません。</p>
            <?php endif; ?>
        </div>
    </section>
</main>
