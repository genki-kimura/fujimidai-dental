<?php get_header(); ?>
<?php
/* ----------------------------------------
   メインビジュアルの文言（ACF：トップページの編集画面「メインビジュアル」から取得）
   ACF未導入・未入力の場合は、右側の初期値が表示されます
---------------------------------------- */
$mv_field = function ($name, $default = '') {
    $value = function_exists('get_field') ? get_field($name) : '';
    return $value ? $value : $default;
};

$mv_en     = $mv_field('mv_en', 'Smiles, in bloom.');
$mv_lead   = $mv_field('mv_lead', '生涯、自分の歯で笑うために。');
$mv_badges = $mv_field('mv_badges', array(
    array('text' => "富士見台駅\n徒歩3分\n土曜も診療"),
    array('text' => "認定専門医による\nインプラント治療"),
    array('text' => "予防から審美・\n訪問診療まで対応"),
));

// 切り替わる写真（img フォルダの Mv01.png〜Mv03.png が大きい写真、Mv01-s.webp〜Mv03-s.webp が小さい写真）
$mv_dir    = get_template_directory_uri() . '/img/';
$mv_slides = array(
    array('name' => 'Mv01', 'alt' => 'モニターを使って説明する歯科医師'),
    array('name' => 'Mv02', 'alt' => '資料を見せながら説明するスタッフ'),
    array('name' => 'Mv03', 'alt' => '受付と待合室'),
);
?>

        <!-- MV -->
        <section class="Mv">
            <div class="Mv__frame">
                <div class="Mv__bg" aria-hidden="true"></div>

                <!-- 後ろで大きく表示される写真（順番に切り替わります） -->
                <div class="Mv__photos">
                    <?php foreach ($mv_slides as $i => $slide) : ?>
                        <div class="Mv__photo<?php echo $i === 0 ? ' is-active' : ''; ?>"<?php echo $i === 0 ? '' : ' aria-hidden="true"'; ?>>
                            <img src="<?php echo esc_url($mv_dir . $slide['name'] . '.webp'); ?>" alt="<?php echo esc_attr($slide['alt']); ?>" width="1620" height="1296"<?php echo $i === 0 ? ' fetchpriority="high"' : ' loading="lazy"'; ?>>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="Mv__body">
                    <p class="Mv__en"><?php echo esc_html($mv_en); ?></p>
                    <p class="Mv__title"><span>笑顔</span><span class="Mv__title-comma">、</span><span class="Mv__title-tail">めぐる。</span></p>
                    <span class="Mv__line" aria-hidden="true"></span>
                    <p class="Mv__lead"><?php echo esc_html($mv_lead); ?></p>
                    <?php if (is_array($mv_badges)) : ?>
                        <ul class="Mv__badges">
                            <?php foreach (array_slice($mv_badges, 0, 3) as $badge) : ?>
                                <?php if (empty($badge['text'])) { continue; } ?>
                                <li class="Mv__badge">
                                    <span class="Mv__badge-ring"><span class="Mv__badge-text"><?php echo nl2br(esc_html($badge['text'])); ?></span></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>

                <!-- 小さい写真（表示中の写真に対応するものだけ少し暗くなります） -->
                <div class="Mv__thumbs" role="group" aria-label="メインビジュアルの切り替え">
                    <?php foreach ($mv_slides as $i => $slide) : ?>
                        <button class="Mv__thumb<?php echo $i === 0 ? ' is-active' : ''; ?>" type="button" aria-label="<?php echo esc_attr(($i + 1) . '枚目の写真を表示'); ?>" aria-current="<?php echo $i === 0 ? 'true' : 'false'; ?>">
                            <img src="<?php echo esc_url($mv_dir . $slide['name'] . '-s.webp'); ?>" alt="" width="3000" height="2001">
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="Banner">
                <div class="Banner-wrap">
                        <a href="" class="Banner-btn">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/img/Implant.webp'); ?>" alt="インプラントはこちら" />
                        </a>
                        <a href="" class="Banner-btn">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/img/Whitening.webp'); ?>" alt="ホワイトニングはこちら" />
                        </a>
                </div>
        </section>

        <?php
        $insta_posts = function_exists('get_field') ? get_field('insta_posts') : array();
        if (empty($insta_posts) || !is_array($insta_posts)) {
        $insta_posts = array_fill(0, 5, array('image' => '', 'url' => ''));
        }
        $insta_posts = array_slice($insta_posts, 0, 5); // 最大5件まで
        $insta_total = count($insta_posts);
        ?>

        <section class="Post">
                <div class="Post__inner">
                        <div class="Post__slider" role="region" aria-roledescription="carousel" aria-label="Instagramの新着投稿">
                                <div class="Post__viewport">
                                        <ul class="Post__list">
                                                <?php foreach ($insta_posts as $i => $item) : ?>
                                                        <?php
                                                        $img_id = !empty($item['image']) ? (int) $item['image'] : 0;
                                                        $url    = !empty($item['url']) ? $item['url'] : '';
                                                        $tag    = $url ? 'a' : 'div';
                                                        $attr   = $url ? ' href="' . esc_url($url) . '" target="_blank" rel="noopener noreferrer"' : '';
                                                        $alt    = $img_id ? get_post_meta($img_id, '_wp_attachment_image_alt', true) : '';
                                                        if ($alt === '') {
                                                                $alt = 'Instagramの投稿 ' . ($i + 1);
                                                        }
                                                        ?>
                                                        <li class="Post__item">
                                                                <<?php echo $tag; ?> class="Post__card"<?php echo $attr; ?>>
                                                                        <?php if ($img_id) : ?>
                                                                                <?php echo wp_get_attachment_image($img_id, 'large', false, array('class' => 'Post__img', 'alt' => $alt, 'loading' => 'lazy')); ?>
                                                                        <?php endif; ?>
                                                                </<?php echo $tag; ?>>
                                                        </li>
                                                <?php endforeach; ?>
                                        </ul>
                                </div>
                                <?php if ($insta_total > 1) : ?>
                                        <button class="Post__arrow Post__arrow--prev" type="button" aria-label="前の投稿へ"></button>
                                        <button class="Post__arrow Post__arrow--next" type="button" aria-label="次の投稿へ"></button>
                                <?php endif; ?>
                        </div>
                        <?php if ($insta_total > 1) : ?>
                                <div class="Post__dots" role="group" aria-label="投稿の切り替え">
                                        <?php for ($i = 0; $i < $insta_total; $i++) : ?>
                                                <button class="Post__dot<?php echo $i === 0 ? ' is-active' : ''; ?>" type="button" aria-label="<?php echo esc_attr(($i + 1) . '件目の投稿へ'); ?>"<?php echo $i === 0 ? ' aria-current="true"' : ''; ?>></button>
                                        <?php endfor; ?>
                                </div>
                        <?php endif; ?>
                </div>
        </section>

        <?php
        /* ----------------------------------------
           About（img フォルダ：About-slot01〜05.webp / About-img01.webp / About-img02.webp）
        ---------------------------------------- */
        $about_dir    = get_template_directory_uri() . '/img/';
        $about_slides = array(
                array('file' => 'About-slot01.webp', 'alt' => '白を基調とした待合室'),
                array('file' => 'About-slot02.webp', 'alt' => 'Bloom Awardのトロフィー'),
                array('file' => 'About-slot03.webp', 'alt' => '診療室'),
                array('file' => 'About-slot04.webp', 'alt' => '個室の診療室'),
                array('file' => 'About-slot05.webp', 'alt' => '受付と廊下'),
        );
        ?>

        <section class="About">
                <div class="About__inner">
                        <header class="About__head">
                                <p class="About__en">ABOUT</p>
                                <h2 class="About__title">富士見台さくら歯科の診療方針</h2>
                                <span class="About__line" aria-hidden="true"></span>
                        </header>
                </div>

                <!-- 院内写真（横にゆっくり流れ続けます） -->
                <div class="About__slider" role="region" aria-label="院内写真">
                        <ul class="About__slides">
                                <?php for ($set = 0; $set < 2; $set++) : ?>
                                        <?php foreach ($about_slides as $slide) : ?>
                                                <li class="About__slide"<?php echo $set === 1 ? ' aria-hidden="true"' : ''; ?>>
                                                        <img src="<?php echo esc_url($about_dir . $slide['file']); ?>" alt="<?php echo $set === 1 ? '' : esc_attr($slide['alt']); ?>" width="740" height="416" loading="lazy">
                                                </li>
                                        <?php endforeach; ?>
                                <?php endfor; ?>
                        </ul>
                </div>

                <div class="About__inner">
                        <p class="About__catch">笑顔 ＝ 健康 × 美</p>
                        <p class="About__lead">あなたの笑顔は、大切な人へ、まわりの人へとめぐっていく。<br>健康と美をととのえ、めぐる笑顔を、富士見台さくら歯科から。</p>

                        <div class="About__venn">
                                <img class="About__flower" src="<?php echo esc_url($about_dir . 'About-img01.webp'); ?>" alt="笑顔は、健康と美が重なるところにある" width="1008" height="983" loading="lazy">

                                <div class="About__col About__col--health">
                                        <p class="About__col-title">健康<span>Health</span></p>
                                        <ul class="About__list">
                                                <li>予防歯科・定期メンテナンス</li>
                                                <li>プロによるクリーニング（PMTC）</li>
                                                <li>訪問診療・口腔ケア</li>
                                        </ul>
                                </div>

                                <div class="About__col About__col--beauty">
                                        <p class="About__col-title">美<span>BEAUTY</span></p>
                                        <ul class="About__list">
                                                <li>ホワイトニング</li>
                                                <li>審美治療（セラミック）</li>
                                                <li>インプラント・矯正</li>
                                        </ul>
                                </div>
                        </div>

                        <div class="About__card">
                                <div class="About__card-img">
                                        <img src="<?php echo esc_url($about_dir . 'About-img02.webp'); ?>" alt="資料を見せながら説明するスタッフ" width="1590" height="1062" loading="lazy">
                                </div>
                                <div class="About__card-body">
                                        <p class="About__card-title">すべての、大切な人へ。</p>
                                        <p class="About__card-text">歯科医療を通じて、皆さまの心と体の健康、そして幸福な人生へ。<br class="About__br">「愛と信頼、安らぎに満ち溢れた空間」を実現し、“自分の大切な人<br class="About__br">だったら”という視点で、お一人おひとりに向き合います。</p>
                                        <a class="About__btn" href="#">「当院の理念・特徴」詳しくはこちら</a>
                                </div>
                        </div>
                </div>
        </section>

        <section class="Information">
                <div class="Information__inner">
                        <header class="Information__head">
                                <p class="Information__en">INFORMATION</p>
                                <h2 class="Information__title">診療時間・アクセス</h2>
                                <span class="Information__line" aria-hidden="true"></span>
                        </header>

                        <div class="Information__body">
                                <!-- 左：診療時間・医院情報 -->
                                <div class="Information__main">
                                        <p class="Information__sub">診療時間</p>
                                        <table class="Information__table">
                                                <thead>
                                                        <tr>
                                                                <th scope="col"><span class="screen-reader-text">時間帯</span></th>
                                                                <th scope="col">月</th>
                                                                <th scope="col">火</th>
                                                                <th scope="col">水</th>
                                                                <th scope="col">木</th>
                                                                <th scope="col">金</th>
                                                                <th scope="col">土</th>
                                                                <th scope="col" class="is-holiday">日祝</th>
                                                        </tr>
                                                </thead>
                                                <tbody>
                                                        <tr>
                                                                <th scope="row">9:00–12:00</th>
                                                                <?php for ($i = 0; $i < 6; $i++) : ?>
                                                                        <td><span class="Information__mark Information__mark--open" role="img" aria-label="診療"></span></td>
                                                                <?php endfor; ?>
                                                                <td><span class="Information__mark Information__mark--closed" role="img" aria-label="休診"></span></td>
                                                        </tr>
                                                        <tr>
                                                                <th scope="row">13:00–18:00</th>
                                                                <td><span class="Information__mark Information__mark--open" role="img" aria-label="診療"></span></td>
                                                                <td><span class="Information__mark Information__mark--open" role="img" aria-label="診療"></span></td>
                                                                <td><span class="Information__mark Information__mark--open" role="img" aria-label="診療"></span></td>
                                                                <td><span class="Information__mark Information__mark--half" role="img" aria-label="祝日のある週のみ診療"></span></td>
                                                                <td><span class="Information__mark Information__mark--open" role="img" aria-label="診療"></span></td>
                                                                <td><span class="Information__mark Information__mark--open" role="img" aria-label="診療"></span></td>
                                                                <td><span class="Information__mark Information__mark--closed" role="img" aria-label="休診"></span></td>
                                                        </tr>
                                                </tbody>
                                        </table>
                                        <p class="Information__note"><span>※ 休診日：日曜・祝日</span><span>△（木曜午後）：祝日のある週のみ診療（〜18:00）</span></p>

                                        <dl class="Information__list">
                                                <div class="Information__row">
                                                        <dt>TEL</dt>
                                                        <dd><address><span class="Information__tel"><a href="tel:0358489373">03-5848-9373</a>（外来）／</span><span class="Information__tel"><a href="tel:0358488484">03-5848-8484</a>（訪問）</span></address></dd>
                                                </div>
                                                <div class="Information__row">
                                                        <dt>所在地</dt>
                                                        <dd><address>〒165-0031 東京都中野区上鷺宮3-16-9</address></dd>
                                                </div>
                                                <div class="Information__row">
                                                        <dt>アクセス</dt>
                                                        <dd><address>西武池袋線「富士見台駅」より徒歩3分（千川通り沿い）</address></dd>
                                                </div>
                                                <div class="Information__row">
                                                        <dt>駐車場</dt>
                                                        <dd>医院契約駐車場あり（上鷺宮3-12-5）／提携タイムズ 3か所</dd>
                                                </div>
                                        </dl>
                                </div>

                                <!-- 右：マップ・訪問歯科診療バナー -->
                                <div class="Information__side">
                                        <figure class="Information__map">
                                                <img src="<?php echo esc_url(get_template_directory_uri() . '/img/map.webp'); ?>" alt="富士見台駅から徒歩3分。千川通り沿いの富士見台さくら歯科への地図" width="1006" height="460" loading="lazy">
                                        </figure>
                                        <a href="#" class="Information__banner">
                                                <picture>
                                                        <source media="(max-width: 767px)" srcset="<?php echo esc_url(get_template_directory_uri() . '/img/house-call-medical-services-sp.webp'); ?>" width="670" height="250">
                                                        <img src="<?php echo esc_url(get_template_directory_uri() . '/img/house-call-medical-services.webp'); ?>" alt="訪問歯科診療 訪問診療専用 03-5848-8484 通えなくなっても、生涯このまちで 詳しくはこちら" width="1006" height="340" loading="lazy">
                                                </picture>
                                        </a>
                                </div>
                        </div>

                        <div class="Information__more">
                                <a href="#" class="Information__btn">「アクセス」詳しくはこちら<span aria-hidden="true">→</span></a>
                        </div>
                </div>
        </section>

        <section class="News">
                <?php
                /* ----------------------------------------
                   News（Custom Post Type UI で作成した投稿タイプ「news」の最新3件）
                   カテゴリ名は、news に紐づけたタクソノミーの1つ目のタームを表示します
                   （タクソノミー未作成・未選択の場合は「お知らせ」と表示）
                ---------------------------------------- */
                $news_query = new WP_Query(array(
                        'post_type'      => 'news',
                        'post_status'    => 'publish',
                        'posts_per_page' => 3,
                        'no_found_rows'  => true,
                ));
                $news_taxes   = get_object_taxonomies('news');
                $news_archive = get_post_type_archive_link('news');
                if (!$news_archive) {
                        $news_archive = home_url('/news/');
                }
                ?>

                <div class="News__inner">
                        <header class="News__head">
                                <p class="News__en">NEWS</p>
                                <h2 class="News__title">お知らせ</h2>
                        </header>

                        <?php if ($news_query->have_posts()) : ?>
                                <ul class="News__list">
                                        <?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
                                                <?php
                                                $news_cat = '';
                                                if (!empty($news_taxes)) {
                                                        $news_terms = get_the_terms(get_the_ID(), $news_taxes[0]);
                                                        if ($news_terms && !is_wp_error($news_terms)) {
                                                                $news_cat = $news_terms[0]->name;
                                                        }
                                                }
                                                if ($news_cat === '') {
                                                        $news_cat = 'お知らせ';
                                                }
                                                ?>
                                                <li class="News__item">
                                                        <a class="News__link" href="<?php the_permalink(); ?>">
                                                                <time class="News__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('Y.m.d')); ?></time>
                                                                <span class="News__cat"><?php echo esc_html($news_cat); ?></span>
                                                                <span class="News__text"><?php the_title(); ?></span>
                                                        </a>
                                                </li>
                                        <?php endwhile; ?>
                                </ul>
                                <?php wp_reset_postdata(); ?>
                        <?php else : ?>
                                <p class="News__empty">現在、お知らせはありません。</p>
                        <?php endif; ?>

                        <div class="News__more">
                                <a class="News__btn" href="<?php echo esc_url($news_archive); ?>">一覧はこちら<span aria-hidden="true">→</span></a>
                        </div>
                </div>
        </section>

        <section class="Recommend">
                <?php
                /* ----------------------------------------
                   Recommend（img フォルダ：Recommend01.webp〜Recommend03.webp）
                   'url' は各ページのURLに差し替えてください
                ---------------------------------------- */
                $rec_dir   = get_template_directory_uri() . '/img/';
                $rec_items = array(
                        array(
                                'type'  => 'implant',
                                'num'   => '01',
                                'en'    => 'IMPLANT',
                                'title' => 'インプラント',
                                'sub'   => '',
                                'text'  => '認定専門医による、確かなインプラント',
                                'url'   => '#',
                                'file'  => 'Recommend01.webp',
                                'alt'   => 'インプラントの模型イメージ',
                                'w'     => 4096,
                                'h'     => 2341,
                                'pos'   => '68% 50%',
                                'badge' => '',
                        ),
                        array(
                                'type'  => 'whitening',
                                'num'   => '02',
                                'en'    => 'WHITENING',
                                'title' => 'ホワイトニング',
                                'sub'   => '',
                                'text'  => '削らず、清潔感のある白い歯へ',
                                'url'   => '#',
                                'file'  => 'Recommend02.webp',
                                'alt'   => '白い歯で微笑む女性の口元',
                                'w'     => 4096,
                                'h'     => 2304,
                                'pos'   => '62% 50%',
                                'badge' => 'ホワイトエッセンス加盟店',
                        ),
                        array(
                                'type'  => 'esthetic',
                                'num'   => '03',
                                'en'    => 'DENTAL ESTHETICS',
                                'title' => 'デンタルエステ',
                                'sub'   => '（口腔内クリーニング、マッサージ）',
                                'text'  => '通うほど美しく、健康な口元に',
                                'url'   => '#',
                                'file'  => 'Recommend03.webp',
                                'alt'   => 'クリーニングを行う歯科衛生士',
                                'w'     => 3000,
                                'h'     => 2001,
                                'pos'   => '34% 50%',
                                'badge' => '',
                        ),
                );
                ?>

                <div class="Recommend__inner">
                        <header class="Recommend__head">
                                <p class="Recommend__head-en">RECOMMENDED</p>
                                <h2 class="Recommend__title">富士見台さくら歯科のおすすめメニュー</h2>
                                <span class="Recommend__head-line" aria-hidden="true"></span>
                        </header>

                        <ul class="Recommend__list">
                                <?php foreach ($rec_items as $item) : ?>
                                        <li class="Recommend__item Recommend__item--<?php echo esc_attr($item['type']); ?>">
                                                <div class="Recommend__visual">
                                                        <span class="Recommend__num"><?php echo esc_html($item['num']); ?></span>

                                                        <?php if ($item['badge']) : ?>
                                                                <!-- リングの上に沿って曲がる文字 -->
                                                                <svg class="Recommend__badge" viewBox="0 0 280 280" role="img" aria-label="<?php echo esc_attr($item['badge']); ?>">
                                                                        <defs>
                                                                                <path id="recommend-badge-arc" d="M 11.8 66 A 148 148 0 0 1 268.2 66"/>
                                                                        </defs>
                                                                        <line x1="50.1" y1="25" x2="41.5" y2="13.9"/>
                                                                        <line x1="229.9" y1="25" x2="238.5" y2="13.9"/>
                                                                        <text text-anchor="middle" aria-hidden="true">
                                                                                <textPath href="#recommend-badge-arc" startOffset="50%"><?php echo esc_html($item['badge']); ?></textPath>
                                                                        </text>
                                                                </svg>
                                                        <?php endif; ?>

                                                        <div class="Recommend__photo" style="--pos: <?php echo esc_attr($item['pos']); ?>;">
                                                                <img src="<?php echo esc_url($rec_dir . $item['file']); ?>" alt="<?php echo esc_attr($item['alt']); ?>" width="<?php echo (int) $item['w']; ?>" height="<?php echo (int) $item['h']; ?>" loading="lazy">
                                                        </div>
                                                </div>

                                                <p class="Recommend__en"><?php echo esc_html($item['en']); ?></p>
                                                <p class="Recommend__name">
                                                        <?php echo esc_html($item['title']); ?>
                                                        <?php if ($item['sub']) : ?>
                                                                <span class="Recommend__name-sub"><?php echo esc_html($item['sub']); ?></span>
                                                        <?php endif; ?>
                                                </p>
                                                <p class="Recommend__text"><?php echo esc_html($item['text']); ?></p>
                                                <a class="Recommend__btn" href="<?php echo esc_url($item['url']); ?>">詳しくはこちら<span aria-hidden="true">→</span></a>
                                        </li>
                                <?php endforeach; ?>
                        </ul>
                </div>
        </section>

        <section class="Implant">
                <?php
                /* ----------------------------------------
                   Implant
                   症例画像：'file' に img フォルダ内のファイル名を入れると、
                   グレーのダミーが画像に切り替わります（推奨サイズ 422×280px）
                ---------------------------------------- */
                $implant_dir   = get_template_directory_uri() . '/img/';
                $implant_cases = array(
                        array(
                                'label' => 'BEFORE',
                                'file'  => '',
                                'alt'   => 'インプラント治療前の口腔内',
                        ),
                        array(
                                'label' => 'AFTER',
                                'file'  => '',
                                'alt'   => 'インプラント治療後の口腔内',
                        ),
                );
                ?>

                <!-- 背景の透かしロゴ -->
                <span class="Implant__logo emblem" aria-hidden="true">
                        <img class="emblem__flower" src="<?php echo esc_url($implant_dir . 'Logo02-flower.webp'); ?>" alt="" width="834" height="1106" loading="lazy">
                        <img class="emblem__text" src="<?php echo esc_url($implant_dir . 'Logo02-text.webp'); ?>" alt="" width="834" height="1106" loading="lazy">
                </span>

                <div class="Implant__inner">
                        <div class="Implant__body">
                                <!-- SPでは、この枠（.Implant__intro）が角丸のカードになり、右の画像が背景として敷かれます -->
                                <div class="Implant__intro">
                                        <p class="Implant__en">IMPLANT</p>
                                        <h3 class="Implant__title">インプラント</h3>
                                        <p class="Implant__lead">失った歯を、根から取り戻す。</p>
                                        <p class="Implant__text">日本口腔インプラント学会の認定専門医が、診断から埋入・メンテナンスまで一貫して担当。噛む機能と自然な見た目を回復します。</p>

                                        <a class="Implant__btn" href="#">
                                                <span>詳しくはこちら</span>
                                                <svg viewBox="0 0 22 10" fill="none" stroke-width="1" aria-hidden="true"><path d="M0 5h21M17 1l4 4-4 4"/></svg>
                                        </a>

                                        <div class="Implant__visual">
                                                <img src="<?php echo esc_url($implant_dir . 'Recommend01.webp'); ?>" alt="インプラントの模型イメージ" width="4096" height="2341" loading="lazy">
                                        </div>
                                </div>

                                <div class="Implant__case">
                                        <p class="Implant__case-title">症例（CASE）</p>

                                        <div class="Implant__case-row">
                                                <?php foreach ($implant_cases as $i => $case) : ?>
                                                        <?php if ($i === 1) : ?>
                                                                <span class="Implant__case-arrow" aria-hidden="true">→</span>
                                                        <?php endif; ?>
                                                        <figure class="Implant__case-item">
                                                                <?php if ($case['file']) : ?>
                                                                        <div class="Implant__case-img">
                                                                                <img src="<?php echo esc_url($implant_dir . $case['file']); ?>" alt="<?php echo esc_attr($case['alt']); ?>" width="422" height="280" loading="lazy">
                                                                        </div>
                                                                <?php else : ?>
                                                                        <div class="Implant__case-img Implant__case-img--empty"><span>IMAGE</span></div>
                                                                <?php endif; ?>
                                                                <figcaption class="Implant__case-label"><?php echo esc_html($case['label']); ?></figcaption>
                                                        </figure>
                                                <?php endforeach; ?>
                                        </div>

                                        <div class="Implant__notes">
                                                <p>※ 自由診療（保険適用外）の治療例です。効果には個人差があります。</p>
                                                <p><span>治療期間・回数の目安：約3〜6か月／5〜8回</span>治療費（税込）：1歯 〇〇〇,〇〇〇円〜（別途、精密検査料・上部構造費）</p>
                                                <p>主なリスク・副作用：外科処置に伴う腫れ・痛み・内出血が生じることがあります。骨量が不足する場合は骨造成が必要となる、または適応外となることがあります。術後のメンテナンスを怠るとインプラント周囲炎により脱落する可能性があります。</p>
                                        </div>
                                </div>
                        </div>

                </div>
        </section>

        <section class="Whitening">
                <?php
                /* ----------------------------------------
                   Whitening（img フォルダ：Recommend02.webp を左の画像に使用）
                   症例画像：'file' に img フォルダ内のファイル名を入れると、
                   グレーのダミーが画像に切り替わります（推奨サイズ 422×280px）
                ---------------------------------------- */
                $whitening_dir   = get_template_directory_uri() . '/img/';
                $whitening_cases = array(
                        array(
                                'label' => 'BEFORE',
                                'file'  => '',
                                'alt'   => 'ホワイトニング施術前の歯',
                        ),
                        array(
                                'label' => 'AFTER',
                                'file'  => '',
                                'alt'   => 'ホワイトニング施術後の歯',
                        ),
                );
                ?>

                <!-- 背景の透かしロゴ -->
                <span class="Whitening__logo emblem" aria-hidden="true">
                        <img class="emblem__flower" src="<?php echo esc_url($whitening_dir . 'Logo02-flower.webp'); ?>" alt="" width="834" height="1106" loading="lazy">
                        <img class="emblem__text" src="<?php echo esc_url($whitening_dir . 'Logo02-text.webp'); ?>" alt="" width="834" height="1106" loading="lazy">
                </span>

                <div class="Whitening__inner">
                        <div class="Whitening__body">
                                <!-- SPでは、この枠（.Whitening__intro）が角丸のカードになり、画像が背景として敷かれます -->
                                <div class="Whitening__intro">
                                        <p class="Whitening__en">WHITENING</p>
                                        <h3 class="Whitening__title">ホワイトニング</h3>
                                        <p class="Whitening__lead">削らずに、清潔感のある白い歯へ。</p>
                                        <p class="Whitening__text">全国で展開するホワイトニング専門ブランド「ホワイトエッセンス」の加盟店。確かな技術と品質で、歯を削らずに清潔感のある白い歯へ。オフィス・ホーム・デュアルから選べます。</p>

                                        <a class="Whitening__btn" href="#">
                                                <span>詳しくはこちら</span>
                                                <svg viewBox="0 0 22 10" fill="none" stroke-width="1" aria-hidden="true"><path d="M0 5h21M17 1l4 4-4 4"/></svg>
                                        </a>

                                        <div class="Whitening__visual">
                                                <img src="<?php echo esc_url($whitening_dir . 'Recommend02.webp'); ?>" alt="白い歯で微笑む女性の口元" width="4096" height="2304" loading="lazy">
                                        </div>
                                </div>

                                <div class="Whitening__case">
                                        <p class="Whitening__case-title">症例（CASE）</p>

                                        <div class="Whitening__case-row">
                                                <?php foreach ($whitening_cases as $i => $case) : ?>
                                                        <?php if ($i === 1) : ?>
                                                                <span class="Whitening__case-arrow" aria-hidden="true">→</span>
                                                        <?php endif; ?>
                                                        <figure class="Whitening__case-item">
                                                                <?php if ($case['file']) : ?>
                                                                        <div class="Whitening__case-img">
                                                                                <img src="<?php echo esc_url($whitening_dir . $case['file']); ?>" alt="<?php echo esc_attr($case['alt']); ?>" width="422" height="280" loading="lazy">
                                                                        </div>
                                                                <?php else : ?>
                                                                        <div class="Whitening__case-img Whitening__case-img--empty"><span>IMAGE</span></div>
                                                                <?php endif; ?>
                                                                <figcaption class="Whitening__case-label"><?php echo esc_html($case['label']); ?></figcaption>
                                                        </figure>
                                                <?php endforeach; ?>
                                        </div>

                                        <div class="Whitening__notes">
                                                <p>※ 自由診療（保険適用外）の治療例です。効果には個人差があります。</p>
                                                <p><span>治療期間・回数の目安：オフィス 1〜3回／ホーム 約2週間〜</span>治療費（税込）：〇〇,〇〇〇円〜</p>
                                                <p>主なリスク・副作用：施術中から施術後にかけて一時的な知覚過敏やしみる症状が出ることがあります。詰め物・被せ物は白くなりません。時間の経過とともに色調が戻るため、定期的な再施術が必要です。</p>
                                        </div>
                                </div>
                        </div>
                </div>
        </section>

        <section class="Dental-esthetics">
                <?php
                /* ----------------------------------------
                   Dental Esthetics（img フォルダ：Dental-esthetics01〜05.webp が施術ステップの写真、
                   Recommend03.webp が右の大きい写真）
                   ※ 施術ステップは 1段目に2枚・2段目に3枚で表示します
                ---------------------------------------- */
                $de_dir   = get_template_directory_uri() . '/img/';
                $de_steps = array(
                        array('file' => 'Dental-esthetics01.webp', 'label' => 'ヤニ・茶渋取り', 'alt' => '前歯の着色汚れを器具で取り除く様子', 'w' => 2528, 'h' => 1696),
                        array('file' => 'Dental-esthetics02.webp', 'label' => '歯石取り',       'alt' => '歯ぐきのきわの歯石を取り除く様子',   'w' => 1264, 'h' => 848),
                        array('file' => 'Dental-esthetics03.webp', 'label' => 'フロッシング',   'alt' => '歯の間にフロスを通す様子',           'w' => 1024, 'h' => 1024),
                        array('file' => 'Dental-esthetics04.webp', 'label' => '歯面研磨',       'alt' => '歯の表面を専用の器具で磨く様子',     'w' => 1024, 'h' => 1024),
                        array('file' => 'Dental-esthetics05.webp', 'label' => '舌クリーニング', 'alt' => '舌専用の器具で舌を清掃する様子',     'w' => 1264, 'h' => 848),
                );
                $de_rows = array(
                        array_slice($de_steps, 0, 2),
                        array_slice($de_steps, 2),
                );
                ?>

                <!-- 背景の透かしロゴ -->
                <span class="Dental-esthetics__logo emblem" aria-hidden="true">
                        <img class="emblem__flower" src="<?php echo esc_url($de_dir . 'Logo02-flower.webp'); ?>" alt="" width="834" height="1106" loading="lazy">
                        <img class="emblem__text" src="<?php echo esc_url($de_dir . 'Logo02-text.webp'); ?>" alt="" width="834" height="1106" loading="lazy">
                </span>

                <div class="Dental-esthetics__inner">
                        <div class="Dental-esthetics__body">
                                <!-- SPでは、この枠（.Dental-esthetics__intro）が角丸のカードになり、画像が背景として敷かれます -->
                                <div class="Dental-esthetics__intro">
                                        <p class="Dental-esthetics__en">DENTAL ESTHETICS</p>
                                        <h3 class="Dental-esthetics__title">デンタルエステ</h3>
                                        <p class="Dental-esthetics__sub">（口腔内クリーニング、マッサージ）</p>
                                        <p class="Dental-esthetics__lead">通うほど美しく、健康な口元へ。</p>
                                        <p class="Dental-esthetics__text">歯だけでなく、歯ぐきや口元全体を整えるトータルケアです。クリーニング（PMTC）やガムピーリングによる歯ぐきの黒ずみケア、口元・リップのお手入れまで、美容感覚で通える完全個室で受けられます。</p>

                                        <a class="Dental-esthetics__btn" href="#">
                                                <span>詳しくはこちら</span>
                                                <svg viewBox="0 0 22 10" fill="none" stroke-width="1" aria-hidden="true"><path d="M0 5h21M17 1l4 4-4 4"/></svg>
                                        </a>

                                        <div class="Dental-esthetics__visual">
                                                <img src="<?php echo esc_url($de_dir . 'Recommend03.webp'); ?>" alt="クリーニングを行う歯科衛生士" width="3000" height="2001" loading="lazy">
                                        </div>
                                </div>

                                <div class="Dental-esthetics__steps" role="group" aria-label="施術の流れ">
                                        <?php foreach ($de_rows as $row_index => $row) : ?>
                                                <ol class="Dental-esthetics__steps-row">
                                                        <?php if ($row_index === 0) : ?>
                                                                <li class="Dental-esthetics__steps-badge" aria-hidden="true"><span class="Dental-esthetics__steps-badge-box"><span>施術</span><span>STEP</span></span></li>
                                                        <?php endif; ?>
                                                        <?php foreach ($row as $step) : ?>
                                                                <li class="Dental-esthetics__step">
                                                                        <figure class="Dental-esthetics__step-fig">
                                                                                <div class="Dental-esthetics__step-img">
                                                                                        <img src="<?php echo esc_url($de_dir . $step['file']); ?>" alt="<?php echo esc_attr($step['alt']); ?>" width="<?php echo (int) $step['w']; ?>" height="<?php echo (int) $step['h']; ?>" loading="lazy">
                                                                                </div>
                                                                                <figcaption class="Dental-esthetics__step-label"><?php echo esc_html($step['label']); ?></figcaption>
                                                                        </figure>
                                                                </li>
                                                        <?php endforeach; ?>
                                                </ol>
                                        <?php endforeach; ?>
                                </div>
                        </div>
                </div>
        </section>

        <section class="Reason">
                <?php
                /* ----------------------------------------
                   Reason（img フォルダ：About-slot04 / 05 / 01.webp を右の写真に使用）
                   ※ 右の写真は PC では右側に重ねて、タブレット（〜1179px）では一覧の下に並べます
                   ※ SP（〜768px）では右の写真は出さず、Reason-bg.webp（img フォルダ）を背景に敷きます
                   ※ 'title' の「|」はSPだけの改行位置です（PC・タブレットでは改行されません）
                ---------------------------------------- */
                $reason_dir    = get_template_directory_uri() . '/img/';
                $reason_points = array(
                        array(
                                'title' => '専門医による、確かな技術',
                                'text'  => '日本口腔インプラント学会 認定専門医・歯学博士（東京医科歯科大学出身）が診療。予防から専門治療まで幅広く対応。',
                        ),
                        array(
                                'title' => 'こだわりの自費補綴で、|美しく長持ち',
                                'text'  => 'セラミックなど自費の補綴物は、審美専門の歯科技工士が立会いのもとで製作。',
                        ),
                        array(
                                'title' => '完全個室で、|プライバシーに配慮',
                                'text'  => 'カウンセリング専用の個室を3室完備。周囲を気にせず、じっくり相談・治療を受けられます。',
                        ),
                        array(
                                'title' => '審美治療は、|完全デジタル（DX）化',
                                'text'  => '印象材が苦手な方も負担減、ミクロン単位の精度で適合性の良い被せ物を作成。',
                        ),
                        array(
                                'title' => '外来から訪問診療まで、|生涯のかかりつけに',
                                'text'  => '富士見台駅 徒歩3分・土曜も診療。通えなくなっても訪問診療で、一生涯お口の健康を支えます。',
                        ),
                );
                $reason_images = array(
                        array('file' => 'About-slot04.webp', 'alt' => '個室の診療室',         'w' => 740,  'h' => 416),
                        array('file' => 'About-slot05.webp', 'alt' => '受付と廊下',           'w' => 1278, 'h' => 853),
                        array('file' => 'About-slot01.webp', 'alt' => '白を基調とした待合室', 'w' => 740,  'h' => 492),
                );
                ?>

                <!-- SPだけ表示する背景写真（PC・タブレットでは非表示） -->
                <img class="Reason__bg" src="<?php echo esc_url($reason_dir . 'Reason-bg.webp'); ?>" alt="" width="750" height="2266" loading="lazy" aria-hidden="true">

                <div class="Reason__frame">
                    <div class="Reason__inner">
                            <header class="Reason__head">
                                    <p class="Reason__en">REASON</p>
                                    <h2 class="Reason__title">富士見台さくら歯科が選ばれる<br class="Reason__br">5つの魅力</h2>
                                    <span class="Reason__line" aria-hidden="true"></span>
                            </header>

                            <ol class="Reason__list">
                                    <?php foreach ($reason_points as $i => $point) : ?>
                                            <li class="Reason__item">
                                                    <span class="Reason__badge">
                                                            <span class="Reason__badge-label">POINT</span>
                                                            <span class="Reason__badge-num"><?php echo esc_html(sprintf('%02d', $i + 1)); ?></span>
                                                    </span>
                                                    <span class="Reason__bar" aria-hidden="true"></span>
                                                    <div class="Reason__item-body">
                                                            <h3 class="Reason__item-title"><?php echo implode('<br class="Reason__sp-br">', array_map('esc_html', explode('|', $point['title']))); ?></h3>
                                                            <p class="Reason__item-text"><?php echo esc_html($point['text']); ?></p>
                                                    </div>
                                            </li>
                                    <?php endforeach; ?>
                            </ol>

                            <a class="Reason__btn" href="#">はじめての方へ<span aria-hidden="true">→</span></a>
                    </div>

                    <div class="Reason__visual">
                            <span class="Reason__ring" aria-hidden="true"></span>
                            <span class="Reason__dot" aria-hidden="true"></span>
                            <?php foreach ($reason_images as $i => $img) : ?>
                                    <img class="Reason__img Reason__img--<?php echo (int) ($i + 1); ?>" src="<?php echo esc_url($reason_dir . $img['file']); ?>" alt="<?php echo esc_attr($img['alt']); ?>" width="<?php echo (int) $img['w']; ?>" height="<?php echo (int) $img['h']; ?>" loading="lazy">
                            <?php endforeach; ?>
                    </div>
                </div>
        </section>

        <section class="Menu">
                <?php
                /* ----------------------------------------
                   Menu（img フォルダ：Menu-icon-〇〇.webp が各診療のアイコン）
                   'url' は各診療ページのURLに差し替えてください
                   'w' / 'h' はアイコン画像の実寸（表示は CSS で縮小します）
                   'title' の「|」は、SP（〜599px）だけで改行する位置です（PC・タブレットでは改行されません）
                ---------------------------------------- */
                $menu_dir   = get_template_directory_uri() . '/img/';
                $menu_items = array(
                        array(
                                'title' => 'インプラント',
                                'icon'  => 'Menu01.webp', 'w' => 27, 'h' => 41,
                                'url'   => '#',
                                'items' => array('歯を失ってしまった', '入れ歯に違和感がある', '自然な見た目にしたい'),
                        ),
                        array(
                                'title' => 'ホワイトニング',
                                'icon'  => 'Menu02.webp', 'w' => 53, 'h' => 45,
                                'url'   => '#',
                                'items' => array('歯の黄ばみが気になる', '大事なイベントを控えている', '笑顔に自信を持ちたい'),
                        ),
                        array(
                                'title' => 'デンタルエステ',
                                'icon'  => 'Menu03.webp', 'w' => 44, 'h' => 40,
                                'url'   => '#',
                                'items' => array('歯のクリーニングでスッキリしたい', '大切な予定の前に口元を整えたい', 'リラックスしながらお口をケアしたい'),
                        ),
                        array(
                                'title' => '一般歯科|（むし歯治療）',
                                'icon'  => 'Menu04.webp', 'w' => 34, 'h' => 41,
                                'url'   => '#',
                                'items' => array('歯がしみる・痛む', '黒い穴・欠けが気になる', '詰め物・被せ物が取れた'),
                        ),
                        array(
                                'title' => '根管治療',
                                'icon'  => 'Menu04.webp', 'w' => 34, 'h' => 41,
                                'url'   => '#',
                                'items' => array('ズキズキと痛みが続く', '以前治療した歯が痛む', 'できるだけ歯を残したい'),
                        ),
                        array(
                                'title' => '予防歯科',
                                'icon'  => 'Menu05.webp', 'w' => 33, 'h' => 44,
                                'url'   => '#',
                                'items' => array('むし歯になりたくない', '歯石を取りたい', '健康な歯を保ちたい'),
                        ),
                        array(
                                'title' => '審美歯科',
                                'icon'  => 'Menu06.webp', 'w' => 41, 'h' => 41,
                                'url'   => '#',
                                'items' => array('銀歯を白くしたい', '見た目を重視したい', '金属アレルギーが心配'),
                        ),
                        array(
                                'title' => '歯周病',
                                'icon'  => 'Menu07.webp', 'w' => 44, 'h' => 39,
                                'url'   => '#',
                                'items' => array('歯ぐきの腫れ・出血', '口臭が気になる', '歯がぐらつく'),
                        ),
                        array(
                                'title' => '小児歯科',
                                'icon'  => 'Menu08.webp', 'w' => 36, 'h' => 43,
                                'url'   => '#',
                                'items' => array('お子さまに虫歯がある', '歯並びが気になる', '虫歯を予防したい'),
                        ),
                        array(
                                'title' => '矯正歯科治療',
                                'icon'  => 'Menu09.webp', 'w' => 48, 'h' => 44,
                                'url'   => '#',
                                'items' => array('歯並びを整えたい', '噛み合わせが気になる', '目立たず矯正したい'),
                        ),
                        array(
                                'title' => '訪問歯科診療',
                                'icon'  => 'Menu10.webp', 'w' => 48, 'h' => 41,
                                'url'   => '#',
                                'items' => array('通院が難しい', '自宅・施設で診てほしい', '口腔ケアをしたい'),
                        ),
                        array(
                                'title' => '入れ歯・義歯',
                                'icon'  => 'Menu11.webp', 'w' => 43, 'h' => 41,
                                'url'   => '#',
                                'items' => array('入れ歯が合わない', '硬い物が噛みにくい', '目立たない入れ歯にしたい'),
                        ),
                        array(
                                'title' => '睡眠時無呼吸症候群',
                                'icon'  => 'Menu12.webp', 'w' => 48, 'h' => 44,
                                'url'   => '#',
                                'items' => array('口が開きにくい', '顎が鳴る', '食いしばりが気になる'),
                        ),
                        array(
                                'title' => '口腔外科|（親知らず）',
                                'icon'  => 'Menu13.webp', 'w' => 40, 'h' => 44,
                                'url'   => '#',
                                'items' => array('親知らずが痛む', '顎が痛い・腫れる', '抜歯を相談したい'),
                        ),
                );
                ?>

                <div class="Menu__inner">
                        <header class="Menu__head">
                                <p class="Menu__en">MENU</p>
                                <h2 class="Menu__title">診療案内</h2>
                                <p class="Menu__lead">お子さまからご高齢の方まで、幅広い診療に対応しています。</p>
                        </header>

                        <ul class="Menu__list">
                                <?php foreach ($menu_items as $item) : ?>
                                        <li class="Menu__item">
                                                <div class="Menu__card">
                                                        <div class="Menu__card-head">
                                                                <span class="Menu__icon" aria-hidden="true">
                                                                        <img src="<?php echo esc_url($menu_dir . $item['icon']); ?>" alt="" width="<?php echo (int) $item['w']; ?>" height="<?php echo (int) $item['h']; ?>" loading="lazy">
                                                                </span>
                                                                <h3 class="Menu__name"><?php echo implode('<br class="Menu__sp-br">', array_map('esc_html', explode('|', $item['title']))); ?></h3>
                                                        </div>

                                                        <p class="Menu__label"><span>こんな方はご相談ください</span></p>

                                                        <ul class="Menu__points">
                                                                <?php foreach ($item['items'] as $point) : ?>
                                                                        <li><?php echo esc_html($point); ?></li>
                                                                <?php endforeach; ?>
                                                        </ul>

                                                        <a class="Menu__btn" href="<?php echo esc_url($item['url']); ?>"><span>詳しくはこちら<span class="Menu__btn-arrow" aria-hidden="true">→</span></span></a>
                                                </div>
                                        </li>
                                <?php endforeach; ?>
                        </ul>
                </div>
        </section>

        <section class="Greeting">
                <?php
                /* ----------------------------------------
                   Greeting（img フォルダ：Greeting.webp は左右反転した院長の写真）
                   略歴・所属資格は、下の配列を書き換えると表示が変わります
                ---------------------------------------- */
                $greeting_dir    = get_template_directory_uri() . '/img/';
                $greeting_career = array(
                        array('year' => '2001', 'lines' => array('東京医科歯科大学歯学部卒業')),
                        array('year' => '2019', 'lines' => array('東京医科歯科大学歯学部附属病院', '国立成育医療研究センター', '医療法人社団明翔会いしかわ歯科医院理事')),
                        array('year' => '2019', 'lines' => array('富士見台さくら歯科 開院')),
                );
                $greeting_member = array(
                        array('日本口腔インプラント学会認定', '口腔インプラント専門医'),
                        array('中野区歯科医師会 所属'),
                        array('東京都歯科医師会／日本歯科医師会 所属'),
                );
                ?>

                <!-- SPだけ表示する背景（上のゆるやかな波とピンクの光。img フォルダの Greeting-bg-sp.webp） -->
                <img class="Greeting__bg" src="<?php echo esc_url($greeting_dir . 'Greeting-bg-sp.webp'); ?>" alt="" width="750" height="1916" loading="lazy" aria-hidden="true">

                <div class="Greeting__inner">
                        <figure class="Greeting__photo">
                                <span class="Greeting__ring" aria-hidden="true"></span>
                                <span class="Greeting__dot" aria-hidden="true"></span>
                                <img src="<?php echo esc_url($greeting_dir . 'Greeting01.webp'); ?>" alt="モニターを使って説明する院長" width="3000" height="2001" loading="lazy">
                        </figure>

                        <div class="Greeting__body">
                                <header class="Greeting__head">
                                        <p class="Greeting__en">GREETING</p>
                                        <h2 class="Greeting__title">院長挨拶</h2>
                                        <span class="Greeting__line" aria-hidden="true"></span>
                                </header>

                                <p class="Greeting__catch">患者様の一生に、<br class="Greeting__sp-br">寄り添うために。</p>
                                <p class="Greeting__text">「関わるすべての人と、深いつながりを」。私たちは、痛みに配慮し、できるだけ歯を残す治療を大切にしています。予防から審美、インプラント、そして訪問診療まで、地域のかかりつけとして生涯にわたり伴走します。</p>

                                <div class="Greeting__name">
                                        <span class="Greeting__name-role">院長</span>
                                        <strong class="Greeting__name-main">芳賀 浩昭</strong>
                                        <span class="Greeting__name-note">日本口腔インプラント学会 認定専門医</span>
                                </div>

                                <div class="Greeting__profile">
                                        <div class="Greeting__block">
                                                <div class="Greeting__block-head">
                                                        <h3 class="Greeting__block-title">略歴</h3>
                                                        <p class="Greeting__block-en">CAREER</p>
                                                </div>
                                                <ol class="Greeting__career">
                                                        <?php foreach ($greeting_career as $row) : ?>
                                                                <li class="Greeting__career-item">
                                                                        <span class="Greeting__year"><?php echo esc_html($row['year']); ?></span>
                                                                        <?php foreach ($row['lines'] as $line) : ?>
                                                                                <span class="Greeting__career-line"><?php echo esc_html($line); ?></span>
                                                                        <?php endforeach; ?>
                                                                </li>
                                                        <?php endforeach; ?>
                                                </ol>
                                        </div>

                                        <div class="Greeting__block">
                                                <div class="Greeting__block-head">
                                                        <h3 class="Greeting__block-title">所属・資格</h3>
                                                        <p class="Greeting__block-en">MEMBERSHIP</p>
                                                </div>
                                                <ul class="Greeting__member">
                                                        <?php foreach ($greeting_member as $row) : ?>
                                                                <li class="Greeting__member-item">
                                                                        <?php foreach ($row as $line) : ?>
                                                                                <span class="Greeting__member-line"><?php echo esc_html($line); ?></span>
                                                                        <?php endforeach; ?>
                                                                </li>
                                                        <?php endforeach; ?>
                                                </ul>
                                        </div>
                                </div>

                                <a class="Greeting__btn" href="#">スタッフ紹介詳しくはこちら<span aria-hidden="true">→</span></a>
                        </div>
                </div>
        </section>

        <section class="Staff">
                <?php
                /* ----------------------------------------
                   Staff（img フォルダ：Staff01.webp がスタッフの集合写真）
                ---------------------------------------- */
                $staff_dir = get_template_directory_uri() . '/img/';
                ?>

                <div class="Staff__inner">
                        <header class="Staff__head">
                                <p class="Staff__en">STAFF</p>
                                <h2 class="Staff__title">スタッフ紹介</h2>
                                <span class="Staff__line" aria-hidden="true"></span>
                        </header>

                        <div class="Staff__body">
                                <p class="Staff__catch">チームで支える、<br class="Staff__sp-br">あなたのお口の健康。</p>
                                <p class="Staff__text">富士見台さくら歯科は、歯科医師・歯科衛生士・歯科助手・訪問コーディネーター・医療事務など、多職種のチームで診療にあたっています。<br class="Staff__sp-br">「和を以て貴しと為す」の理念のもと、一人ひとりが役割を果たし、患者様の笑顔のために協働します。</p>
                        </div>

                        <figure class="Staff__photo">
                                <img src="<?php echo esc_url($staff_dir . 'Staff01.webp'); ?>" alt="富士見台さくら歯科のスタッフの集合写真" width="900" height="405" loading="lazy">
                        </figure>
                </div>
        </section>

        <section class="Sakura-mag">
                <?php
                /* ----------------------------------------
                   Sakura MAG（WordPress の「コラム」＝投稿の最新3件を表示します）
                   ・アイキャッチ画像がない記事は、グレーの枠が表示されます
                   ・カテゴリ名は、記事に付けたカテゴリの1つ目を表示します（「未分類」は表示しません）
                   ・説明文は、記事の抜粋（未入力の場合は本文の冒頭）を表示します
                ---------------------------------------- */
                $mag_query = new WP_Query(array(
                        'post_type'           => 'post',
                        'post_status'         => 'publish',
                        'posts_per_page'      => 3,
                        'ignore_sticky_posts' => true,
                        'no_found_rows'       => true,
                ));
                // 「コラムを見る」の行き先：管理画面「設定 > 表示設定」で指定した「投稿ページ」を優先し、
                // 未設定の場合はコラム（投稿）の一覧が表示される /column/ にします
                $mag_page_id = (int) get_option('page_for_posts');
                $mag_archive = $mag_page_id ? get_permalink($mag_page_id) : home_url('/column/');
                ?>

                <!-- SPだけ表示する背景（ピンクのやわらかい光。img フォルダの Sakura-mag-bg-sp.webp） -->
                <img class="Sakura-mag__bg" src="<?php echo esc_url(get_template_directory_uri() . '/img/Sakura-mag-bg-sp.webp'); ?>" alt="" width="750" height="1364" loading="lazy" aria-hidden="true">

                <div class="Sakura-mag__inner">
                        <header class="Sakura-mag__head">
                                <div class="Sakura-mag__head-main">
                                        <p class="Sakura-mag__en">SAKURA MAG</p>
                                        <h2 class="Sakura-mag__title">スタッフが発信する、<br class="Sakura-mag__sp-br">歯とお口のコラム</h2>
                                        <span class="Sakura-mag__line" aria-hidden="true"></span>
                                </div>
                                <a class="Sakura-mag__more" href="<?php echo esc_url($mag_archive); ?>">コラムを見る<span aria-hidden="true">→</span></a>
                        </header>

                        <?php if ($mag_query->have_posts()) : ?>
                                <ul class="Sakura-mag__list">
                                        <?php while ($mag_query->have_posts()) : $mag_query->the_post(); ?>
                                                <?php
                                                // カテゴリ名（デフォルトカテゴリ「未分類」は除く）
                                                $mag_cat = '';
                                                $mag_cats = get_the_category();
                                                if ($mag_cats) {
                                                        foreach ($mag_cats as $mag_term) {
                                                                if ((int) $mag_term->term_id !== (int) get_option('default_category')) {
                                                                        $mag_cat = $mag_term->name;
                                                                        break;
                                                                }
                                                        }
                                                }
                                                // 説明文（全角で約40文字まで）
                                                $mag_excerpt = mb_strimwidth(wp_strip_all_tags(get_the_excerpt()), 0, 80, '…', 'UTF-8');
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
                                                                                <?php if ($mag_cat !== '') : ?>
                                                                                        <span class="Sakura-mag__cat"><?php echo esc_html($mag_cat); ?></span>
                                                                                <?php endif; ?>
                                                                        </div>
                                                                        <p class="Sakura-mag__name"><span><?php the_title(); ?></span></p>
                                                                        <p class="Sakura-mag__text"><?php echo esc_html($mag_excerpt); ?></p>
                                                                </div>
                                                        </a>
                                                </li>
                                        <?php endwhile; ?>
                                </ul>
                                <?php wp_reset_postdata(); ?>
                        <?php else : ?>
                                <p class="Sakura-mag__empty">現在、コラムはありません。</p>
                        <?php endif; ?>
                </div>
        </section>

        <section class="FAQ">
                <?php
                /* ----------------------------------------
                   よくあるご質問（ここを書き換えると内容が変わります）
                   ・一番上の質問だけ最初から開いた状態で表示します（他は＋を押すと開きます）
                   ・回答文は仮の文章です。実際の内容に差し替えてください
                ---------------------------------------- */
                $faq_items = array(
                        array(
                                'q' => '予約なしでも受診できますか？',
                                'a' => 'ご予約なしでも受診いただけますが、ご予約の方を優先してご案内しております。お待ちいただく場合がありますので、WEB予約またはお電話でのご予約をおすすめしています。痛みが強いなどお急ぎの場合は、まずはお電話でご相談ください。',
                        ),
                        array(
                                'q' => 'お支払いにクレジットカードは使えますか？',
                                'a' => '（ここに回答を入力してください）',
                        ),
                        array(
                                'q' => 'お子さま連れでも通えますか？',
                                'a' => '（ここに回答を入力してください）',
                        ),
                        array(
                                'q' => '訪問診療はどのエリアまで対応していますか？',
                                'a' => '（ここに回答を入力してください）',
                        ),
                        array(
                                'q' => '痛みが苦手ですが、配慮してもらえますか？',
                                'a' => '（ここに回答を入力してください）',
                        ),
                        array(
                                'q' => '駐車場・駐輪場はありますか？',
                                'a' => '（ここに回答を入力してください）',
                        ),
                );
                ?>

                <div class="FAQ__inner">
                        <header class="FAQ__head">
                                <p class="FAQ__en">FAQ</p>
                                <h2 class="FAQ__title">よくあるご質問</h2>
                                <span class="FAQ__line" aria-hidden="true"></span>
                        </header>

                        <ul class="FAQ__list">
                                <?php foreach ($faq_items as $i => $faq) : ?>
                                        <li class="FAQ__item">
                                                <h3 class="FAQ__heading">
                                                        <button type="button" class="FAQ__q" id="faq-q-<?php echo (int) $i; ?>" aria-expanded="<?php echo $i === 0 ? 'true' : 'false'; ?>" aria-controls="faq-a-<?php echo (int) $i; ?>">
                                                                <span class="FAQ__mark" aria-hidden="true">Q</span>
                                                                <span class="FAQ__q-text"><?php echo esc_html($faq['q']); ?></span>
                                                                <span class="FAQ__icon" aria-hidden="true"></span>
                                                        </button>
                                                </h3>
                                                <div class="FAQ__a<?php echo $i === 0 ? ' is-open' : ''; ?>" id="faq-a-<?php echo (int) $i; ?>" role="region" aria-labelledby="faq-q-<?php echo (int) $i; ?>">
                                                        <div class="FAQ__a-inner">
                                                                <div class="FAQ__a-body">
                                                                        <span class="FAQ__mark FAQ__mark--a" aria-hidden="true">A</span>
                                                                        <p class="FAQ__a-text"><?php echo esc_html($faq['a']); ?></p>
                                                                </div>
                                                        </div>
                                                </div>
                                        </li>
                                <?php endforeach; ?>
                        </ul>
                </div>
        </section>

        <section class="Access">
                <?php
                /* ----------------------------------------
                   Access（医院情報・アクセス）
                   ・WEB予約／ホワイトニングのリンクは、管理画面の「追従ボタン」の設定を使います
                   ・地図は住所から自動でGoogleマップを表示します（$access_map_src）
                     （Googleマップの「共有 > 地図を埋め込む」のURLに差し替えてもOKです。空にすると点線の仮表示に戻ります）
                   ・診療時間の表は $access_hours の open / half / closed を書き換えて変更します
                ---------------------------------------- */
                $access_dir     = get_template_directory_uri() . '/img/';
                $access_web_url = function_exists('get_field') ? get_field('cta_web_url', 'option') : '';
                $access_wht_url = function_exists('get_field') ? get_field('cta_white_url', 'option') : '';
                $access_web_url = $access_web_url ? $access_web_url : '#';
                $access_wht_url = $access_wht_url ? $access_wht_url : '#';
                // 決済方法の画像（img フォルダ内。大文字・小文字の違いでも見つかるようにしています）
                $access_pay_file = 'Payment-method.webp';
                foreach (array('Payment-method.webp', 'payment-method.webp', 'Payment-Method.webp', 'payment.webp') as $access_pay_candidate) {
                        if (file_exists(get_template_directory() . '/img/' . $access_pay_candidate)) {
                                $access_pay_file = $access_pay_candidate;
                                break;
                        }
                }
                $access_map_src = 'https://www.google.com/maps?q=' . rawurlencode('富士見台さくら歯科 東京都中野区上鷺宮3-16-9') . '&hl=ja&z=17&output=embed';

                $access_days  = array('月', '火', '水', '木', '金', '土');
                $access_hours = array(
                        '9:00–12:00'  => array('open', 'open', 'open', 'open', 'open', 'open', 'closed'),
                        '13:00–18:00' => array('open', 'open', 'open', 'half', 'open', 'open', 'closed'),
                );
                $access_labels = array(
                        'open'   => '診療',
                        'half'   => '祝日のある週のみ診療',
                        'closed' => '休診',
                );
                ?>

                <div class="Access__inner">
                        <!-- 左：医院情報・診療時間・決済方法 -->
                        <div class="Access__main">
                                <p class="Access__lead">あなたの笑顔を、お待ちしています。</p>
                                <p class="Access__name">富士見台さくら歯科</p>
                                <span class="Access__line" aria-hidden="true"></span>

                                <div class="Access__info">
                                        <div class="Access__info-row Access__info-row--address">
                                                <span class="Access__info-label">住所</span>
                                                <address class="Access__info-text">〒165-0031 東京都中野区上鷺宮3-16-9</address>
                                        </div>
                                        <div class="Access__info-row Access__info-row--tel">
                                                <span class="Access__info-label">電話</span>
                                                <address class="Access__info-text Access__tel"><span class="Access__tel-title">TEL</span> <span class="Access__tel-item"><a href="tel:0358489373">03-5848-9373</a><span class="Access__tel-type">外来</span></span><span class="Access__tel-sep">／</span> <span class="Access__tel-item"><a href="tel:0358488484">03-5848-8484</a><span class="Access__tel-type">訪問</span></span></address>
                                        </div>
                                        <div class="Access__info-row Access__info-row--access">
                                                <span class="Access__info-label">アクセス</span>
                                                <address class="Access__info-text">西武池袋線「富士見台駅」より徒歩3分（千川通り沿い）</address>
                                        </div>
                                        <div class="Access__info-row Access__info-row--parking">
                                                <span class="Access__info-label">駐車場</span>
                                                <p class="Access__info-text">医院契約駐車場あり／提携タイムズ 3か所</p>
                                        </div>
                                </div>

                                <div class="Access__hours">
                                        <p class="Access__sub">診療時間</p>
                                        <div class="Access__table-wrap">
                                                <table class="Access__table">
                                                        <thead>
                                                                <tr>
                                                                        <th scope="col"><span class="screen-reader-text">時間帯</span></th>
                                                                        <?php foreach ($access_days as $day) : ?>
                                                                                <th scope="col"><?php echo esc_html($day); ?></th>
                                                                        <?php endforeach; ?>
                                                                        <th scope="col" class="is-holiday">日祝</th>
                                                                </tr>
                                                        </thead>
                                                        <tbody>
                                                                <?php foreach ($access_hours as $time => $marks) : ?>
                                                                        <tr>
                                                                                <th scope="row"><?php echo esc_html($time); ?></th>
                                                                                <?php foreach ($marks as $mark) : ?>
                                                                                        <td><span class="Access__mark Access__mark--<?php echo esc_attr($mark); ?>" role="img" aria-label="<?php echo esc_attr($access_labels[$mark]); ?>"></span></td>
                                                                                <?php endforeach; ?>
                                                                        </tr>
                                                                <?php endforeach; ?>
                                                        </tbody>
                                                </table>
                                        </div>
                                        <p class="Access__note">※木曜午後（△）は祝日のある週のみ診療／休診：日曜・祝日</p>
                                </div>

                                <div class="Access__pay">
                                        <div class="Access__pay-head">
                                                <p class="Access__sub">決済方法</p>
                                                <p class="Access__pay-text">現金／各種クレジットカード／電子マネー・QR決済 対応</p>
                                        </div>
                                        <!-- PC：1枚 -->
                                        <p class="Access__pay-img Access__pay-img--pc">
                                                <img src="<?php echo esc_url($access_dir . $access_pay_file); ?>" alt="利用できるお支払い方法：VISA、Mastercard、iD、nanaco、JCB、AMERICAN EXPRESS、PayPay、WAON、QUICPay、交通系電子マネー など" width="1082" height="84" loading="lazy">
                                        </p>
                                        <!-- スマホ：2枚（img フォルダ：Payment-method-sp01.webp / Payment-method-sp02.webp） -->
                                        <div class="Access__pay-img Access__pay-img--sp">
                                                <img src="<?php echo esc_url($access_dir . 'Payment-method-sp01.webp'); ?>" alt="利用できるお支払い方法：タッチ決済、VISA、Mastercard、iD、nanaco" width="254" height="42" loading="lazy">
                                                <img src="<?php echo esc_url($access_dir . 'Payment-method-sp02.webp'); ?>" alt="利用できるお支払い方法：JCB、AMERICAN EXPRESS、PayPay、WAON、QUICPay、ナカペイ" width="287" height="42" loading="lazy">
                                        </div>
                                </div>
                        </div>

                        <!-- 右：予約ボタン・訪問歯科バナー・地図 -->
                        <div class="Access__side">
                                <div class="Access__cta">
                                        <a href="<?php echo esc_url($access_web_url); ?>" class="Access__btn">
                                                <span class="Access__btn-text">
                                                        <span class="Access__btn-sub">24時間受付中</span>
                                                        <span class="Access__btn-main">WEB予約する</span>
                                                </span>
                                                <span class="Access__btn-arrow" aria-hidden="true">→</span>
                                        </a>
                                        <a href="<?php echo esc_url($access_wht_url); ?>" class="Access__btn Access__btn--outline">
                                                <span class="Access__btn-text">
                                                        <span class="Access__btn-sub">ホワイトエッセンス加盟店</span>
                                                        <span class="Access__btn-main">ホワイトニングを予約</span>
                                                </span>
                                                <span class="Access__btn-arrow" aria-hidden="true">→</span>
                                        </a>
                                </div>

                                <a href="#" class="Access__banner">
                                        <picture>
                                                <source media="(max-width: 767px)" srcset="<?php echo esc_url($access_dir . 'house-call-medical-services-sp.webp'); ?>" width="670" height="250">
                                                <img src="<?php echo esc_url($access_dir . 'house-call-medical-services.webp'); ?>" alt="訪問歯科診療 訪問診療専用 03-5848-8484 通えなくなっても、生涯このまちで 詳しくはこちら" width="1005" height="340" loading="lazy">
                                        </picture>
                                </a>

                                <div class="Access__map">
                                        <?php if ($access_map_src) : ?>
                                                <iframe src="<?php echo esc_url($access_map_src); ?>" title="富士見台さくら歯科の地図" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                                        <?php else : ?>
                                                <p class="Access__map-label">MAP — Google マップ埋め込み</p>
                                        <?php endif; ?>
                                        <div class="Access__map-card">
                                                <p class="Access__map-name">富士見台さくら歯科</p>
                                                <address class="Access__map-address">〒165-0031 東京都中野区上鷺宮3-16-9</address>
                                                <p class="Access__map-meta">
                                                        <span class="Access__map-rate"><span aria-hidden="true">★</span> 4.8</span>
                                                        <a href="https://www.google.com/maps/search/?api=1&amp;query=<?php echo rawurlencode('富士見台さくら歯科 東京都中野区上鷺宮3-16-9'); ?>" target="_blank" rel="noopener">Google マップで見る →</a>
                                                </p>
                                        </div>
                                </div>
                        </div>
                </div>
        </section>

<?php get_footer(); ?>
