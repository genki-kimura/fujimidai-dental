<?php
/* ----------------------------------------
   コラム（投稿）の個別ページ
   single.php から get_template_part('single/post') で読み込まれます
   置き場所：テーマフォルダ / single / post.php

   見た目は、固定ページと同じ既存のSCSS（_block.scss）を使います
   ・タイトル部分：.page-common-head（紫のグラデーション）
   ・パンくず　　：#breadcrumbs
   ・本文　　　　：.page-common-content（h2〜h5・リスト・ボタンなど）
   ※ 固定ページ(page.php)と同じ構造にしてあります。page.php の記述と違う場合は、そちらに合わせてください
---------------------------------------- */

// カテゴリ名（デフォルトカテゴリ「未分類」は除く）
$cs_cat = '';
$cs_cats = get_the_category();
if ($cs_cats) {
    foreach ($cs_cats as $cs_term) {
        if ((int) $cs_term->term_id !== (int) get_option('default_category')) {
            $cs_cat = $cs_term->name;
            break;
        }
    }
}

// コラム一覧のURL（設定 > 表示設定の「投稿ページ」を優先。未設定なら /column/）
$cs_page_id  = (int) get_option('page_for_posts');
$cs_list_url = $cs_page_id ? get_permalink($cs_page_id) : home_url('/column/');
?>
<main>
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>

            <!-- タイトル部分（既存：.page-common-head） -->
            <section class="page-common-head">
                <div class="page-common-head__inner">
                    <h1 class="page-common-head__title"><?php the_title(); ?></h1>
                </div>
            </section>

            <!-- パンくず（既存：#breadcrumbs / Yoast SEO） -->
            <?php if (function_exists('yoast_breadcrumb')) : ?>
                <?php yoast_breadcrumb('<div id="breadcrumbs">', '</div>'); ?>
            <?php endif; ?>

            <!-- 本文（既存：.page-common-content） -->
            <section class="page-common-content">
                <div class="page-common-content__inner">
                    <div class="Column-single__meta">
                        <time class="Column-single__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('Y.m.d')); ?></time>
                        <?php if ($cs_cat !== '') : ?>
                            <span class="Column-single__cat"><?php echo esc_html($cs_cat); ?></span>
                        <?php endif; ?>
                    </div>

                    <?php if (has_post_thumbnail()) : ?>
                        <div class="Column-single__thumb">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>

                    <?php the_content(); ?>

                    <!-- コラム一覧へ戻るボタン（既存：内部リンクボタン .internal-btn・中央ぞろえ） -->
                    <div class="wp-block-buttons Column-single__back">
                        <div class="wp-block-button internal-btn">
                            <a class="wp-block-button__link" href="<?php echo esc_url($cs_list_url); ?>">コラム一覧へ戻る</a>
                        </div>
                    </div>
                </div>
            </section>

        <?php endwhile; ?>
    <?php endif; ?>
</main>
