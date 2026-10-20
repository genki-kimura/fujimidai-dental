<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
    <!-- favicon OGP-->
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/img/favicon.ico" sizes="any">
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/img/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/img/apple-touch-icon.png">
    <meta property="og:title" content="">
    <meta property="og:description" content="">
    <meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/img/OGP.jpg">
    <?php get_template_part('/json/json-basic'); ?>
    <?php get_template_part('/json/json-faq'); ?>
    <?php if(is_single()){get_template_part('/json/json-column');}; ?>
</head>
<body>
<?php
/* ----------------------------------------
   ヘッダー用の値（ACFオプションページ「ヘッダー設定」から取得）
   ACF未導入・未入力の場合は、右側の初期値が表示されます
---------------------------------------- */
$header_field = function ($name, $default = '') {
    $value = function_exists('get_field') ? get_field($name, 'option') : '';
    return $value ? $value : $default;
};

$header_catch   = $header_field('header_catch', '富士見台駅の歯医者｜富士見台さくら歯科 中野区上鷺宮のインプラント・ホワイトニング');
$header_address = $header_field('header_address', '東京都中野区上鷺宮3丁目１６−９');

// ナビゲーション（リンク先は仮のURLです。ACFで設定するか、ここを書き換えてください）
$header_nav = $header_field('header_nav', array(
    array('label' => '当院の理念・特徴', 'url' => '/philosophy/'),
    array('label' => 'スタッフ紹介',     'url' => '/staff/'),
    array('label' => 'クリニック紹介',   'url' => '/clinic/'),
    array('label' => '診療案内一覧',     'url' => '/treatment/'),
    array('label' => '料金表',           'url' => '/price/'),
    array('label' => '初めての方へ',     'url' => '/first/'),
    array('label' => 'アクセス',         'url' => '/access/'),
));

/* ----------------------------------------
   スマホのハンバーガーメニューの中身
   ・リンク先は仮のURLです。ここを書き換えてください
   ・「医院について」「診療案内」は、左→右、上→下の順に2列で並びます
---------------------------------------- */
$header_url = function ($url) {
    $url = (string) $url;
    return (strpos($url, '/') === 0) ? home_url($url) : $url;
};
$header_img_dir = get_template_directory_uri() . '/img/';

$menu_about = array(
    array('label' => '当院の理念・特徴', 'url' => '/philosophy/'),
    array('label' => '初めての方へ',     'url' => '/first/'),
    array('label' => 'スタッフ紹介',     'url' => '/staff/'),
    array('label' => 'クリニック紹介',   'url' => '/clinic/'),
    array('label' => '料金表',           'url' => '/price/'),
    array('label' => '症例紹介',         'url' => '/case/'),
    array('label' => 'コラム',           'url' => '/column/'),
    array('label' => 'アクセス案内',     'url' => '/access/'),
);

// 写真つきの3つ（写真は img フォルダ内）
$menu_feature = array(
    array('label' => 'インプラント',   'url' => '/implant/',         'img' => 'Recommend01.webp'),
    array('label' => 'ホワイトニング', 'url' => '/whitening/',       'img' => 'Recommend02.webp'),
    array('label' => 'デンタルエステ', 'url' => '/dental-esthetic/', 'img' => 'Recommend03.webp'),
);

$menu_treatment = array(
    array('label' => '一般歯科（むし歯治療）', 'url' => '/general/'),
    array('label' => '予防歯科',               'url' => '/prevention/'),
    array('label' => '歯周病',                 'url' => '/periodontal/'),
    array('label' => '根管治療',               'url' => '/root-canal/'),
    array('label' => '審美歯科',               'url' => '/esthetic/'),
    array('label' => '口腔外科（親知らず）',   'url' => '/oral-surgery/'),
    array('label' => '矯正歯科治療',           'url' => '/orthodontics/'),
    array('label' => '小児歯科',               'url' => '/pediatric/'),
    array('label' => '入れ歯・義歯',           'url' => '/denture/'),
    array('label' => '訪問歯科診療',           'url' => '/home-visit/'),
    array('label' => '睡眠時無呼吸症候群',     'url' => '/sleep-apnea/'),
);

// 予約ボタン・電話（予約リンクと外来の電話番号は「フッター設定」の値を使います）
$menu_web_url   = $header_field('cta_web_url', '#');
$menu_white_url = $header_field('cta_white_url', '#');
$menu_tel_out   = $header_field('cta_tel', '03-5848-9373');
$menu_tel_visit = '03-5848-8484';
$menu_tel_href  = function ($tel) {
    return 'tel:' . preg_replace('/[^0-9+]/', '', $tel);
};

// 診療時間などの案内（スクリーンショットの文言）
$menu_info = array(
    '月〜土　9:00〜12:00 ／ 13:00〜18:00',
    '休診日：日祝　※木曜午後は祝日のある週のみ診療',
    '〒165-0031 東京都中野区上鷺宮3-16-9',
    '西武池袋線「富士見台駅」より徒歩3分',
);

$menu_sub = array(
    array('label' => 'プライバシーポリシー', 'url' => '/privacy-policy/', 'blank' => false),
    array('label' => 'サイトマップ',         'url' => '/sitemap/',        'blank' => false),
    array('label' => 'Instagram',            'url' => '#',                'blank' => true), // ← InstagramのURLに書き換え
);
?>
    <header class="header">
        <div class="header__inner">
            <div class="header__brand">
                <a class="header__logo" href="<?php echo esc_url(home_url('/')); ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/Logo.png" alt="富士見台さくら歯科" width="213" height="51">
                </a>
                <span class="header__divider" aria-hidden="true"></span>
                <div class="header__info">
                    <h1 class="header__catch"><?php echo esc_html($header_catch); ?></h1>
                    <div class="header__text">
                        <address>〒165-0031 <?php echo esc_html($header_address); ?></address>
                    </div>
                </div>
            </div>

            <button class="header__toggle" type="button" aria-controls="header-menu" aria-expanded="false" aria-label="メニューを開く">
                <span class="header__toggle-bar"></span>
                <span class="header__toggle-bar"></span>
                <span class="header__toggle-bar"></span>
            </button>

            <nav class="header__nav" id="header-nav" aria-label="メインメニュー">
                <ul class="header__nav-list">
                    <?php foreach ($header_nav as $item) : ?>
                        <?php
                        if (empty($item['label'])) { continue; }
                        $url = isset($item['url']) ? $item['url'] : '';
                        $url = (strpos($url, '/') === 0) ? home_url($url) : $url;
                        ?>
                        <li class="header__nav-item">
                            <a class="header__nav-link" href="<?php echo esc_url($url); ?>"><?php echo esc_html($item['label']); ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </div>

        <!-- スマホのハンバーガーメニュー（PCでは非表示） -->
        <div class="header__menu" id="header-menu">
            <div class="header__menu-inner">
                <section class="header__menu-block">
                    <p class="header__menu-title">医院について<span class="header__menu-en">ABOUT</span></p>
                    <ul class="header__menu-list">
                        <?php foreach ($menu_about as $item) : ?>
                            <li><a class="header__menu-link" href="<?php echo esc_url($header_url($item['url'])); ?>"><?php echo esc_html($item['label']); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </section>

                <section class="header__menu-block">
                    <p class="header__menu-title">診療案内<span class="header__menu-en">MENU</span></p>
                    <ul class="header__menu-cards">
                        <?php foreach ($menu_feature as $item) : ?>
                            <li>
                                <a class="header__menu-card" href="<?php echo esc_url($header_url($item['url'])); ?>">
                                    <span class="header__menu-card-img"><img src="<?php echo esc_url($header_img_dir . $item['img']); ?>" alt="" width="428" height="248" loading="lazy"></span>
                                    <span class="header__menu-card-label"><?php echo esc_html($item['label']); ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <ul class="header__menu-list">
                        <?php foreach ($menu_treatment as $item) : ?>
                            <li><a class="header__menu-link" href="<?php echo esc_url($header_url($item['url'])); ?>"><?php echo esc_html($item['label']); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </section>

                <div class="header__menu-cta">
                    <a class="header__menu-btn" href="<?php echo esc_url($header_url($menu_web_url)); ?>">
                        <span class="header__menu-btn-text">
                            <span class="header__menu-btn-sub">24時間受付中</span>
                            <span class="header__menu-btn-main">WEB予約する</span>
                        </span>
                        <span class="header__menu-btn-arrow" aria-hidden="true">→</span>
                    </a>
                    <a class="header__menu-btn header__menu-btn--outline" href="<?php echo esc_url($header_url($menu_white_url)); ?>">
                        <span class="header__menu-btn-text">
                            <span class="header__menu-btn-sub">ホワイトエッセンス加盟店</span>
                            <span class="header__menu-btn-main">ホワイトニングを予約</span>
                        </span>
                        <span class="header__menu-btn-arrow" aria-hidden="true">→</span>
                    </a>
                    <address class="header__menu-tel">
                        <a class="header__menu-tel-item" href="<?php echo esc_attr($menu_tel_href($menu_tel_out)); ?>">
                            <span class="header__menu-tel-label">TEL（外来）</span>
                            <span class="header__menu-tel-num"><?php echo esc_html($menu_tel_out); ?></span>
                        </a>
                        <a class="header__menu-tel-item" href="<?php echo esc_attr($menu_tel_href($menu_tel_visit)); ?>">
                            <span class="header__menu-tel-label">TEL（訪問）</span>
                            <span class="header__menu-tel-num"><?php echo esc_html($menu_tel_visit); ?></span>
                        </a>
                    </address>
                </div>

                <div class="header__menu-info">
                    <p class="header__menu-info-label">診療時間</p>
                    <?php foreach ($menu_info as $line) : ?>
                        <?php if (strpos($line, '〒') === 0 || strpos($line, '西武池袋線') === 0) : ?>
                            <address><?php echo esc_html($line); ?></address>
                        <?php else : ?>
                            <p><?php echo esc_html($line); ?></p>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

                <ul class="header__menu-sub">
                    <?php foreach ($menu_sub as $item) : ?>
                        <li>
                            <a href="<?php echo esc_url($header_url($item['url'])); ?>"<?php echo $item['blank'] ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>><?php echo esc_html($item['label']); ?><?php echo $item['blank'] ? '<span aria-hidden="true"> ↗</span>' : ''; ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </header>
    <main>
