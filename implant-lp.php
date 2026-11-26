<?php
/*
Template Name: インプラントLP
*/

/* ----------------------------------------
   インプラントLP 共通の値
---------------------------------------- */
$ilp_img_dir  = get_template_directory_uri() . '/img/';
$ilp_img_path = get_template_directory() . '/img/';

// 予約ボタンのリンク先（管理画面「フッター設定」の WEB予約のリンク先 を使います）
$ilp_web_url = function_exists('get_field') ? get_field('cta_web_url', 'option') : '';
$ilp_web_url = $ilp_web_url ? $ilp_web_url : 'https://sakura-dc.reserve.ne.jp/sp/index.php?'; // 未設定のときは追従ボタンと同じ WEB予約のURL

/* ----------------------------------------
   FV の画像（img フォルダ）
   ・implant-lp-fv-photo.webp      … 院長の写真（PC。左側は透明）
   ・implant-lp-fv-photo-sp.webp   … 院長の写真（SP。下はぼかし済み）
   ・implant-lp-fv-model.webp      … インプラントの模型
   ・implant-lp-fv-badge-bg.webp   … 認定専門医バッジの丸い背景
   ・implant-lp-fv-badge-text.webp … 認定専門医バッジの文字
   ・implant-lp-fv-deco.webp       … 金の線・光の帯・下の波（PC）
   ・implant-lp-fv-deco-sp.webp    … 金の線・下の波（SP）
---------------------------------------- */

/* ----------------------------------------
   WHY NOW の動画
   ・img フォルダに implant-lp-why-video.mp4 があれば、その動画を自動再生・くり返し再生します（音なし）
     （mp4 があるときは、下の YouTube の設定は使いません）
   ・mp4 が無いときは YouTube（下の設定）を使います
---------------------------------------- */
$ilp_why_mp4     = 'implant-lp-why-video.mp4';
$ilp_why_mp4_url = file_exists($ilp_img_path . $ilp_why_mp4) ? $ilp_img_dir . $ilp_why_mp4 : '';

// img フォルダに mp4 があれば、そのURLを返す（無ければ空）
$ilp_mp4_url = function ($file) use ($ilp_img_dir, $ilp_img_path) {
    return ($file && file_exists($ilp_img_path . $file)) ? $ilp_img_dir . $file : '';
};

/* ----------------------------------------
   WHY NOW の動画（YouTube）※ mp4 が無いときだけ使います
   ・URLが支給されたら $ilp_why_youtube に入れてください
     （https://youtu.be/xxxx ／ https://www.youtube.com/watch?v=xxxx のどちらの形でもOK）
   ・URLを入れると、YouTubeのサムネイルが枠に表示され、再生ボタンで動画が流れます
   ・サムネイルを差し替えたい場合は、img フォルダに implant-lp-why-video.webp を入れてください
---------------------------------------- */
$ilp_why_youtube = ''; // ← ここに YouTube のURL

$ilp_youtube_id = function ($url) {
    if (preg_match('~(?:youtu\.be/|v=|embed/|shorts/)([A-Za-z0-9_-]{11})~', (string) $url, $m)) {
        return $m[1];
    }
    return '';
};
$ilp_why_video_id  = $ilp_youtube_id($ilp_why_youtube);
$ilp_why_thumb     = 'implant-lp-why-video.webp';
$ilp_why_thumb_url = '';
if (file_exists($ilp_img_path . $ilp_why_thumb)) {
    $ilp_why_thumb_url = $ilp_img_dir . $ilp_why_thumb;
} elseif ($ilp_why_video_id) {
    $ilp_why_thumb_url = 'https://i.ytimg.com/vi/' . $ilp_why_video_id . '/hqdefault.jpg';
}

/* ----------------------------------------
   ABOUT の動画
   ・img フォルダに implant-lp-video-implant.mp4 があれば、自動再生・くり返し再生します（音なし）
   ・mp4 が無いときは YouTube（下の設定）を使います
---------------------------------------- */
$ilp_about_mp4_url = $ilp_mp4_url('implant-lp-video-implant.mp4');

/* ----------------------------------------
   ABOUT の動画（YouTube）※ mp4 が無いときだけ使います
   ・URLが支給されたら $ilp_about_youtube に入れてください（WHY NOW と同じ使い方）
   ・サムネイルを差し替えたい場合は、img フォルダに implant-lp-about-video.webp を入れてください
---------------------------------------- */
$ilp_about_youtube  = ''; // ← ここに YouTube のURL
$ilp_about_video_id = $ilp_youtube_id($ilp_about_youtube);
$ilp_about_thumb_url = '';
if (file_exists($ilp_img_path . 'implant-lp-about-video.webp')) {
    $ilp_about_thumb_url = $ilp_img_dir . 'implant-lp-about-video.webp';
} elseif ($ilp_about_video_id) {
    $ilp_about_thumb_url = 'https://i.ytimg.com/vi/' . $ilp_about_video_id . '/hqdefault.jpg';
}

/* ----------------------------------------
   THE PROBLEM の動画（YouTube）
   ・構成メモに書かれていた URL を入れています（変更する場合はここを書き換え）
   ・サムネイルは YouTube の画像を自動で表示します
     差し替えたい場合は、img フォルダに implant-lp-problem-video.webp を入れてください
---------------------------------------- */
$ilp_problem_youtube  = 'https://youtu.be/-ikLMDo8RME';
$ilp_problem_video_id = $ilp_youtube_id($ilp_problem_youtube);
$ilp_problem_thumb_url = '';
if (file_exists($ilp_img_path . 'implant-lp-problem-video.webp')) {
    $ilp_problem_thumb_url = $ilp_img_dir . 'implant-lp-problem-video.webp';
} elseif ($ilp_problem_video_id) {
    $ilp_problem_thumb_url = 'https://i.ytimg.com/vi/' . $ilp_problem_video_id . '/hqdefault.jpg';
}

$ilp_why_items = array(
    array('title' => '両隣の歯が倒れ込む',       'text' => '空いたスペースに向かって隣の歯が傾き、歯並びと噛み合わせが崩れていきます。'),
    array('title' => '噛み合う歯が伸びてくる',   'text' => '上下で噛み合う相手を失った歯は、少しずつ伸び出してきます（挺出）。'),
    array('title' => '残った歯に負担が集中する', 'text' => '失った分の噛む力を他の歯が肩代わりし、歯の破折や歯周病のリスクが高まります。'),
    array('title' => 'あごの骨がやせていく',     'text' => '噛む刺激が伝わらなくなった部分の骨は吸収が進み、骨が減るほど選べる治療が限られます。'),
);

/* ----------------------------------------
   CTA（CONSULTATION）
   ・ページ内で何度か使うので、関数にしています
   ・電話番号は管理画面「フッター設定」の電話番号を使います
   ・特色の文章は、改行したい位置に \n を入れてください
---------------------------------------- */
$ilp_tel = function_exists('get_field') ? get_field('cta_tel', 'option') : '';
$ilp_tel = $ilp_tel ? $ilp_tel : '03-5848-9373';
$ilp_tel_href  = 'tel:' . preg_replace('/[^0-9+]/', '', $ilp_tel);
$ilp_tel_hours = '月〜土 9:00–12:00 / 13:00–18:00';

// 共通「3特色」
$ilp_features = array(
    // title・text の \n はPCだけ改行（SPは自然に折り返し）／text_short：紺のCTA用（短い文）
    array('title' => "口腔インプラント専門医による\n精密治療", 'text' => "日本口腔インプラント学会認定 口腔インプラント専門医がCT診断のもと精密に施術",   'text_short' => 'CT診断のもと精密に施術'),
    array('title' => '訪問診療で“入れた先”まで',         'text' => "通院できなくなっても、訪問診療で\n最期まで口腔ケアを継続",     'text_short' => '通えなくなっても最期まで'),
    array('title' => '骨が少ない・難症例も対応',         'text' => "骨造成やAll-on-4など幅広い選択肢で\n難症例にも対応します",     'text_short' => '骨造成・All-on-4にも対応'),
);

$ilp_cta = function ($args) use ($ilp_img_dir, $ilp_web_url, $ilp_tel, $ilp_tel_href, $ilp_tel_hours, $ilp_features) {
    $args = array_merge(array(
        'id'    => '',
        'en'    => 'CONSULTATION',
        'theme' => '',     // 'dark' にすると紺の背景（金のWEB予約ボタン）になります
        'title' => 'まずはお気軽に<br class="implant-cta__br-sp">ご相談ください', // SPだけ改行
        'title_gold' => '', // タイトルの後ろに続ける金色の文字
        'mark'  => '！',   // タイトル末尾の金色の記号（不要なら空に）
        'lead'  => 'カウンセリング受付中。迷っている段階でも大丈夫です。',
        'tagline' => '',  // リード文の代わりに出す金色の一文（例：—— 笑顔、めぐる。富士見台さくら歯科）
        'large' => false, // true にするとタイトルを大きく（2行のキャッチ用）
        'short' => null,  // 特色の説明文を短い文にするか（未指定なら、紺のデザインのときだけ短い文）
        'sp_light' => false, // true にすると、SPだけ明るい背景のデザイン（紺のWEB予約ボタン）
        'sp_dark'  => false, // true にすると、SPだけ紺の背景のデザイン（金のWEB予約ボタン）
    ), $args);
    ?>
    <?php /* 構成メモより：CTAのタイトルは h2（英字ラベルは h2 の中の span）。3カードのタイトルは <p> */ ?>
    <?php
    $is_dark   = ($args['theme'] === 'dark');
    $use_short = ($args['short'] === null) ? $is_dark : (bool) $args['short'];
    ?>
    <section class="implant-cta<?php echo $is_dark ? ' implant-cta--dark' : ''; ?><?php echo $args['large'] ? ' implant-cta--large' : ''; ?><?php echo $args['sp_light'] ? ' implant-cta--sp-light' : ''; ?><?php echo $args['sp_dark'] ? ' implant-cta--sp-dark' : ''; ?>"<?php echo $args['id'] ? ' id="' . esc_attr($args['id']) . '"' : ''; ?>>
        <div class="implant-cta__inner">
            <div class="implant-cta__head">
                <p class="implant-cta__en"><?php echo esc_html($args['en']); ?></p>
                <h2 class="implant-cta__heading">
                    <span class="implant-cta__title"><?php echo wp_kses($args['title'], array('br' => array('class' => true))); ?><?php if ($args['title_gold']) : ?><span class="implant-cta__title-gold"><?php echo esc_html($args['title_gold']); ?></span><?php endif; ?><?php if ($args['mark']) : ?><span class="implant-cta__mark"><?php echo esc_html($args['mark']); ?></span><?php endif; ?></span>
                </h2>
                <?php if ($args['tagline']) : ?>
                    <p class="implant-cta__tagline"><?php echo esc_html($args['tagline']); ?></p>
                <?php elseif ($args['lead']) : ?>
                    <p class="implant-cta__lead"><?php echo esc_html($args['lead']); ?></p>
                <?php endif; ?>
            </div>

            <ul class="implant-cta__features">
                <?php foreach ($ilp_features as $i => $feature) : ?>
                    <li class="implant-cta__feature">
                        <span class="implant-cta__feature-num" aria-hidden="true"><?php echo esc_html(sprintf('%02d', $i + 1)); ?></span>
                        <p class="implant-cta__feature-title"><span><?php echo str_replace("\n", '<br class="implant-cta__br-pc">', esc_html($feature['title'])); ?></span></p>
                        <p class="implant-cta__feature-text"><?php echo $use_short ? esc_html($feature['text_short']) : str_replace("\n", '<br class="implant-cta__br-pc">', esc_html($feature['text'])); // \n の改行はPCだけ ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="implant-cta__btns">
                <a class="implant-cta__web" href="<?php echo esc_url($ilp_web_url); ?>">
                    <span class="implant-cta__web-sub"><span class="implant-cta__diamond" aria-hidden="true"></span>24時間いつでも受付<span class="implant-cta__diamond" aria-hidden="true"></span></span>
                    <span class="implant-cta__web-main">カウンセリング WEB予約<span class="implant-cta__web-arrow" aria-hidden="true"></span></span>
                </a>
                <a class="implant-cta__tel" href="<?php echo esc_attr($ilp_tel_href); ?>">
                    <span class="implant-cta__tel-sub">ご予約・お問い合わせ</span>
                    <span class="implant-cta__tel-main">
                        <img class="implant-cta__tel-icon" src="<?php echo esc_url($ilp_img_dir . 'implant-lp-cta-tel.webp'); ?>" alt="" width="26" height="26" loading="lazy">
                        <span class="implant-cta__tel-num"><?php echo esc_html($ilp_tel); ?></span>
                    </span>
                    <span class="implant-cta__tel-hours"><?php echo esc_html($ilp_tel_hours); ?></span>
                </a>
            </div>
        </div>
    </section>
    <?php
};

get_header();
?>

<div class="implant-lp">

    <!-- ========================================
         FV（ファーストビュー）
    ========================================= -->
    <?php /* 構成メモより：H1 は「中野区・富士見台駅のインプラント治療｜富士見台さくら歯科」。大きなキャッチは装飾として <p> */ ?>
    <section class="implant-fv" id="fv">
        <!-- 背景の写真と飾り（金の線・波は画像 implant-lp-fv-deco.webp／SPは implant-lp-fv-deco-sp.webp）
             横幅1366pxの枠の中に置くので、大きな画面でも右端に寄らない -->
        <div class="implant-fv__visual" aria-hidden="true">
            <picture>
                <source media="(max-width: 1023px)" srcset="<?php echo esc_url($ilp_img_dir . 'implant-lp-fv-photo-sp.webp'); ?>" width="855" height="1140">
                <img class="implant-fv__photo" src="<?php echo esc_url($ilp_img_dir . 'implant-lp-fv-photo.webp'); ?>" alt="" width="2203" height="2100" fetchpriority="high">
            </picture>

            <!-- 金の線・光の帯・下の波（PC／SPで画像を切り替え） -->
            <picture>
                <source media="(max-width: 1023px)" srcset="<?php echo esc_url($ilp_img_dir . 'implant-lp-fv-deco-sp.webp'); ?>" width="1125" height="1815">
                <img class="implant-fv__deco" src="<?php echo esc_url($ilp_img_dir . 'implant-lp-fv-deco.webp'); ?>" alt="" width="4098" height="2100">
            </picture>

            <img class="implant-fv__model" src="<?php echo esc_url($ilp_img_dir . 'implant-lp-fv-model.webp'); ?>" alt="" width="540" height="799">
        </div>

        <div class="implant-fv__inner">
            <!-- 認定専門医バッジ（丸い背景＋文字の2枚を重ねる）。横幅1366pxの枠の中に置くので、大きな画面でも右端に寄らない -->
            <div class="implant-fv__badge" role="img" aria-label="日本口腔インプラント学会認定 口腔インプラント専門医 担当">
                <img class="implant-fv__badge-bg" src="<?php echo esc_url($ilp_img_dir . 'implant-lp-fv-badge-bg.webp'); ?>" alt="" width="732" height="732">
                <img class="implant-fv__badge-text" src="<?php echo esc_url($ilp_img_dir . 'implant-lp-fv-badge-text.webp'); ?>" alt="" width="448" height="448">
            </div>

            <div class="implant-fv__content">
                <p class="implant-fv__en" aria-hidden="true"><span class="implant-fv__en-main">IMP<span class="implant-fv__en-gold">LANT</span></span><span class="implant-fv__en-line"></span><span class="implant-fv__en-sub">Treatment</span></p>
                <h1 class="implant-fv__sub">
                    <span class="implant-fv__sub-main">富士見台・中野区・練馬区のインプラント治療</span>
                    <span class="screen-reader-text">｜</span>
                    <span class="implant-fv__sub-clinic">富士見台さくら歯科</span>
                </h1>
                <p class="implant-fv__title">
                    インプラント治療の<br>
                    「<span class="implant-fv__mark" style="--ilp-fv-mark: url('<?php echo esc_url($ilp_img_dir . 'implant-lp-fv-mark.webp'); ?>');">わからない</span>」を、<br>
                    ここで終わりに<span class="implant-fv__dot">。</span>
                </p>
                <span class="implant-fv__line" aria-hidden="true"></span>
                <p class="implant-fv__lead">費用も、痛みも、その先のことも。</p>
                <p class="implant-fv__note">日本口腔インプラント学会認定 口腔インプラント専門医がご説明します。</p>
                <a class="implant-fv__btn" href="<?php echo esc_url($ilp_web_url); ?>">
                    <span class="implant-fv__btn-text">カウンセリングのご予約</span>
                    <span class="implant-fv__btn-arrow" aria-hidden="true">→</span>
                </a>
            </div>

            <span class="implant-fv__scroll" aria-hidden="true">
                <span class="implant-fv__scroll-text">SCROLL</span>
                <span class="implant-fv__scroll-line"></span>
            </span>
        </div>
    </section>

    <!-- ========================================
         WHY NOW（なぜ歯が抜けたまま、放置してはいけないのか）
    ========================================= -->
    <section class="implant-why" id="why-now">
        <div class="implant-why__inner">
            <div class="implant-why__head">
                <p class="implant-why__en">WHY NOW</p>
                <h2 class="implant-why__title">
                    <span class="implant-why__title-text">なぜ歯が抜けたまま、<br class="implant-why__br-sp">放置してはいけないのか</span>
                </h2>
                <span class="implant-why__ornament" aria-hidden="true"><span class="implant-why__diamond"></span></span>
                <p class="implant-why__lead">歯が1本なくなっても、すぐに困らないことがあります。けれど口の中では、その日から少しずつ変化がはじまります。</p>
            </div>

            <div class="implant-why__card">
                <div class="implant-why__body">
                    <!-- 動画（URLが入るまでは枠と再生ボタンだけ表示） -->
                    <figure class="implant-why__video">
                        <?php if ($ilp_why_mp4_url) : ?>
                        <!-- 動画ファイル（自動再生・くり返し・音なし）。スマホでも自動再生できるよう muted と playsinline を付けています -->
                        <div class="implant-why__video-frame is-movie">
                            <video class="implant-why__video-movie" src="<?php echo esc_url($ilp_why_mp4_url); ?>" autoplay muted loop playsinline preload="auto" aria-label="歯が抜けたまま放置すると、まわりの歯が動いていく様子のアニメーション" data-autoplay-video></video>
                        </div>
                        <?php else : ?>
                        <div class="implant-why__video-frame<?php echo $ilp_why_thumb_url ? ' has-thumb' : ''; ?>" data-youtube-id="<?php echo esc_attr($ilp_why_video_id); ?>" data-video-title="なぜ歯を抜けた状態にしたらまずいのか（YouTube）">
                            <?php if ($ilp_why_thumb_url) : ?>
                                <img class="implant-why__video-thumb" src="<?php echo esc_url($ilp_why_thumb_url); ?>" alt="" width="640" height="360" loading="lazy">
                            <?php endif; ?>
                            <button type="button" class="implant-why__video-play" data-video-play aria-label="動画「なぜ歯を抜けた状態にしたらまずいのか」を再生する"<?php echo $ilp_why_video_id ? '' : ' disabled'; ?>>
                                <span class="implant-why__video-play-icon" aria-hidden="true"></span>
                            </button>
                        </div>
                        <?php endif; ?>
                    </figure>

                    <ol class="implant-why__list">
                        <?php foreach ($ilp_why_items as $i => $item) : ?>
                            <li class="implant-why__item">
                                <span class="implant-why__num" aria-hidden="true"><?php echo esc_html(sprintf('%02d', $i + 1)); ?></span>
                                <div class="implant-why__item-body">
                                    <h3 class="implant-why__item-title"><?php echo esc_html($item['title']); ?></h3>
                                    <p class="implant-why__item-text"><?php echo esc_html($item['text']); ?></p>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                </div>

                <p class="implant-why__message">放置した期間が長いほど、治せる選択肢は少なくなります。<br class="implant-why__br-pc">それでも治療に踏み出せないのには、きっと理由があるはずです。</p>
            </div>

            <span class="implant-why__arrow" aria-hidden="true"></span>
        </div>
    </section>

    <!-- ========================================
         TROUBLE（こんなお悩みで、あきらめていませんか？）
         ・各お悩みをクリックすると、対応するセクションへ移動します
           （移動先の id は、そのセクションを作るときに付けます）
    ========================================= -->
    <?php
    $ilp_trouble_items = array(
        array('text' => 'ブリッジ・入れ歯と何が違うのか分からない', 'href' => '#about'),    // インプラント治療とは
        array('text' => '高齢だけど、治療しても続けられるか不安',   'href' => '#problem'),  // 高齢者のインプラント治療で“その後”が問題になる理由
        array('text' => '見た目に違和感がないか気になる',           'href' => '#esthetic'), // “入れた”とわからない、自然な見た目へ
        array('text' => '他院で「難しい」と断られた',               'href' => '#consult'),  // 他院で「難しい」と断られた方のインプラント
        array('text' => '費用や治療期間が不安',                     'href' => '#flow'),     // インプラント治療の流れ
    );
    ?>
    <section class="implant-trouble" id="trouble">
        <div class="implant-trouble__photo" aria-hidden="true">
            <img src="<?php echo esc_url($ilp_img_dir . 'implant-lp-why-now01.webp'); ?>" alt="" width="1800" height="1536" loading="lazy">
        </div>

        <div class="implant-trouble__inner">
            <p class="implant-trouble__en"><span class="implant-trouble__en-main">TROUBLE</span><span class="implant-trouble__en-sub">Worries</span></p>
            <h2 class="implant-trouble__heading">
                <span class="implant-trouble__title">インプラント治療のよくあるお悩み</span>
                <span class="implant-trouble__catch">
                    <span class="implant-trouble__catch-sm">こんなお悩みで、</span>
                    <span class="implant-trouble__catch-lg">あきらめて<br class="implant-trouble__br-sp">いませんか<span class="implant-trouble__catch-q">？</span></span>
                </span>
            </h2>

            <ul class="implant-trouble__list">
                <?php foreach ($ilp_trouble_items as $item) : ?>
                    <li>
                        <a class="implant-trouble__link" href="<?php echo esc_attr($item['href']); ?>">
                            <span class="implant-trouble__check" aria-hidden="true"></span>
                            <span class="implant-trouble__text"><?php echo esc_html($item['text']); ?></span>
                            <span class="implant-trouble__arrow" aria-hidden="true"></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="implant-trouble__band">
            <p class="implant-trouble__band-inner">
                <span class="implant-trouble__band-icon" aria-hidden="true">
                    <img src="<?php echo esc_url($ilp_img_dir . 'implant-lp-why-now02.webp'); ?>" alt="" width="48" height="48" loading="lazy">
                </span>
                <span class="implant-trouble__band-text">気になるお悩みをタップ<span class="implant-trouble__band-arrow" aria-hidden="true"></span>当院の解決策へ移動します</span>
            </p>
        </div>
    </section>

    <!-- ========================================
         CTA①（CONSULTATION：まずはお気軽にご相談ください！）
         ・中身は上の $ilp_cta で作っています
    ========================================= -->
    <?php $ilp_cta(array('id' => 'cta-top')); ?>

    <!-- ========================================
         DOCTOR MESSAGE（芳賀院長がお答えします！）
         ・背景：img/implant-lp-doctor-bg.webp
         ・院長の写真：img/implant-lp-doctor01.webp（白い枠・影つきの画像）
         ・認定証：img/implant-lp-doctor02.webp（影つきの画像）
         ・経歴の年が空欄の行は、上の年の続きとして表示されます
    ========================================= -->
    <?php
    $ilp_doctor_history = array(
        array('year' => '2001', 'text' => '東京医科歯科大学 歯学部 卒業'),
        array('year' => '2005', 'text' => '同大学院 医歯学総合研究科 修了（歯学博士）'),
        array('year' => '',     'text' => '東京医科歯科大学 春日井昇一教授に師事'),
        array('year' => '',     'text' => '日本大学松戸歯学部 加藤仁夫教授に師事'),
        array('year' => '',     'text' => '東京医科歯科大学歯学部附属病院 等に勤務'),
        array('year' => '',     'text' => '練馬区内の医療法人にて12年間研鑽'),
        array('year' => '2019', 'text' => '富士見台さくら歯科 開院'),
    );
    $ilp_doctor_license = array(
        '日本口腔インプラント学会認定 口腔インプラント専門医',
        '日本顎咬合学会 認定医',
        '厚生労働省認定 歯科臨床研修指導医',
        '日本訪問歯科協会 所属',
        '中野区／東京都／日本 歯科医師会 所属',
        '日本大学松戸歯学部 有床義歯補綴学・口腔インプラント学講座 所属',
        '国内外の学会・病院研修に継続して参加',
    );
    // 経歴を <dl> 用に「年ごと」にまとめる（年が空の行は、直前の年に続けて入れる）
    $ilp_doctor_history_groups = array();
    foreach ($ilp_doctor_history as $row) {
        if ($row['year'] !== '' || !$ilp_doctor_history_groups) {
            $ilp_doctor_history_groups[] = array('year' => $row['year'], 'texts' => array());
        }
        $ilp_doctor_history_groups[count($ilp_doctor_history_groups) - 1]['texts'][] = $row['text'];
    }
    ?>
    <section class="implant-doctor" id="doctor" style="--doctor-bg: url('<?php echo esc_url($ilp_img_dir . 'implant-lp-doctor-bg.webp'); ?>')">
        <div class="implant-doctor__inner">
            <div class="implant-doctor__head">
                <p class="implant-doctor__en">DOCTOR MESSAGE</p>
                <h2 class="implant-doctor__heading">
                    <span class="implant-doctor__title">芳賀院長がお答えします！</span>
                    <span class="implant-doctor__sub">診断から手術、その後のメンテナンスまで一貫して担当</span>
                </h2>
                <span class="implant-doctor__ornament" aria-hidden="true"><span class="implant-doctor__diamond"></span></span>
            </div>

            <div class="implant-doctor__main">
                <!-- 左：院長の写真（影入りの画像）＋金の枠＋専門医バッジ -->
                <div class="implant-doctor__media">
                    <span class="implant-doctor__frame" aria-hidden="true"></span>
                    <picture class="implant-doctor__photo">
                        <source media="(max-width: 767px)" srcset="<?php echo esc_url($ilp_img_dir . 'implant-lp-doctor-photo-sp.webp'); ?>" width="638" height="636">
                        <img src="<?php echo esc_url($ilp_img_dir . 'implant-lp-doctor-photo.webp'); ?>" alt="富士見台さくら歯科 院長 芳賀浩昭" width="862" height="610" loading="lazy">
                    </picture>
                    <p class="implant-doctor__badge">
                        <span class="implant-doctor__badge-sub">日本口腔インプラント学会認定</span>
                        <span class="implant-doctor__badge-main">口腔インプラント専門医</span>
                    </p>
                </div>

                <!-- 右：メッセージ -->
                <div class="implant-doctor__body">
                    <h3 class="implant-doctor__catch">患者様の一生に、<br>寄り添う治療を。</h3>
                    <p class="implant-doctor__text">歯を失うことは、噛む・食べる・話すという生活の質に大きく関わります。だからこそ、精密な診断と丁寧なカウンセリングを大切に、患者様お一人おひとりに最良の選択をご提案します。</p>
                    <div class="implant-doctor__profile">
                        <p class="implant-doctor__license">日本口腔インプラント学会認定 口腔インプラント専門医</p>
                        <p class="implant-doctor__name">院長 芳賀 浩昭<span class="implant-doctor__kana">（はが ひろあき）</span></p>
                    </div>
                </div>
            </div>

            <!-- 経歴・所属・資格 -->
            <div class="implant-doctor__card">
                <div class="implant-doctor__col">
                    <h3 class="implant-doctor__col-title">経歴</h3>
                    <dl class="implant-doctor__history">
                        <?php foreach ($ilp_doctor_history_groups as $group) : ?>
                            <div class="implant-doctor__history-item">
                                <dt class="implant-doctor__year"><?php echo esc_html($group['year']); ?></dt>
                                <?php foreach ($group['texts'] as $text) : ?>
                                    <dd class="implant-doctor__history-text"><?php echo esc_html($text); ?></dd>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </dl>
                </div>
                <div class="implant-doctor__col">
                    <h3 class="implant-doctor__col-title">所属・資格</h3>
                    <ul class="implant-doctor__license-list">
                        <?php foreach ($ilp_doctor_license as $item) : ?>
                            <li><?php echo esc_html($item); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================
         ABOUT（インプラント治療とは｜入れ歯・ブリッジとの違い）
         ・お悩み①の答え（TROUBLE のリンク先：#about）
         ・背景：img/implant-lp-about-bg.webp
    ========================================= -->
    <?php
    $ilp_about_qa = array(
        array('q' => 'どんな構造をしているの？', 'a' => '骨に埋め込む「インプラント体」、歯ぐきの上の人工歯（上部構造）、両者をつなぐ「アバットメント」から構成されます。'),
        array('q' => 'なぜ動かないの？',         'a' => 'チタン製のインプラント体は骨としっかり結合（オッセオインテグレーション）するため、天然歯のように安定します。'),
    );
    $ilp_about_parts = array(
        array('img' => 'implant-lp-about-part01.webp', 'tag' => '保証5年',  'title' => '上部構造（人工歯）',         'text' => '歯の見た目と噛み合わせをつくる部分。セラミックなどから選べます。'),
        array('img' => 'implant-lp-about-part02.webp', 'tag' => '',         'title' => 'アバットメント（連結部）',   'text' => '上部構造とインプラント体をつなぐ土台。噛む力を適切に伝えます。'),
        array('img' => 'implant-lp-about-part03.webp', 'tag' => '保証10年', 'title' => 'インプラント体（人工歯根）', 'text' => 'あごの骨に埋め込み、歯の根の役割を果たすチタン製のねじ。'),
    );
    // 比較表（1つ目の値がインプラント／義歯／ブリッジ の順）
    $ilp_about_compare = array(
        '隣の歯への負担' => array('削らない',   'バネで負担',   '削る必要'),
        '噛む力'         => array('天然歯に近い', '弱い',       'やや強い'),
        '見た目・違和感' => array('自然・少ない', '目立つ場合も', '比較的自然'),
        '治療期間'       => array('やや長い',   '短い',         '短い'),
        '外科処置'       => array('必要',       '不要',         '不要'),
        '費用'           => array('自費',       '保険可',       '保険可'),
    );
    ?>
    <section class="implant-about" id="about" style="--about-bg: url('<?php echo esc_url($ilp_img_dir . 'implant-lp-about-bg.webp'); ?>')">
        <div class="implant-about__inner">
            <div class="implant-about__head">
                <p class="implant-about__chip">お悩み①『ブリッジ・入れ歯と<br class="implant-about__br-sp">何が違うのか分からない』への答え</p>
                <p class="implant-about__en">ABOUT</p>
                <h2 class="implant-about__title">
                    <span class="implant-about__title-main">インプラント治療とは</span>
                    <span class="implant-about__title-sub"><span class="screen-reader-text">｜</span>入れ歯・ブリッジとの違い</span>
                </h2>
                <span class="implant-about__ornament" aria-hidden="true"><span class="implant-about__diamond"></span></span>
            </div>

            <!-- 導入：院長コメント＋動画 -->
            <div class="implant-about__intro">
                <div class="implant-about__intro-text">
                    <h3 class="implant-about__catch">入れ歯やブリッジとは違う、<br>画期的な治療</h3>
                    <div class="implant-about__comment">
                        <figure class="implant-about__doctor">
                            <span class="implant-about__doctor-img" style="background-image: url('<?php echo esc_url($ilp_img_dir . 'implant-lp-doctor01.webp'); ?>')" role="img" aria-label="院長 芳賀浩昭"></span>
                            <figcaption class="implant-about__doctor-name">院長 芳賀 浩昭</figcaption>
                        </figure>
                        <p class="implant-about__bubble">あごの骨に人工歯根を埋め込み、その上に人工歯を装着する治療法です。入れ歯やブリッジと違い、周囲の歯を削ったり負担をかけたりすることなく、天然歯に近い噛み心地と自然な見た目を回復できます。</p>
                    </div>
                </div>

                <figure class="implant-about__video">
                    <?php if ($ilp_about_mp4_url) : ?>
                    <div class="implant-about__video-frame is-movie">
                        <video class="implant-lp-movie" src="<?php echo esc_url($ilp_about_mp4_url); ?>" autoplay muted loop playsinline preload="auto" aria-label="インプラント治療の流れのアニメーション" data-autoplay-video></video>
                    </div>
                    <?php else : ?>
                    <div class="implant-about__video-frame" data-youtube-id="<?php echo esc_attr($ilp_about_video_id); ?>" data-video-title="インプラント治療とは（YouTube）">
                        <?php if ($ilp_about_thumb_url) : ?>
                            <img class="implant-about__video-thumb" src="<?php echo esc_url($ilp_about_thumb_url); ?>" alt="" width="640" height="360" loading="lazy">
                        <?php endif; ?>
                        <button type="button" class="implant-about__video-play" data-video-play aria-label="動画「インプラント治療とは」を再生する"<?php echo $ilp_about_video_id ? '' : ' disabled'; ?>>
                            <span class="implant-about__video-play-icon" aria-hidden="true"></span>
                        </button>
                    </div>
                    <?php endif; ?>
                    <figcaption class="implant-about__video-caption"><span class="implant-about__video-caption-icon" aria-hidden="true"></span>動画：インプラント治療とは<?php echo $ilp_about_mp4_url ? '' : '（YouTube）'; ?></figcaption>
                </figure>
            </div>

            <!-- インプラント治療の仕組み -->
            <div class="implant-about__block">
                <h3 class="implant-about__h3">インプラント治療の仕組み</h3>
                <div class="implant-about__structure">
                    <figure class="implant-about__structure-img">
                        <img src="<?php echo esc_url($ilp_img_dir . 'implant-lp-about-structure.webp'); ?>" alt="インプラントの構造：上部構造、アバットメント、歯ぐき、インプラント体、あごの骨" width="960" height="800" loading="lazy">
                    </figure>
                    <div class="implant-about__qa">
                        <?php foreach ($ilp_about_qa as $qa) : ?>
                            <div class="implant-about__qa-item">
                                <h4 class="implant-about__q"><span class="implant-about__q-mark" aria-hidden="true">Q</span><?php echo esc_html($qa['q']); ?></h4>
                                <p class="implant-about__a"><?php echo esc_html($qa['a']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <ul class="implant-about__parts">
                    <?php foreach ($ilp_about_parts as $part) : ?>
                        <li class="implant-about__part">
                            <img class="implant-about__part-img" src="<?php echo esc_url($ilp_img_dir . $part['img']); ?>" alt="" width="84" height="84" loading="lazy">
                            <div class="implant-about__part-body">
                                <?php if ($part['tag']) : ?><span class="implant-about__part-tag"><?php echo esc_html($part['tag']); ?></span><?php endif; ?>
                                <p class="implant-about__part-title"><?php echo esc_html($part['title']); ?></p>
                                <p class="implant-about__part-text"><?php echo esc_html($part['text']); ?></p>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- 比較表 -->
            <div class="implant-about__block implant-about__block--compare">
                <h3 class="implant-about__h3">インプラント・義歯・ブリッジ 比較</h3>
                <div class="implant-about__table-wrap">
                    <table class="implant-about__table">
                        <thead>
                            <tr>
                                <td></td>
                                <th scope="col" class="is-implant"><span><img src="<?php echo esc_url($ilp_img_dir . 'implant-lp-about-icon-implant.webp'); ?>" alt="" width="22" height="22">インプラント</span></th>
                                <th scope="col"><span><img src="<?php echo esc_url($ilp_img_dir . 'implant-lp-about-icon-denture.webp'); ?>" alt="" width="22" height="22">義歯</span></th>
                                <th scope="col"><span><img src="<?php echo esc_url($ilp_img_dir . 'implant-lp-about-icon-bridge.webp'); ?>" alt="" width="22" height="22">ブリッジ</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ilp_about_compare as $label => $vals) : ?>
                                <tr>
                                    <th scope="row"><?php echo esc_html($label); ?></th>
                                    <?php foreach ($vals as $i => $val) : ?>
                                        <td<?php echo $i === 0 ? ' class="is-implant"' : ''; ?>><?php echo esc_html($val); ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================
         ISSUE（ですが、ひとつの課題があります。）
         ・ABOUT の続き（構成メモの「課題提起ブロック」）
         ・背景：img/implant-lp-issue-bg.webp
         ・アイコン：img/implant-lp-issue-icon01〜03.webp
    ========================================= -->
    <?php
    $ilp_issue_items = array(
        array('icon' => 'implant-lp-issue-icon01.webp', 'w' => 56, 'h' => 53, 'title' => '通院が続けられない',                   'text' => '体力の低下や寝たきりで、メンテナンスのための通院が困難に。せっかく入れたインプラントも、ケアが途絶えてしまいます。'),
        array('icon' => 'implant-lp-issue-icon02.webp', 'w' => 72, 'h' => 61, 'title' => '外してケアできる歯科衛生士が少ない', 'text' => '上部構造を取り外して清掃・管理できる歯科衛生士（DH）は限られ、適切なメンテナンスを受けにくいのが実情です。'),
        array('icon' => 'implant-lp-issue-icon03.webp', 'w' => 65, 'h' => 66, 'title' => 'そもそも“外せない”設計も',           'text' => 'インプラントの種類や固定方法によっては上部構造を外せず、汚れが溜まっても十分に対応できないことがあります。'),
    );
    ?>
    <section class="implant-issue" id="issue" aria-labelledby="implant-issue-title" style="--issue-bg: url('<?php echo esc_url($ilp_img_dir . 'implant-lp-issue-bg.webp'); ?>')">
        <div class="implant-issue__inner">
            <p class="implant-issue__point">
                <span class="implant-issue__point-label">POINT</span>
                <span class="implant-issue__point-text">インプラントは見た目も自然で、天然歯に近い感覚で噛める治療です。</span>
            </p>

            <div class="implant-issue__box">
                <h2 class="implant-issue__title" id="implant-issue-title">ですが、<br class="implant-issue__br-sp">ひとつの課題があります。</h2>
                <p class="implant-issue__text">インプラントは入れ歯と違い固定式で取り外せないため、その分ご自身でのセルフケアが難しく、<br class="implant-issue__br-pc">歯科医院での定期的なプロフェッショナルケア（専門的なメンテナンス）が欠かせません。</p>
                <p class="implant-issue__catch">そのため、通院が難しくなるご高齢の方のインプラント治療は、<br class="implant-issue__br-pc"><span class="implant-issue__catch-gold">“その後”を問題視されること</span>も――。</p>
            </div>

            <ol class="implant-issue__list">
                <?php foreach ($ilp_issue_items as $i => $item) : ?>
                    <li class="implant-issue__item">
                        <span class="implant-issue__icon"><img src="<?php echo esc_url($ilp_img_dir . $item['icon']); ?>" alt="" width="<?php echo (int) $item['w']; ?>" height="<?php echo (int) $item['h']; ?>" loading="lazy"></span>
                        <span class="implant-issue__label">問題<span class="implant-issue__num"><?php echo esc_html(sprintf('%02d', $i + 1)); ?></span></span>
                        <h3 class="implant-issue__item-title"><?php echo esc_html($item['title']); ?></h3>
                        <p class="implant-issue__item-text"><?php echo esc_html($item['text']); ?></p>
                    </li>
                <?php endforeach; ?>
            </ol>

            <div class="implant-issue__warning">
                <span class="implant-issue__warning-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" width="24" height="24" focusable="false"><path d="M12 3.5 21.5 20h-19Z" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/><path d="M12 9.5v5.2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><circle cx="12" cy="17.3" r="0.95" fill="currentColor"/></svg>
                </span>
                <p class="implant-issue__warning-body">
                    <span class="implant-issue__warning-label">放置すると…</span>
                    <span class="implant-issue__warning-text">結果、<span class="implant-issue__warning-gold">インプラント周囲炎</span>などで、<br class="implant-issue__br-sp">せっかくのインプラントを<br class="implant-issue__br-sp">失うことも。</span>
                </p>
            </div>

            <span class="implant-issue__arrow" aria-hidden="true"></span>
        </div>
    </section>

    <!-- ========================================
         THE PROBLEM（高齢者のインプラント治療で“その後”が問題になる理由）
         ・お悩み②の答え（TROUBLE のリンク先：#problem）
         ・グラフは画像ではなく HTML＋CSS で作っています（数値は $ilp_problem_data で変更）
    ========================================= -->
    <?php
    // 年代別のインプラント装着者の割合（％）。バーの長さは $ilp_problem_max を100%として計算
    $ilp_problem_data = array(
        array('label' => '65〜69歳', 'value' => 4.6, 'top' => true),
        array('label' => '70〜74歳', 'value' => 3.7, 'top' => false),
        array('label' => '75〜79歳', 'value' => 3.4, 'top' => false),
    );
    $ilp_problem_max = 5;
    $ilp_problem_source_url = 'https://www.mhlw.go.jp/toukei/list/62-28.html'; // ← 参照元のURL（必要に応じて変更）
    ?>
    <section class="implant-problem" id="problem">
        <div class="implant-problem__inner">
            <div class="implant-problem__head">
                <p class="implant-problem__chip">お悩み②『高齢だけど、治療しても<br class="implant-problem__br-sp">続けられるか不安』への答え</p>
                <p class="implant-problem__en">THE PROBLEM</p>
                <h2 class="implant-problem__title">
                    <span class="implant-problem__title-main">高齢者のインプラント治療で<br class="implant-problem__br-sp">“その後”が問題になる理由</span>
                    <span class="implant-problem__ornament" aria-hidden="true"><span class="implant-problem__diamond"></span></span>
                    <span class="implant-problem__sub">「入れて終わり」にしないために。</span>
                </h2>
            </div>

            <div class="implant-problem__main">
                <figure class="implant-problem__video">
                    <div class="implant-problem__video-frame" data-youtube-id="<?php echo esc_attr($ilp_problem_video_id); ?>" data-video-title="介護 × インプラント（YouTube）">
                        <?php if ($ilp_problem_thumb_url) : ?>
                            <img class="implant-problem__video-thumb" src="<?php echo esc_url($ilp_problem_thumb_url); ?>" alt="" width="640" height="360" loading="lazy">
                        <?php endif; ?>
                        <button type="button" class="implant-problem__video-play" data-video-play aria-label="動画「介護 × インプラント」を再生する"<?php echo $ilp_problem_video_id ? '' : ' disabled'; ?>>
                            <span class="implant-problem__video-play-icon" aria-hidden="true"></span>
                        </button>
                    </div>
                    <figcaption class="implant-problem__video-caption"><span class="implant-problem__video-caption-icon" aria-hidden="true"></span>介護 × インプラント（YouTube）</figcaption>
                </figure>

                <div class="implant-problem__body">
                    <h3 class="implant-problem__h3">介護とインプラント、その先のケア</h3>
                    <div class="implant-problem__comment">
                        <p class="implant-problem__bubble">インプラントは、埋め込んだら終わりではありません。長く快適に使うには、生涯にわたる専門的なメンテナンスが必要です。ところが、ご高齢になるほど、その“続けること”が難しくなります。</p>
                        <figure class="implant-problem__doctor">
                            <span class="implant-problem__doctor-img" style="background-image: url('<?php echo esc_url($ilp_img_dir . 'implant-lp-doctor01.webp'); ?>')" role="img" aria-label="院長 芳賀浩昭"></span>
                            <figcaption class="implant-problem__doctor-name">院長 芳賀 浩昭</figcaption>
                        </figure>
                    </div>
                </div>
            </div>

            <!-- DATA -->
            <div class="implant-problem__data">
                <div class="implant-problem__data-text">
                    <p class="implant-problem__data-head"><span class="implant-problem__data-label" aria-hidden="true">DATA</span>厚生労働省 調査</p>
                    <p class="implant-problem__data-desc">厚生労働省の「平成28年 歯科疾患実態調査」によると、インプラント装着者の割合が最も多いのは「65〜69歳」で4.6%。次いで「70〜74歳」3.7%、「75〜79歳」3.4%と、上位3つの年代をすべて高齢者が占めています。</p>
                    <p class="implant-problem__data-catch">つまり、<span class="implant-problem__marker">准高齢者（65〜74歳）・高齢者（75〜89歳）の方も、</span><br><span class="implant-problem__marker">年齢にかかわらずインプラント治療を受けられる</span>といえます。</p>
                    <a class="implant-problem__data-source" href="<?php echo esc_url($ilp_problem_source_url); ?>" target="_blank" rel="noopener noreferrer">参照元：平成28年 歯科疾患実態調査（厚生労働省）<svg viewBox="0 0 16 16" width="14" height="14" aria-hidden="true" focusable="false"><path d="M9 2.5h4.5V7M13.5 2.5 7.5 8.5M11.5 9.5v4h-9v-9h4" fill="none" stroke="currentColor" stroke-width="1.2"/></svg><span class="screen-reader-text">（別タブで開きます）</span></a>
                </div>

                <figure class="implant-problem__chart">
                    <ul class="implant-problem__bars">
                        <?php foreach ($ilp_problem_data as $row) : ?>
                            <li class="implant-problem__bar-row">
                                <span class="implant-problem__bar-label"><?php echo esc_html($row['label']); ?></span>
                                <span class="implant-problem__bar<?php echo $row['top'] ? ' is-top' : ''; ?>" style="--bar: <?php echo esc_attr(round($row['value'] / $ilp_problem_max * 100, 1)); ?>%" aria-hidden="true"></span>
                                <span class="implant-problem__bar-value"><?php echo esc_html($row['value']); ?><small>%</small></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <figcaption class="implant-problem__chart-caption">インプラント装着者の割合（年代別・上位3）</figcaption>
                </figure>
            </div>
        </div>
    </section>

    <!-- ========================================
         SOLUTION（人生100年時代、最期まで診続けるために、当院は、“入れた先”までサポートします。）
         ・THE PROBLEM の続き（構成メモ：当院の解決＝小見出し H3）
         ・写真：img/implant-lp-solution01〜03.webp
    ========================================= -->
    <?php
    // title：PC用／title_sp：SP用（空ならPCと同じ）
    $ilp_solution_items = array(
        array('img' => 'implant-lp-solution01.webp', 'alt' => 'ストローマン社製のインプラント', 'badge' => '',         'title' => 'Straumann<sup>®</sup><small>（ストローマン）</small>社製<br>インプラントシステムを使用', 'title_sp' => 'Straumann<sup>®</sup>社製<br>インプラントシステム', 'text' => 'スイスで開発され、長年にわたる臨床データが蓄積されたインプラントシステムです。部品の供給が安定しているため、10年20年と使い続けるあいだにメンテナンスや部品交換が必要になったときにも対応しやすくなります。'),
        array('img' => 'implant-lp-solution02.webp', 'alt' => '訪問先で歯科衛生士が口腔ケアをしている様子',   'badge' => '',         'title' => '“生涯ケアしやすい”設計で',                    'title_sp' => '', 'text' => '必要に応じて取り外せる設計（スクリュー固定など）を選択。上部構造を外して清掃・点検できます。'),
        array('img' => 'implant-lp-solution03.webp', 'alt' => 'ベッドの上で口腔ケアを受けている様子',         'badge' => '最大の特長', 'title' => '訪問診療で、<br>通えなくてもケアが続く', 'title_sp' => '', 'text' => '訪問診療部を備え、ご自宅や施設でもメンテナンスを継続。通院が難しくなっても、口腔ケアをお届けします。'),
    );
    // タイトルで使ってよいタグ（® の上付き・小さい文字・改行）
    $ilp_solution_allowed = array('sup' => array(), 'small' => array(), 'br' => array());
    ?>
    <section class="implant-solution" id="solution" aria-labelledby="implant-solution-title">
        <div class="implant-solution__inner">
            <h2 class="implant-solution__title" id="implant-solution-title">人生100年時代、最期まで<br class="implant-solution__br-sp">診続けるために、<br class="implant-solution__br-pc">当院は、<br class="implant-solution__br-sp"><span class="implant-solution__title-gold">“入れた先”<span class="implant-solution__title-gold-pc">まで</span></span>サポートします。</h2>
            <span class="implant-solution__ornament" aria-hidden="true"><span class="implant-solution__diamond"></span></span>

            <?php /* PC：写真が上の段、カードが下の段に並ぶ／SP：写真が左、文が右の横長カード */ ?>
            <ol class="implant-solution__list">
                <?php foreach ($ilp_solution_items as $i => $item) : ?>
                    <li class="implant-solution__item">
                        <img class="implant-solution__photo" src="<?php echo esc_url($ilp_img_dir . $item['img']); ?>" alt="<?php echo esc_attr($item['alt']); ?>" width="694" height="518" loading="lazy">
                        <div class="implant-solution__card">
                            <p class="implant-solution__label">
                                <span class="implant-solution__check" aria-hidden="true"></span>
                                <span class="implant-solution__label-text">当院の解決 <?php echo esc_html(sprintf('%02d', $i + 1)); ?></span>
                                <?php if ($item['badge']) : ?><span class="implant-solution__badge"><?php echo esc_html($item['badge']); ?></span><?php endif; ?>
                            </p>
                            <h3 class="implant-solution__item-title">
                                <?php if ($item['title_sp']) : ?>
                                    <span class="implant-solution__pc"><?php echo wp_kses($item['title'], $ilp_solution_allowed); ?></span>
                                    <span class="implant-solution__sp"><?php echo wp_kses($item['title_sp'], $ilp_solution_allowed); ?></span>
                                <?php else : ?>
                                    <?php echo wp_kses($item['title'], $ilp_solution_allowed); ?>
                                <?php endif; ?>
                            </h3>
                            <p class="implant-solution__item-text"><?php echo esc_html($item['text']); ?></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </section>

    <!-- ========================================
         ESTHETIC（“入れた”とわからない、自然な見た目へ）
         ・お悩み③の答え（TROUBLE のリンク先：#esthetic）
         ・症例はスライダー（$ilp_cases に1件ずつ追加。2件以上で矢印・ドットが表示されます）
         ・医療広告ガイドラインにより、症例には治療内容・期間・費用・リスクを必ず併記してください
    ========================================= -->
    <?php
    // 笑顔の写真（img/implant-lp-esthetic-smile.webp を入れると表示。無いあいだはグレーの仮枠）
    $ilp_esthetic_smile = file_exists($ilp_img_path . 'implant-lp-esthetic-smile.webp');

    $ilp_cases = array(
        array(
            'before' => 'implant-lp-case01-before.webp',
            'after'  => 'implant-lp-case01-after.webp',
            'title'  => '症例：スポーツ外傷で前歯を失ったケース（治療後 約12年経過）',  // 症例が1件だけなので番号なし（2件以上になったら「症例1：」に戻してください）
            'rows'   => array(
                '主訴'     => '前歯が折れた（30代・男性／スポーツ中の事故で左上前歯1本を破折・抜歯）',
                '治療内容' => '抜歯→コンピューター上で治療計画立案・ガイド作製→インプラント体の埋入→型取り→上部構造の装着',
                '治療期間' => '約9ヶ月（治療後 約12年、問題なく機能しています）',
                '治療費'   => '478,000円（税別・治療当時の費用）',
                '内訳'     => '抜歯 8,000円／インプラント埋入 260,000円／ガイドサージェリー 50,000円／上部構造 160,000円（税別）',
            ),
            'note'   => '※ 主なリスク・副作用：術後の疼痛、歯肉の発赤・腫脹、神経損傷。経過には個人差があり、同様の結果を保証するものではありません。自由診療（保険適用外）です。費用は治療当時のもので、現在の料金は料金表をご確認ください。',
        ),
        // ▼ 仮の症例（非表示中）
        //   実際の症例が届いたら、下の /* と */ を消して、写真のファイル名と文章を書き換えてください
        //   （症例が2件以上になると、矢印・ドットが自動で表示されます）
        /*
        array(
            'before' => 'implant-lp-case02-before.webp',
            'after'  => 'implant-lp-case02-after.webp',
            'title'  => '症例2：（仮）症例のタイトルが入ります',
            'rows'   => array(
                '主訴'     => '（仮）主訴が入ります（年代・性別／お悩みの内容）',
                '治療内容' => '（仮）治療内容が入ります',
                '治療期間' => '（仮）治療期間が入ります',
                '治療費'   => '（仮）治療費が入ります',
                '内訳'     => '（仮）費用の内訳が入ります',
            ),
            'note'   => '※ （仮）主なリスク・副作用が入ります。経過には個人差があり、同様の結果を保証するものではありません。自由診療（保険適用外）です。',
        ),
        array(
            'before' => 'implant-lp-case03-before.webp',
            'after'  => 'implant-lp-case03-after.webp',
            'title'  => '症例3：（仮）症例のタイトルが入ります',
            'rows'   => array(
                '主訴'     => '（仮）主訴が入ります（年代・性別／お悩みの内容）',
                '治療内容' => '（仮）治療内容が入ります',
                '治療期間' => '（仮）治療期間が入ります',
                '治療費'   => '（仮）治療費が入ります',
                '内訳'     => '（仮）費用の内訳が入ります',
            ),
            'note'   => '※ （仮）主なリスク・副作用が入ります。経過には個人差があり、同様の結果を保証するものではありません。自由診療（保険適用外）です。',
        ),
        */
    );

    $ilp_esthetic_items = array(
        array('img' => 'implant-lp-esthetic01.webp', 'w' => 840, 'h' => 480, 'alt' => 'ストローマンガイド（サージカルガイド）のイメージ', 'caption' => '', 'caption_sp' => '神経の位置まで3Dで確認し、深さと角度を決定', 'title' => 'サージカルガイドで、理想の位置・角度に埋入',                 'text' => 'CT撮影のデータ上で埋入する位置・角度・深さを設計し、その設計を再現するサージカルガイドを装着して手術します。歯ぐきからの立ち上がりが自然になり、見た目と噛み合わせを計画どおりに仕上げられます。'),
        array('img' => 'implant-lp-esthetic02.webp', 'w' => 840, 'h' => 424, 'alt' => 'CT・口腔内データを使った設計画面',                 'caption' => 'CT・口腔内データ上で設計を詰めていく', 'caption_sp' => '', 'title' => '審美治療のDX化で、色も形も周りの歯に合わせる',               'text' => '口腔内スキャナーでデジタルの歯型をとり、審美専門の歯科技工士が立ち会って歯の色や形を確認しながら製作。周囲の天然歯になじむ被せ物に仕上げます。'),
        // 03 ストローマンは「人生100年時代〜」セクションと内容が重なるため非表示（2026-11-26 指示）
        // array('img' => 'implant-lp-esthetic03.webp', 'w' => 840, 'h' => 424, 'alt' => 'ストローマン製インプラントとアバットメント',       'caption' => 'ロット番号と“S”マークで、使用した部品を個別に管理', 'caption_sp' => '', 'title' => 'Straumann<sup>®</sup>（ストローマン）社製インプラントシステムを使用', 'text' => 'スイスで開発され、長年にわたる臨床データが蓄積されたインプラントシステムです。部品の供給が安定しているため、10年20年と使い続けるあいだにメンテナンスや部品交換が必要になったときにも対応しやすくなります。'),
    );
    ?>
    <section class="implant-esthetic" id="esthetic">
        <div class="implant-esthetic__inner">
            <div class="implant-esthetic__head">
                <p class="implant-esthetic__chip">お悩み③『見た目に違和感が<br class="implant-esthetic__br-sp">ないか気になる』への答え</p>
                <p class="implant-esthetic__en">ESTHETIC</p>
                <h2 class="implant-esthetic__title">
                    <span class="implant-esthetic__title-main">“入れた”とわからない、<br class="implant-esthetic__br-sp">自然な見た目へ</span>
                </h2>
                <span class="implant-esthetic__ornament" aria-hidden="true"><span class="implant-esthetic__diamond"></span></span>
            </div>

            <!-- 導入：笑顔の写真＋院長コメント -->
            <div class="implant-esthetic__intro">
                <figure class="implant-esthetic__smile<?php echo $ilp_esthetic_smile ? ' has-img' : ''; ?>">
                    <?php if ($ilp_esthetic_smile) : ?>
                        <img src="<?php echo esc_url($ilp_img_dir . 'implant-lp-esthetic-smile.webp'); ?>" alt="治療後の患者様の笑顔（イメージ）" width="880" height="496" loading="lazy">
                        <figcaption class="implant-esthetic__smile-note">※写真はイメージです</figcaption>
                    <?php else : ?>
                        <p class="implant-esthetic__placeholder">笑顔の写真<br>（治療後の患者様イメージ）</p>
                    <?php endif; ?>
                </figure>
                <div class="implant-esthetic__intro-body">
                    <h3 class="implant-esthetic__catch">10年、20年と使い続けるものだから、<br>自然に、美しく。</h3>
                    <div class="implant-esthetic__comment">
                        <p class="implant-esthetic__bubble">見た目の自然さは、「どこに埋めるか」と「何をかぶせるか」で決まります。当院はその両方をデジタルで設計し、感覚に頼らない仕上がりを目指します。</p>
                        <figure class="implant-esthetic__doctor">
                            <span class="implant-esthetic__doctor-img" style="background-image: url('<?php echo esc_url($ilp_img_dir . 'implant-lp-doctor01.webp'); ?>')" role="img" aria-label="院長 芳賀浩昭"></span>
                            <figcaption class="implant-esthetic__doctor-name">院長 芳賀 浩昭</figcaption>
                        </figure>
                    </div>
                </div>
            </div>

            <!-- 症例（BEFORE / AFTER スライダー） -->
            <div class="implant-esthetic__case" data-case-slider>
                <div class="implant-esthetic__case-track">
                    <?php foreach ($ilp_cases as $ci => $case) : ?>
                        <article class="implant-esthetic__case-slide<?php echo $ci === 0 ? ' is-active' : ''; ?>"<?php echo $ci === 0 ? '' : ' hidden'; ?>>
                            <div class="implant-esthetic__case-photos">
                                <figure class="implant-esthetic__case-photo">
                                    <span class="implant-esthetic__case-tag" aria-hidden="true">BEFORE</span>
                                    <figcaption class="screen-reader-text">治療前</figcaption>
                                    <?php if (file_exists($ilp_img_path . $case['before'])) : ?>
                                        <img src="<?php echo esc_url($ilp_img_dir . $case['before']); ?>" alt="治療前" width="904" height="436" loading="lazy">
                                    <?php else : ?>
                                        <span class="implant-esthetic__case-placeholder">BEFORE の写真</span>
                                    <?php endif; ?>
                                </figure>
                                <span class="implant-esthetic__case-arrow" aria-hidden="true"></span>
                                <figure class="implant-esthetic__case-photo">
                                    <span class="implant-esthetic__case-tag implant-esthetic__case-tag--after" aria-hidden="true">AFTER</span>
                                    <figcaption class="screen-reader-text">治療後</figcaption>
                                    <?php if (file_exists($ilp_img_path . $case['after'])) : ?>
                                        <img src="<?php echo esc_url($ilp_img_dir . $case['after']); ?>" alt="治療後" width="904" height="436" loading="lazy">
                                    <?php else : ?>
                                        <span class="implant-esthetic__case-placeholder">AFTER の写真</span>
                                    <?php endif; ?>
                                </figure>
                            </div>
                            <h3 class="implant-esthetic__case-title"><?php echo esc_html($case['title']); ?></h3>
                            <dl class="implant-esthetic__case-data">
                                <?php foreach ($case['rows'] as $dt => $dd) : ?>
                                    <div><dt><?php echo esc_html($dt); ?></dt><dd><?php echo esc_html($dd); ?></dd></div>
                                <?php endforeach; ?>
                            </dl>
                            <p class="implant-esthetic__case-note"><small><?php echo esc_html($case['note']); ?></small></p>
                        </article>
                    <?php endforeach; ?>
                </div>

                <?php if (count($ilp_cases) > 1) : ?>
                    <div class="implant-esthetic__case-nav">
                        <button type="button" class="implant-esthetic__case-btn implant-esthetic__case-btn--prev" data-case-prev aria-label="前の症例"></button>
                        <button type="button" class="implant-esthetic__case-btn" data-case-next aria-label="次の症例"></button>
                    </div>
                    <div class="implant-esthetic__case-dots">
                        <?php foreach ($ilp_cases as $ci => $case) : ?>
                            <button type="button" class="implant-esthetic__case-dot<?php echo $ci === 0 ? ' is-active' : ''; ?>" data-case-dot="<?php echo esc_attr($ci); ?>" aria-label="症例<?php echo esc_attr($ci + 1); ?>を表示"<?php echo $ci === 0 ? ' aria-current="true"' : ''; ?>></button>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- 01〜03 -->
            <div class="implant-esthetic__features">
                <?php foreach ($ilp_esthetic_items as $i => $item) : ?>
                    <div class="implant-esthetic__feature<?php echo $i % 2 ? ' is-reverse' : ''; ?>">
                        <figure class="implant-esthetic__feature-media">
                            <img src="<?php echo esc_url($ilp_img_dir . $item['img']); ?>" alt="<?php echo esc_attr($item['alt']); ?>" width="<?php echo esc_attr($item['w']); ?>" height="<?php echo esc_attr($item['h']); ?>" loading="lazy">
                            <?php if ($item['caption']) : ?>
                                <figcaption><?php echo esc_html($item['caption']); ?></figcaption>
                            <?php elseif ($item['caption_sp']) : ?>
                                <figcaption class="is-sp-only"><?php echo esc_html($item['caption_sp']); ?></figcaption>
                            <?php endif; ?>
                        </figure>
                        <div class="implant-esthetic__feature-body">
                            <span class="implant-esthetic__feature-num" aria-hidden="true"><?php echo esc_html(sprintf('%02d', $i + 1)); ?></span>
                            <h3 class="implant-esthetic__feature-title"><?php echo wp_kses($item['title'], array('sup' => array())); ?></h3>
                            <p class="implant-esthetic__feature-text"><?php echo esc_html($item['text']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php /* まとめ：「どこに埋めるか × 何をかぶせるか」の図＋一文（PCは改行なしで横長／SPは改行あり）。上の1文は読み上げ用で見た目は隠す */ ?>
                <div class="implant-esthetic__summary">
                    <p class="implant-esthetic__summary-pc">「どこに埋めるか」はサージカルガイドで、「何をかぶせるか」は審美のデジタル設計で。“入れた”とわからない仕上がりを目指します。</p>
                    <div class="implant-esthetic__summary-sp" aria-hidden="true">
                        <div class="implant-esthetic__summary-pair">
                            <p class="implant-esthetic__summary-box"><span>どこに埋めるか</span>サージカル<br class="implant-esthetic__br-sp">ガイド</p>
                            <span class="implant-esthetic__summary-x">×</span>
                            <p class="implant-esthetic__summary-box"><span>何をかぶせるか</span>審美の<br class="implant-esthetic__br-sp">デジタル設計</p>
                        </div>
                        <p class="implant-esthetic__summary-text">“入れた”とわからない<br class="implant-esthetic__br-sp">仕上がりを目指します。</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================
         CONSULT（他院で「難しい」と断られた方のインプラント〜骨造成・難症例対応〜）
         ・お悩み④の答え（TROUBLE のリンク先：#consult）
    ========================================= -->
    <?php
    $ilp_consult_methods = array(
        array('img' => 'implant-lp-consult01.webp', 'for' => '骨があと少し足りないと言われた方へ',                 'title' => 'ソケットリフト',                         'text' => '上顎洞の底をやさしく押し上げ、少量の骨を造成。インプラント埋入と同時に行えます。',               'merit' => '体への負担が少なく、比較的短期間。少しの骨不足に対応できます。'),
        array('img' => 'implant-lp-consult02.webp', 'for' => '骨の幅や高さが足りないと言われた方へ',               'title' => 'GBR法（骨誘導再生療法）',                'text' => '骨が痩せた部分に、人工膜と骨補填材を用いて骨の再生を促す方法です。',                             'merit' => '幅・高さの不足を補い、見た目にも良い位置にインプラントを埋入できます。'),
        array('img' => 'implant-lp-consult03.webp', 'for' => '抜歯後は骨が安定するまで待つ必要があると言われた方へ', 'title' => '即時埋入',                               'text' => '抜歯と同時にインプラントを埋入する方法です。条件が整えば、手術回数や通院回数、治療期間を抑えられます。', 'merit' => '抜歯後すぐに対応でき、歯ぐきや骨の形を保ちやすく、仮歯で見た目も維持しやすくなります。'),
        array('img' => 'implant-lp-consult04.webp', 'for' => '総入れ歯が合わない・外れると言われた方へ',           'title' => 'インプラント義歯（オーバーデンチャー）', 'text' => '数本のインプラントで入れ歯を固定・安定させる方法です。',                                         'merit' => '外れにくく安定。取り外して清掃でき、生涯のメンテナンスがしやすい。'),
    );
    $ilp_consult_diseases = array(
        array('icon' => 'implant-lp-consult-icon01.webp', 'label' => '高血圧'),
        array('icon' => 'implant-lp-consult-icon02.webp', 'label' => '糖尿病'),
        array('icon' => 'implant-lp-consult-icon03.webp', 'label' => '血液をサラサラにする薬'),
        array('icon' => 'implant-lp-consult-icon04.webp', 'label' => '骨粗鬆症・がん転移予防薬'),
    );
    ?>
    <section class="implant-consult" id="consult">
        <div class="implant-consult__inner">
            <div class="implant-consult__head">
                <p class="implant-consult__chip">お悩み④『他院で難しいと<br class="implant-consult__br-sp">断られた』への答え</p>
                <p class="implant-consult__en">CONSULT</p>
                <h2 class="implant-consult__title">
                    <span class="implant-consult__title-main">他院で「難しい」と<br class="implant-consult__br-sp">断られた方のインプラント</span>
                    <span class="implant-consult__title-sub">〜骨造成・難症例対応〜</span>
                </h2>
                <span class="implant-consult__ornament" aria-hidden="true"><span class="implant-consult__diamond"></span></span>
                <h3 class="implant-consult__catch">「難しい」と言われた方も、ご相談ください</h3>
            </div>

            <div class="implant-consult__comment">
                <figure class="implant-consult__avatar">
                    <span class="implant-consult__avatar-img" style="background-image: url('<?php echo esc_url($ilp_img_dir . 'implant-lp-doctor01.webp'); ?>')" role="img" aria-label="院長 芳賀浩昭"></span>
                    <figcaption class="implant-consult__avatar-name">院長 芳賀 浩昭</figcaption>
                </figure>
                <p class="implant-consult__bubble">“骨が足りない”と言われた方でも、骨造成や埋入方法の工夫で対応できることがあります。まずは診断させてください。</p>
            </div>

            <!-- 治療法 4つ -->
            <ul class="implant-consult__methods">
                <?php foreach ($ilp_consult_methods as $m) : ?>
                    <li class="implant-consult__method">
                        <img class="implant-consult__method-img" src="<?php echo esc_url($ilp_img_dir . $m['img']); ?>" alt="" width="1060" height="236" loading="lazy">
                        <div class="implant-consult__method-body">
                            <p class="implant-consult__for"><span class="implant-consult__for-tag">こんな方へ</span><?php echo esc_html($m['for']); ?></p>
                            <h4 class="implant-consult__method-title"><?php echo esc_html($m['title']); ?></h4>
                            <p class="implant-consult__method-text"><?php echo esc_html($m['text']); ?></p>
                            <p class="implant-consult__merit"><span class="implant-consult__merit-label"><span class="implant-consult__check" aria-hidden="true"></span>メリット</span><span class="implant-consult__merit-text"><?php echo esc_html($m['merit']); ?></span></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>

            <!-- 全身疾患 -->
            <div class="implant-consult__disease">
                <h3 class="implant-consult__h3">全身疾患をお持ちの方も、ご相談ください</h3>
                <p class="implant-consult__h3-sub">主治医と連携のうえ、安全に配慮して対応します。</p>
                <ul class="implant-consult__disease-list">
                    <?php foreach ($ilp_consult_diseases as $d) : ?>
                        <li class="implant-consult__disease-item">
                            <span class="implant-consult__disease-icon"><img src="<?php echo esc_url($ilp_img_dir . $d['icon']); ?>" alt="" width="26" height="26" loading="lazy"></span>
                            <span class="implant-consult__disease-label"><?php echo esc_html($d['label']); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- 担当医 -->
            <div class="implant-consult__doctor">
                <figure class="implant-consult__doctor-photo">
                    <img src="<?php echo esc_url($ilp_img_dir . 'implant-lp-consult-doctor.webp'); ?>" alt="院長 芳賀浩昭" width="600" height="720" loading="lazy">
                </figure>
                <div class="implant-consult__doctor-body">
                    <p class="implant-consult__doctor-head"><span class="implant-consult__doctor-label">DOCTOR</span>担当医</p>
                    <p class="implant-consult__school"><img src="<?php echo esc_url($ilp_img_dir . 'implant-lp-consult-icon-school.webp'); ?>" alt="" width="20" height="20" loading="lazy">東京医科歯科大学 出身</p>
                    <p class="implant-consult__name">院長 芳賀 浩昭<span class="implant-consult__kana">（はが ひろあき）</span></p>
                    <p class="implant-consult__cred">歯学博士 / 日本口腔インプラント学会認定 口腔インプラント専門医</p>
                    <p class="implant-consult__doctor-catch">「医科歯科連携」で、全身疾患のある方も安心。</p>
                    <p class="implant-consult__doctor-text">東京医科歯科大学で研鑽を積み、医科（内科・外科）と歯科をまたいだ視点を持つ院長が担当します。高血圧・糖尿病など全身疾患をお持ちの方も、必要に応じて主治医や医科と連携しながら、お身体の状態に配慮して安全にインプラント治療を進められるのが当院の強みです。</p>
                    <div class="implant-consult__partner">
                        <span class="implant-consult__partner-icon"><img src="<?php echo esc_url($ilp_img_dir . 'implant-lp-consult-icon-hospital.webp'); ?>" alt="" width="22" height="22" loading="lazy"></span>
                        <div>
                            <p class="implant-consult__partner-title">連携医療機関</p>
                            <p class="implant-consult__partner-text">東京医科歯科大学・慶應義塾大学・神奈川歯科大学 等と連携（本院ではなく連携医療機関）。必要に応じて専門機関をご紹介し、安全に治療を進めます。</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================
         中間CTA（CONTACT：その“難しい”、あきらめる前に。まずはご相談ください。）
         ・中身は上の $ilp_cta（'theme' => 'dark' で紺のデザイン）
    ========================================= -->
    <?php
    $ilp_cta(array(
        'id'         => 'cta-mid',
        'theme'      => 'dark',
        'en'         => 'CONTACT',
        'title'      => 'その“難しい”、<br class="implant-cta__br-sp">あきらめる前に。',
        'title_gold' => 'まずはご相談ください。',
        'mark'       => '',
        'lead'       => '口腔インプラント専門医が、あなたに合った治療法を一緒に考えます。迷っている段階でも大丈夫です。',
        'sp_light'   => true, // SPは明るい背景（見本 2026/11）
    ));
    ?>

    <!-- ========================================
         PREVENTION（インプラントは、残った歯を守る治療）
         ・動画2本（URL が入るまでは枠＋再生ボタンだけ）
    ========================================= -->
    <?php
    // mp4：img フォルダにこのファイルがあれば、自動再生・くり返し再生（音なし）。無いときは youtube を使います
    // youtube：URLを入れると再生できます／thumb：img フォルダにあればサムネイルに使います（無ければ YouTube の画像）
    // text：PC用／text_sp：SP用の短い文
    $ilp_prevention_items = array(
        array('mp4' => 'implant-lp-video-bridge.mp4',  'youtube' => '', 'thumb' => 'implant-lp-prevention-video01.webp', 'video' => 'ブリッジの治療',       'icon' => 'implant-lp-about-icon-bridge.webp',  'mark' => '×', 'title' => 'ブリッジ',     'text' => '両隣の健康な歯を削って土台にします。3本分の力を2本で支えるため負担が集中し、歯を失う連鎖が起きることがあります。', 'text_sp' => '両隣の健康な歯を削って土台に。負担が集中し、歯を失う連鎖が起きることも。', 'highlight' => false),
        array('mp4' => 'implant-lp-video-implant.mp4', 'youtube' => '', 'thumb' => 'implant-lp-prevention-video02.webp', 'video' => 'インプラントの治療', 'icon' => 'implant-lp-about-icon-implant.webp', 'mark' => '○', 'title' => 'インプラント', 'text' => '人工歯根が1本で独立して機能します。両隣の歯を削る必要がなく、残っている歯と噛み合わせを守れます。',               'text_sp' => '1本で独立して機能。両隣の歯を削らず、残っている歯と噛み合わせを守れます。', 'highlight' => true),
    );
    ?>
    <section class="implant-prevention" id="prevention">
        <div class="implant-prevention__inner">
            <div class="implant-prevention__head">
                <p class="implant-prevention__en">PREVENTION</p>
                <h2 class="implant-prevention__title">
                    <span class="implant-prevention__title-main">インプラントは、<br class="implant-prevention__br-sp">残った歯を守る治療</span>
                </h2>
                <span class="implant-prevention__ornament" aria-hidden="true"><span class="implant-prevention__diamond"></span></span>
            </div>

            <div class="implant-prevention__card">
                <?php /* 構成メモより：比較図は <figure>。ラベル（ブリッジ／インプラント）は <figcaption> */ ?>
                <div class="implant-prevention__compare">
                    <?php foreach ($ilp_prevention_items as $item) : ?>
                        <?php
                        $mp4   = $ilp_mp4_url($item['mp4']);
                        $vid   = $ilp_youtube_id($item['youtube']);
                        $thumb = '';
                        if (file_exists($ilp_img_path . $item['thumb'])) {
                            $thumb = $ilp_img_dir . $item['thumb'];
                        } elseif ($vid) {
                            $thumb = 'https://i.ytimg.com/vi/' . $vid . '/hqdefault.jpg';
                        }
                        ?>
                        <figure class="implant-prevention__col<?php echo $item['highlight'] ? ' is-highlight' : ''; ?>">
                            <div class="implant-prevention__video">
                                <?php if ($mp4) : ?>
                                <div class="implant-prevention__video-frame is-movie">
                                    <video class="implant-lp-movie" src="<?php echo esc_url($mp4); ?>" autoplay muted loop playsinline preload="auto" aria-label="<?php echo esc_attr($item['video']); ?>のアニメーション" data-autoplay-video></video>
                                    <p class="implant-prevention__video-caption"><span class="implant-prevention__video-caption-icon" aria-hidden="true"></span>動画：<?php echo esc_html($item['video']); ?></p>
                                </div>
                                <?php else : ?>
                                <div class="implant-prevention__video-frame" data-youtube-id="<?php echo esc_attr($vid); ?>" data-video-title="<?php echo esc_attr($item['video']); ?>（YouTube）">
                                    <?php if ($thumb) : ?>
                                        <img class="implant-prevention__video-thumb" src="<?php echo esc_url($thumb); ?>" alt="" width="640" height="336" loading="lazy">
                                    <?php endif; ?>
                                    <button type="button" class="implant-prevention__video-play" data-video-play aria-label="動画「<?php echo esc_attr($item['video']); ?>」を再生する"<?php echo $vid ? '' : ' disabled'; ?>>
                                        <span class="implant-prevention__video-play-icon" aria-hidden="true"></span>
                                    </button>
                                    <p class="implant-prevention__video-caption"><span class="implant-prevention__video-caption-icon" aria-hidden="true"></span>動画：<?php echo esc_html($item['video']); ?>（YouTube）</p>
                                </div>
                                <?php endif; ?>
                            </div>
                            <figcaption class="implant-prevention__col-body">
                                <span class="implant-prevention__col-title"><img src="<?php echo esc_url($ilp_img_dir . $item['icon']); ?>" alt="" width="24" height="24" loading="lazy"><span class="implant-prevention__mark" aria-hidden="true"><?php echo esc_html($item['mark']); ?></span><?php echo esc_html($item['title']); ?></span>
                                <span class="implant-prevention__col-text">
                                    <span class="implant-prevention__pc"><?php echo esc_html($item['text']); ?></span>
                                    <span class="implant-prevention__sp"><?php echo esc_html($item['text_sp']); ?></span>
                                </span>
                            </figcaption>
                        </figure>
                    <?php endforeach; ?>
                </div>

                <div class="implant-prevention__point-box">
                    <p class="implant-prevention__point"><span class="implant-prevention__point-label" aria-hidden="true">POINT</span><span class="implant-prevention__point-text">インプラント治療は、<br class="implant-prevention__br-sp"><span class="implant-prevention__point-big">“予防歯科”</span>のひとつです。</span></p>
                    <?php /* SPだけの図（失った歯を補う治療 ／ これ以上、歯を失わないための治療）。内容は下の文と同じなので読み上げない */ ?>
                    <div class="implant-prevention__pair" aria-hidden="true">
                        <p class="implant-prevention__pair-box"><span>失った歯を</span>補う治療</p>
                        <p class="implant-prevention__pair-box is-dark"><span>これ以上、歯を</span>失わないための治療</p>
                    </div>
                    <p class="implant-prevention__summary">だから当院は、インプラントを「失った歯を補う治療」であると同時に、「これ以上、歯を失わないための治療」と考えています。</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================
         REASON（富士見台さくら歯科のインプラントが選ばれる理由）
         ・写真：img/implant-lp-reason01〜05.webp（左右交互）
         ・背景：img/implant-lp-reason-bg.webp
    ========================================= -->
    <?php
    $ilp_reasons = array(
        array('img' => 'implant-lp-reason01.webp', 'alt' => '院長が歯科衛生士とともに治療している様子',     'badge' => '',               'title' => '口腔インプラント専門医が“一貫”で担当', 'text' => '診断からインプラント埋入手術、その後のメンテナンスまで。経験豊富な口腔インプラント専門医が、途中で担当を変えることなく一貫してあなたを担当します。'),
        array('img' => 'implant-lp-reason02.webp', 'alt' => 'ベッドの上で口腔ケアを受ける高齢の女性',       'badge' => '当院の最大の特長', 'title' => '訪問診療で“入れた先”まで<br>生涯サポート', 'text' => '通院が難しくなっても、訪問診療で口腔ケアを継続。寝たきりになっても、インプラントの状態まで最期まで診続けられるのが当院の最大の強みです。'),
        array('img' => 'implant-lp-reason03.webp', 'alt' => '口腔内スキャナーでデジタルの歯型をとっている様子', 'badge' => '',               'title' => '審美治療のDX化で、<br class="implant-reason__br-sp">美しく精密に',           'text' => '口腔内スキャナーによるデジタル歯型とりと、審美専門の歯科技工士の立ち会いにより、歯の色や形を確認しながら製作。より自然で美しい被せ物に仕上げます。'),
        array('img' => 'implant-lp-reason04.webp', 'alt' => '院長がレントゲン画像を見せながら説明している様子', 'badge' => '',               'title' => '医科歯科連携で全身疾患も安心',             'text' => '東京医科歯科大学出身の院長が、医科と歯科をまたいだ視点で対応。高血圧・糖尿病など全身疾患をお持ちの方も、連携のうえ安全に治療を進められます。'),
        array('img' => 'implant-lp-reason05.webp', 'alt' => '拡大鏡を使って治療している院長',                 'badge' => '',               'title' => '難症例にも対応できる技術力',               'text' => '骨が足りない・他院で断られた方にも、骨造成など幅広い選択肢をご用意。「難しい」と言われた方こそ、一度ご相談ください。'),
    );
    ?>
    <section class="implant-reason" id="reason" style="--reason-bg: url('<?php echo esc_url($ilp_img_dir . 'implant-lp-reason-bg.webp'); ?>')">
        <div class="implant-reason__inner">
            <div class="implant-reason__head">
                <p class="implant-reason__en">REASON</p>
                <h2 class="implant-reason__title">
                    <span class="implant-reason__title-main">富士見台さくら歯科の<br class="implant-reason__br-sp">インプラントが<br>選ばれる理由</span>
                </h2>
                <span class="implant-reason__ornament" aria-hidden="true"><span class="implant-reason__diamond"></span></span>
            </div>

            <ol class="implant-reason__list">
                <?php foreach ($ilp_reasons as $i => $r) : ?>
                    <li class="implant-reason__item<?php echo $i % 2 ? ' is-reverse' : ''; ?>">
                        <figure class="implant-reason__media">
                            <img src="<?php echo esc_url($ilp_img_dir . $r['img']); ?>" alt="<?php echo esc_attr($r['alt']); ?>" width="920" height="580" loading="lazy">
                        </figure>
                        <div class="implant-reason__body">
                            <p class="implant-reason__label" aria-hidden="true">
                                <span class="implant-reason__label-en">REASON</span>
                                <span class="implant-reason__num"><?php echo esc_html(sprintf('%02d', $i + 1)); ?></span>
                                <?php if ($r['badge']) : ?><span class="implant-reason__badge"><?php echo esc_html($r['badge']); ?></span><?php endif; ?>
                            </p>
                            <h3 class="implant-reason__item-title"><?php echo wp_kses($r['title'], array('br' => array('class' => true))); ?></h3>
                            <p class="implant-reason__item-text"><?php echo esc_html($r['text']); ?></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </section>

    <!-- ========================================
         CTA（CONSULTATION：入れる時も、その先の人生も。最期まで、あなたのお口を守り続けます。）
         ・中身は上の $ilp_cta（白いデザイン＋大きなタイトル）
    ========================================= -->
    <?php
    $ilp_cta(array(
        'id'      => 'cta-reason',
        'large'   => true,
        'title'   => '入れる時も、その先の人生も。<br>最期まで、あなたのお口を<br class="implant-cta__br-sp">守り続けます。',
        'sp_dark' => true, // SPは紺の背景（見本 2026/11）
        'mark'    => '',
        'tagline' => '—— 笑顔、めぐる。富士見台さくら歯科',
    ));
    ?>

    <!-- ========================================
         FLOW（インプラント治療の流れ）
         ・お悩み⑤の答え（TROUBLE のリンク先：#flow）
         ・背景：img/implant-lp-flow-bg.webp／写真：img/implant-lp-flow01〜08.webp
         ・上のSTEP一覧は、下の各STEPへ移動するリンクです
    ========================================= -->
    <?php
    // time：所要時間などのチップ／point：紺の帯（不要なら空）／feature：上のSTEP一覧で紺にする（当院の特長のSTEP）
    $ilp_flow_steps = array(
        array('nav' => '各種検査',           'title' => '各種検査',                       'time' => '所要時間：約1時間',            'text' => '口腔内写真・CT等を撮影し、治療計画の基礎データを採ります。',                                                               'point' => '',                                         'feature' => false),
        array('nav' => 'シミュレーション',   'title' => 'インプラントシミュレーション',   'time' => '所要時間：30分',               'text' => 'CTデータをもとに、インプラントの埋入位置をシミュレーションします。',                                                         'point' => '',                                         'feature' => false),
        array('nav' => '治療計画説明',       'title' => '治療計画説明',                   'time' => '所要時間：約30分',             'text' => 'シミュレーション結果をもとに、治療計画・期間・費用をご説明します。',                                                         'point' => '',                                         'feature' => false),
        array('nav' => 'インプラント手術',   'title' => 'インプラント手術（1次手術のみ）', 'time' => '所要時間：約30分〜1時間',      'text' => '設計に沿ってインプラント体を埋入します。',                                                                                   'point' => '当院は即時埋入で1回で完了',                 'feature' => true),
        array('nav' => '型取り',             'title' => '被せ物の型取り',                 'time' => '所要時間：約5分／3〜6ヶ月後',  'text' => '骨との結合を確認し、被せ物の型取りを行います。スキャンを使用するため、負担なく型取りをできます。',                           'point' => '口腔内スキャナーで型取り。負担が少なく短時間で完了', 'feature' => false),
        array('nav' => '治癒期間',           'title' => '治癒期間（骨との結合を待つ）',   'time' => '3〜6ヶ月',                     'text' => 'インプラント体と骨がしっかり結合するのを待つ期間です。この間も定期的にご来院いただき、お口のクリーニングと傷口の状態チェックを行います。', 'point' => '',                                         'feature' => false),
        array('nav' => '被せ物の装着',       'title' => '被せ物の装着',                   'time' => '所要時間：約15〜30分',         'text' => '完成した被せ物を装着し、噛み合わせを調整します。',                                                                           'point' => '',                                         'feature' => false),
        array('nav' => 'メンテナンス',       'title' => 'メンテナンス',                   'time' => '3ヶ月ごと',                    'text' => '長く使うために、定期的なメンテナンスを行います。',                                                                           'point' => '',                                         'feature' => false),
    );
    ?>
    <section class="implant-flow" id="flow" style="--flow-bg: url('<?php echo esc_url($ilp_img_dir . 'implant-lp-flow-bg.webp'); ?>')">
        <div class="implant-flow__inner">
            <div class="implant-flow__head">
                <p class="implant-flow__chip">お悩み⑤『費用・治療期間が<br class="implant-flow__br-sp">不安』への答え</p>
                <p class="implant-flow__en">FLOW</p>
                <h2 class="implant-flow__heading">
                    <span class="implant-flow__title">インプラント治療の流れ</span>
                </h2>
                <span class="implant-flow__ornament" aria-hidden="true"><span class="implant-flow__diamond"></span></span>
            </div>

            <!-- 即時埋入の比較 -->
            <div class="implant-flow__card">
                <p class="implant-flow__card-label">当院なら、1度で完結型手術</p>
                <p class="implant-flow__card-title">即時埋入なら、手術は1回で完結。<br>通院回数も、体の負担も少なく。</p>
                <div class="implant-flow__comment">
                    <figure class="implant-flow__avatar">
                        <span class="implant-flow__avatar-img" style="background-image: url('<?php echo esc_url($ilp_img_dir . 'implant-lp-doctor01.webp'); ?>')" role="img" aria-label="院長 芳賀浩昭"></span>
                        <figcaption class="implant-flow__avatar-name">院長 芳賀 浩昭</figcaption>
                    </figure>
                    <p class="implant-flow__bubble">通常のインプラント治療では、抜歯と埋入でそれぞれ手術が必要になることがあります。当院は抜歯と同時に埋入する「即時埋入」により手術は1回。通院回数を減らし、体への負担と治療期間を抑えられます。</p>
                </div>

                <?php /* 構成メモより：比較図は <figure> */ ?>
                <figure class="implant-flow__compare" aria-label="通常のインプラントと即時埋入（当院）の比較">
                    <div class="implant-flow__row">
                        <p class="implant-flow__row-label">通常のインプラント</p>
                        <ol class="implant-flow__boxes">
                            <li class="implant-flow__box is-surgery">抜歯手術</li>
                            <li class="implant-flow__box is-period">治癒期間</li>
                            <li class="implant-flow__box is-surgery">埋入手術</li>
                            <li class="implant-flow__box is-period">治癒期間</li>
                            <li class="implant-flow__box is-crown">被せ物</li>
                        </ol>
                        <p class="implant-flow__result">手術<span>2</span>回</p>
                    </div>
                    <div class="implant-flow__row is-ours">
                        <p class="implant-flow__row-label">即時埋入（当院）</p>
                        <ol class="implant-flow__boxes">
                            <li class="implant-flow__box is-gold is-wide-a">抜歯＋埋入手術（同日）</li>
                            <li class="implant-flow__box is-period is-wide-b">治癒期間</li>
                            <li class="implant-flow__box is-crown">被せ物</li>
                        </ol>
                        <p class="implant-flow__result is-gold">手術<span>1</span>回</p>
                    </div>
                </figure>
            </div>

            <?php /* STEP一覧（各STEPへのリンク）は非表示中。出すときは、この行の下の <?php if (false) : ?> と <?php endif; ?> を消してください */ ?>
            <?php if (false) : ?>
            <!-- STEP一覧（各STEPへのリンク） -->
            <ol class="implant-flow__nav">
                <?php foreach ($ilp_flow_steps as $i => $st) : ?>
                    <li>
                        <a class="implant-flow__nav-link<?php echo $st['feature'] ? ' is-feature' : ''; ?>" href="#flow-step<?php echo esc_attr($i + 1); ?>">
                            <span class="implant-flow__nav-num"><?php echo esc_html(sprintf('%02d', $i + 1)); ?></span>
                            <span class="implant-flow__nav-text"><?php echo esc_html($st['nav']); ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ol>
            <?php endif; ?>

            <!-- STEP 01〜08 -->
            <ol class="implant-flow__steps">
                <?php foreach ($ilp_flow_steps as $i => $st) : ?>
                    <li class="implant-flow__step" id="flow-step<?php echo esc_attr($i + 1); ?>">
                        <span class="implant-flow__step-num" aria-hidden="true"><span class="implant-flow__step-en">STEP</span><?php echo esc_html(sprintf('%02d', $i + 1)); ?></span>
                        <img class="implant-flow__step-img" src="<?php echo esc_url($ilp_img_dir . sprintf('implant-lp-flow%02d.webp', $i + 1)); ?>" alt="" width="600" height="400" loading="lazy">
                        <div class="implant-flow__step-body">
                            <h3 class="implant-flow__step-title"><?php echo esc_html($st['title']); ?></h3>
                            <p class="implant-flow__time"><img class="implant-flow__clock" src="<?php echo esc_url($ilp_img_dir . 'implant-lp-flow-clock.webp'); ?>" alt="" width="14" height="14" loading="lazy"><?php echo esc_html($st['time']); ?></p>
                            <p class="implant-flow__step-text"><?php echo esc_html($st['text']); ?></p>
                            <?php if ($st['point']) : ?>
                                <p class="implant-flow__point"><span class="implant-flow__point-label" aria-hidden="true">POINT</span><?php echo esc_html($st['point']); ?></p>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </section>

    <!-- ========================================
         PRICE（インプラント治療の費用・料金表）
         ・背景：img/implant-lp-price-bg.webp
         ・保証の図：img/implant-lp-price-guarantee.webp／アイコン：implant-lp-price-icon-shield・clock.webp
         ・料金は下の配列で書き換えられます（表示はすべて税込）
    ========================================= -->
    <?php
    // 基本料金（guarantee：保証期間。空なら「–」）
    $ilp_price_basic = array(
        array('name' => '術前診断＋ガイドサージェリー',     'desc' => 'CT撮影でお口の状態を詳しく調べ、治療計画を立案。CTデータとお口のデジタルデータを統合し、埋入位置を事前にシミュレーション。手術用ガイドを作製します', 'guarantee' => '',     'price' => '55,000'),
        array('name' => 'インプラント体 埋入手術（チタン）', 'desc' => '歯を失った部分の顎の骨に、人工歯根（インプラント）を埋め込みます',                                                                       'guarantee' => '10年', 'price' => '308,000'),
        array('name' => '上部構造 クラウン（ジルコニア）',   'desc' => '金属を使わない高強度セラミック。天然歯に近い色調で、前歯から奥歯まで対応',                                                               'guarantee' => '5年',  'price' => '179,300'),
        array('name' => '上部構造 ポンティック（セラミック）', 'desc' => 'インプラントブリッジで、歯のない部分を補う人工歯',                                                                                     'guarantee' => '5年',  'price' => '132,000'),
        array('name' => 'ジルコニアアバットメント',           'desc' => 'インプラントと被せ物をつなぐ白い土台。前歯部や歯ぐきの薄い方に適しています',                                                             'guarantee' => '',     'price' => '66,000'),
        array('name' => 'マルチユニット＋アバットメント',     'desc' => '角度をつけてインプラントを埋入した場合に、角度を補正する装置',                                                                           'guarantee' => '',     'price' => '110,000'),
    );
    // 骨造成・再生療法
    $ilp_price_bone = array(
        array('name' => 'GBR（人工骨・人工膜）',   'desc' => '骨の量が足りない部分に、骨を再生させる方法です',                                         'price' => '88,000',  'unit' => '／1歯'),
        array('name' => 'OAM（特殊器具）',          'desc' => 'ドリルで骨を削らず、周囲に押し広げてインプラントのスペースをつくる方法です',             'price' => '110,000', 'unit' => '／1歯'),
        array('name' => 'スプリット（専用器具）',   'desc' => '骨の幅が狭い場合に、専用器具で少しずつ骨の幅を広げる方法です',                           'price' => '110,000', 'unit' => '／1歯'),
        array('name' => 'ソケットリフト（人工骨）', 'desc' => '上顎の骨の高さが足りない場合に、上顎洞を持ち上げてインプラントを埋め込む方法です',     'price' => '88,000',  'unit' => '／1歯'),
        array('name' => 'サイナスリフト（人工骨）', 'desc' => 'ソケットリフトで対応できないほど骨が少ない場合に、骨補填材で上顎洞を持ち上げる方法です', 'price' => '440,000', 'unit' => '／1ブロック'),
    );
    // 月々のお支払い例（回数ごとに [月々, 初回]）。最後の列が強調されます
    $ilp_price_plan_heads = array('6回', '12回（1年間）', '18回', '24回');
    $ilp_price_plans = array(
        array('name' => 'インプラント1本',   'total' => '542,300円', 'cells' => array(array('91,900', '94,270'),  array('46,600', '49,140'), array('31,500', '34,270'), array('23,900', '28,120'))),
        array('name' => 'インプラント＋GBR', 'total' => '630,300円', 'cells' => array(array('106,800', '109,640'), array('54,100', '57,770'), array('36,600', '40,030'), array('27,800', '32,220'))),
    );
    $ilp_price_notes = array(
        '表示価格はすべて税込です。インプラント治療は自費診療（保険適用外）です。',
        '骨造成・静脈内鎮静法は、検査結果やご希望に応じて必要な方のみ追加となります。',
        '治療期間はお口の状態により異なります。',
        'デンタルクレジットの月々・初回のお支払い額は、分割手数料を含む金額です。',
        'オールオン4、インプラント義歯などの費用は症例により異なります。詳しくはお問い合わせください。',
    );
    ?>
    <section class="implant-price" id="price" style="--price-bg: url('<?php echo esc_url($ilp_img_dir . 'implant-lp-price-bg.webp'); ?>')">
        <div class="implant-price__inner">
            <div class="implant-price__head">
                <p class="implant-price__en">PRICE</p>
                <h2 class="implant-price__heading">
                    <span class="implant-price__title">インプラント治療の<br class="implant-price__br-sp">費用・料金表</span>
                </h2>
                <span class="implant-price__ornament" aria-hidden="true"><span class="implant-price__diamond"></span></span>
            </div>

            <div class="implant-price__comment">
                <figure class="implant-price__avatar">
                    <span class="implant-price__avatar-img" style="background-image: url('<?php echo esc_url($ilp_img_dir . 'implant-lp-doctor01.webp'); ?>')" role="img" aria-label="院長 芳賀浩昭"></span>
                    <figcaption class="implant-price__avatar-name">院長 芳賀 浩昭</figcaption>
                </figure>
                <p class="implant-price__bubble">「結局いくらかかるのか分からない」という不安を残さないよう、インプラント治療にかかる費用を項目ごとに明記しています（すべて税込）。デンタルクレジットによる分割払いや、最長10年の保証制度もご用意しています。</p>
            </div>

            <!-- 総額＋月々 -->
            <div class="implant-price__summary">
                <div class="implant-price__monthly">
                    <p class="implant-price__monthly-label">デンタルクレジットなら</p>
                    <p class="implant-price__monthly-price"><small>月々</small><strong>23,900</strong><small>円〜</small></p>
                    <p class="implant-price__monthly-note">24回払いの場合（初回28,120円）<br>12回払いなら 月々46,600円</p>
                </div>
                <div class="implant-price__total">
                    <p class="implant-price__total-label">インプラント1本の治療費</p>
                    <p class="implant-price__total-price"><strong>542,300</strong>円<small>（税込）</small></p>
                    <p class="implant-price__total-break">埋入手術 308,000円 ＋ ガイドサージェリー 55,000円 ＋ 上部構造 179,300円</p>
                    <ul class="implant-price__tags">
                        <li><img src="<?php echo esc_url($ilp_img_dir . 'implant-lp-price-icon-shield.webp'); ?>" alt="" width="14" height="14">インプラント体 保証10年</li>
                        <li><img src="<?php echo esc_url($ilp_img_dir . 'implant-lp-price-icon-shield.webp'); ?>" alt="" width="14" height="14">上部構造 保証5年</li>
                        <li><img src="<?php echo esc_url($ilp_img_dir . 'implant-lp-price-icon-clock.webp'); ?>" alt="" width="14" height="14">治療期間 2〜6ヶ月</li>
                    </ul>
                    <p class="implant-price__total-note">※ 術前診断料（33,000円）は別途かかります。</p>
                </div>
            </div>

            <!-- 保証システム -->
            <h3 class="implant-price__h3">保証システム（最長10年）</h3>
            <p class="implant-price__h3-sub">治療後も長く安心してお使いいただけるよう、保証制度を設けています。</p>
            <div class="implant-price__guarantee">
                <div class="implant-price__guarantee-main">
                    <img class="implant-price__guarantee-img" src="<?php echo esc_url($ilp_img_dir . 'implant-lp-price-guarantee.webp'); ?>" alt="インプラントの構造：上部構造、アバットメント（連結部）、歯ぐき、インプラント体、あごの骨" width="800" height="600" loading="lazy">
                    <dl class="implant-price__guarantee-list">
                        <div class="implant-price__guarantee-item">
                            <dt class="implant-price__guarantee-badge"><small>保証</small><span class="implant-price__guarantee-years"><span>5</span>年</span></dt>
                            <dd><p class="implant-price__guarantee-name">上部構造（被せ物）</p><p class="implant-price__guarantee-text">ジルコニア・セラミックなどの被せ物の保証期間です。</p></dd>
                        </div>
                        <div class="implant-price__guarantee-item">
                            <dt class="implant-price__guarantee-badge"><small>保証</small><span class="implant-price__guarantee-years"><span>10</span>年</span></dt>
                            <dd><p class="implant-price__guarantee-name">インプラント体</p><p class="implant-price__guarantee-text">埋入したインプラント体（人工歯根）の保証期間です。</p></dd>
                        </div>
                    </dl>
                </div>
                <p class="implant-price__guarantee-note"><small>※ 保証の適用には、主治医が定める定期検診を受けていただくことが条件となります。</small></p>
            </div>

            <!-- 基本料金 -->
            <h3 class="implant-price__h3">インプラント治療の基本料金</h3>
            <p class="implant-price__h3-sub">1本あたりの料金です。上部構造（被せ物）は素材や用途により料金が異なります。治療期間の目安は2ヶ月〜6ヶ月です。</p>
            <div class="implant-price__table-wrap">
                <table class="implant-price__table implant-price__table--basic">
                    <caption class="screen-reader-text">インプラント治療の基本料金（1本あたり・税込）</caption>
                    <thead>
                        <tr><th scope="col">治療内容</th><th scope="col" class="is-guarantee">保証期間</th><th scope="col" class="is-price">料金（税込）</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ilp_price_basic as $row) : ?>
                            <tr>
                                <th scope="row"><span class="implant-price__item-name"><?php echo esc_html($row['name']); ?></span><span class="implant-price__item-desc"><?php echo esc_html($row['desc']); ?></span></th>
                                <td class="is-guarantee<?php echo $row['guarantee'] ? '' : ' is-empty'; ?>"><?php if ($row['guarantee']) : ?><span class="implant-price__badge"><span class="implant-price__badge-sp">保証 </span><?php echo esc_html($row['guarantee']); ?></span><?php else : ?><span aria-label="なし">–</span><?php endif; ?></td>
                                <td class="is-price"><span class="implant-price__yen"><?php echo esc_html($row['price']); ?></span><small>円</small></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- 骨造成 -->
            <h3 class="implant-price__h3">骨が足りない場合の治療<br class="implant-price__br-sp">（骨造成・再生療法）</h3>
            <p class="implant-price__h3-sub">精密検査の結果、骨の幅や高さが足りない場合のみ必要となる処置です。</p>
            <div class="implant-price__table-wrap">
                <table class="implant-price__table implant-price__table--bone">
                    <caption class="screen-reader-text">骨が足りない場合の治療の料金（税込）</caption>
                    <thead>
                        <tr><th scope="col">治療内容</th><th scope="col" class="is-price">料金（税込）</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ilp_price_bone as $row) : ?>
                            <tr>
                                <th scope="row"><span class="implant-price__item-name"><?php echo esc_html($row['name']); ?></span><span class="implant-price__item-desc"><?php echo esc_html($row['desc']); ?></span></th>
                                <td class="is-price"><span class="implant-price__yen"><?php echo esc_html($row['price']); ?></span><small>円<?php echo esc_html($row['unit']); ?></small></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- 月々のお支払い例 -->
            <h3 class="implant-price__h3">月々のお支払い例<br class="implant-price__br-sp">（デンタルクレジット）</h3>
            <p class="implant-price__h3-sub">分割払いなら、月々のご負担を抑えて治療を始められます。月々のお支払い額（税込）です。</p>
            <div class="implant-price__methods">
                <span class="implant-price__methods-label">ご利用いただけるお支払い方法：</span>
                <ul>
                    <?php foreach (array('現金', 'クレジットカード', 'デンタルクレジット') as $ilp_method) : ?>
                        <li><img src="<?php echo esc_url($ilp_img_dir . 'implant-lp-price-icon-card.webp'); ?>" alt="" width="14" height="14"><?php echo esc_html($ilp_method); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="implant-price__table-wrap">
                <table class="implant-price__table implant-price__table--plan">
                    <caption class="screen-reader-text">デンタルクレジットの月々のお支払い例（税込）</caption>
                    <thead>
                        <tr>
                            <th scope="col">お支払い回数</th>
                            <?php foreach ($ilp_price_plan_heads as $hi => $head) : ?>
                                <th scope="col"<?php echo $hi === count($ilp_price_plan_heads) - 1 ? ' class="is-highlight"' : ''; ?>><?php echo esc_html($head); ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ilp_price_plans as $plan) : ?>
                            <tr>
                                <th scope="row"><span class="implant-price__item-name"><?php echo esc_html($plan['name']); ?></span><span class="implant-price__plan-total"><?php echo esc_html($plan['total']); ?></span></th>
                                <?php foreach ($plan['cells'] as $ci => $cell) : ?>
                                    <td<?php echo $ci === count($plan['cells']) - 1 ? ' class="is-highlight"' : ''; ?>><span class="implant-price__plan-price"><?php echo esc_html($cell[0]); ?>円</span><span class="implant-price__plan-first">初回<?php echo esc_html($cell[1]); ?>円</span></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php /* SP用：お支払い回数を縦に並べた表（PCの表とは表示を切り替え） */ ?>
            <div class="implant-price__table-wrap implant-price__table-wrap--plan-sp">
                <table class="implant-price__table implant-price__table--plan-sp">
                    <caption class="screen-reader-text">デンタルクレジットの月々のお支払い例（税込）</caption>
                    <thead>
                        <tr>
                            <th scope="col">お支払い回数</th>
                            <?php foreach ($ilp_price_plans as $plan) : ?>
                                <th scope="col"><?php echo esc_html($plan['name']); ?><span class="implant-price__plan-total"><?php echo esc_html($plan['total']); ?></span></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ilp_price_plan_heads as $hi => $head) : ?>
                            <tr<?php echo $hi === count($ilp_price_plan_heads) - 1 ? ' class="is-highlight"' : ''; ?>>
                                <th scope="row"><?php echo esc_html($head); ?></th>
                                <?php foreach ($ilp_price_plans as $plan) : ?>
                                    <td><span class="implant-price__plan-price"><?php echo esc_html($plan['cells'][$hi][0]); ?>円</span><span class="implant-price__plan-first">初回<?php echo esc_html($plan['cells'][$hi][1]); ?>円</span></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <ul class="implant-price__notes">
                <?php foreach ($ilp_price_notes as $note) : ?>
                    <li><small><?php echo esc_html($note); ?></small></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <!-- ========================================
         FAQ（インプラント治療のよくあるご質問）
         ・アコーディオン：最初は1つ目が開いた状態。別の質問を開くと、開いていた質問は閉じます（implant-lp.js）
    ========================================= -->
    <?php
    // 回答（a）の中の \n の位置で改行します（\n を使うときは " " で囲む）
    $ilp_faqs = array(
        array('q' => 'ブリッジや入れ歯と何が違いますか？',         'a' => "ブリッジは両隣の歯を削って支えにし、入れ歯は留め具や床で支えます。\nインプラントはあごの骨に人工歯根を埋め込むため、周りの歯を削らずに、しっかり噛める自然な見た目の歯を目指せます。\n一方で外科手術が必要で、自由診療（保険適用外）となります。"),
        array('q' => '治療期間はどのくらいかかりますか？',         'a' => "検査・治療計画のご説明のあと手術を行い、インプラントと骨がしっかり結合するまで3〜6ヶ月ほど待ってから被せ物を装着します。\n当院では抜歯と同時に埋入する「即時埋入」に対応しており、手術を1回にまとめられる場合があります。\n骨造成が必要な場合など、お口の状態によって期間は変わりますので、治療計画のご説明時に目安をお伝えします。"),
        array('q' => '高齢でも治療は受けられますか？',             'a' => "年齢だけで治療の可否を決めることはありません。お口と骨の状態、全身の健康状態を検査したうえで判断します。\n高血圧や糖尿病などの持病がある方も、必要に応じて主治医と連携しながら進めます。\n将来通院が難しくなった場合のメンテナンスまで含めて、治療方法をご提案します。"),
        array('q' => '手術は痛くありませんか？',                   'a' => "手術は局所麻酔をしてから行うため、処置中の痛みはできるだけ抑えられます。\n不安の強い方には、うとうとした状態で手術を受けられる静脈内鎮静法（別途費用）もご用意しています。\n術後に数日、痛みや腫れが出ることがありますが、感じ方には個人差があります。気になる症状があれば、遠慮なくご相談ください。"),
        array('q' => '通えなくなってもメンテナンスできますか？',   'a' => "はい。当院には訪問診療部があり、ご自宅や施設でもメンテナンスを続けられます。\nまた、必要に応じて被せ物を取り外して清掃・点検できる設計（スクリュー固定など）を選んでいるため、訪問先でもケアしやすくしています。\n訪問できる地域は事前にお問い合わせください。"),
    );
    ?>
    <section class="implant-faq" id="faq">
        <div class="implant-faq__inner">
            <div class="implant-faq__head">
                <p class="implant-faq__en">FAQ</p>
                <h2 class="implant-faq__heading">
                    <span class="implant-faq__title">インプラント治療の<br class="implant-faq__br-sp">よくあるご質問</span>
                </h2>
                <span class="implant-faq__ornament" aria-hidden="true"><span class="implant-faq__diamond"></span></span>
            </div>

            <div class="implant-faq__list" data-faq>
                <?php foreach ($ilp_faqs as $i => $faq) : ?>
                    <?php $open = ($i === 0); ?>
                    <div class="implant-faq__item<?php echo $open ? ' is-open' : ''; ?>">
                        <?php /* 構成メモより：質問は見出しタグにしない（button aria-expanded） */ ?>
                        <div class="implant-faq__q">
                            <button type="button" class="implant-faq__btn" id="implant-faq-q<?php echo esc_attr($i + 1); ?>" aria-expanded="<?php echo $open ? 'true' : 'false'; ?>" aria-controls="implant-faq-a<?php echo esc_attr($i + 1); ?>">
                                <span class="implant-faq__mark" aria-hidden="true">Q</span>
                                <span class="implant-faq__q-text"><?php echo esc_html($faq['q']); ?></span>
                                <span class="implant-faq__icon" aria-hidden="true"></span>
                            </button>
                        </div>
                        <div class="implant-faq__a" id="implant-faq-a<?php echo esc_attr($i + 1); ?>" role="region" aria-labelledby="implant-faq-q<?php echo esc_attr($i + 1); ?>"<?php echo $open ? '' : ' hidden'; ?>>
                            <div class="implant-faq__a-inner">
                                <span class="implant-faq__mark implant-faq__mark--a" aria-hidden="true">A</span>
                                <p class="implant-faq__a-text"><?php echo nl2br(esc_html($faq['a']), false); // 回答の \n の位置で改行 ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>


    <!-- ========================================
         MOVIE（動画でわかるインプラント治療）
         ・6本。URLを書き換えると動画が変わります（サムネイルは YouTube の画像を自動で使用）
         ・img/implant-lp-movie-（動画ID）.webp を置くと、そちらをサムネイルに使います
         ・再生ボタンを押すと、その場で動画を読み込みます（WHY NOW と同じしくみ）
    ========================================= -->
    <?php
    $ilp_movies = array(
        array('url' => 'https://youtu.be/83-dRnJD9bU', 'title' => '部品がなくなる！？失敗しないインプラントメーカーの選び方'),
        array('url' => 'https://youtu.be/SGcfQdCAT54', 'title' => '術後が本番！インプラント寿命を伸ばす通院の頻度'),
        array('url' => 'https://youtu.be/KJovKp_mKdE', 'title' => '「チタンは大丈夫？」インプラントとMRIの誤解を解説！'),
        array('url' => 'https://youtu.be/fp36iv7JrTQ', 'title' => '【覚悟が必要】前歯インプラントのリアルな話'),
        array('url' => 'https://youtu.be/TnaNrIfLikY', 'title' => '失敗しない歯医者選び！インプラントに偏らない「本当に信頼できる歯科医院」の見分け方'),
        array('url' => 'https://youtu.be/pyNJDmR-wBI', 'title' => '【悲報】インプラントは認定医じゃダメ！？衝撃の事実'),
    );
    ?>
    <section class="implant-movie" id="movie">
        <div class="implant-movie__inner">
            <div class="implant-movie__head">
                <p class="implant-movie__en">MOVIE</p>
                <h2 class="implant-movie__heading">
                    <span class="implant-movie__title">動画でわかる<br class="implant-movie__br-sp">インプラント治療</span>
                </h2>
                <p class="implant-movie__lead">院長が解説する動画です。気になるテーマから、短い時間でご覧いただけます。</p>
            </div>

            <ul class="implant-movie__list">
                <?php foreach ($ilp_movies as $mv) : ?>
                    <?php
                    $vid   = $ilp_youtube_id($mv['url']);
                    $local = 'implant-lp-movie-' . $vid . '.webp';
                    $thumb = file_exists($ilp_img_path . $local) ? $ilp_img_dir . $local : 'https://i.ytimg.com/vi/' . $vid . '/hqdefault.jpg';
                    ?>
                    <li class="implant-movie__item">
                        <div class="implant-movie__frame" data-youtube-id="<?php echo esc_attr($vid); ?>" data-video-title="<?php echo esc_attr($mv['title']); ?>">
                            <img class="implant-movie__thumb" src="<?php echo esc_url($thumb); ?>" alt="" width="480" height="270" loading="lazy">
                            <button type="button" class="implant-movie__play" data-video-play aria-label="動画「<?php echo esc_attr($mv['title']); ?>」を再生する">
                                <span class="implant-movie__play-icon" aria-hidden="true"></span>
                            </button>
                        </div>
                        <h3 class="implant-movie__item-title"><?php echo esc_html($mv['title']); ?></h3>
                        <a class="implant-movie__link" href="<?php echo esc_url($mv['url']); ?>" target="_blank" rel="noopener noreferrer">YouTubeで見る<span aria-hidden="true"> →</span><span class="screen-reader-text">（別タブで開きます）</span></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <!-- ========================================
         ACCESS（診療時間・アクセス｜中野区・富士見台駅の歯科）
         ・右側：Googleマップ（住所から自動で表示。$ilp_access_map を「共有 > 地図を埋め込む」のURLに差し替えてもOK）
         ・診療時間の表：$ilp_access_hours の open / half / closed を書き換えて変更
    ========================================= -->
    <?php
    $ilp_access_map = 'https://www.google.com/maps?q=' . rawurlencode('富士見台さくら歯科 東京都中野区上鷺宮3-16-9') . '&hl=ja&z=17&output=embed';
    $ilp_access_days  = array('月', '火', '水', '木', '金', '土', '日', '祝');
    $ilp_access_hours = array(
        '9:00–12:00'  => array('open', 'open', 'open', 'open', 'open', 'open', 'closed', 'closed'),
        '13:00–18:00' => array('open', 'open', 'open', 'half', 'open', 'open', 'closed', 'closed'),
    );
    $ilp_access_marks = array(
        'open'   => array('label' => '診療',                 'class' => 'is-open'),
        'half'   => array('label' => '祝日のある週のみ診療', 'class' => 'is-half'),
        'closed' => array('label' => '休診',                 'class' => 'is-closed'),
    );
    $ilp_access_tels = array(
        array('num' => '03-5848-9373', 'type' => '外来'),
        array('num' => '03-5848-8484', 'type' => '訪問'),
    );
    ?>
    <?php if (false) : // 診療時間・アクセスは一旦非表示（2026-11-26 指示。表示するときは false を true に） ?>
    <section class="implant-access" id="access">
        <div class="implant-access__inner">
            <div class="implant-access__head">
                <p class="implant-access__en">ACCESS</p>
                <h2 class="implant-access__title">
                    <span class="implant-access__title-main">診療時間・アクセス</span>
                    <span class="implant-access__title-sub"><span class="screen-reader-text">｜</span>中野区・富士見台駅の歯科</span>
                </h2>
                <span class="implant-access__ornament" aria-hidden="true"><span class="implant-access__diamond"></span></span>
            </div>

            <div class="implant-access__box">
                <div class="implant-access__info">
                    <img class="implant-access__photo" src="<?php echo esc_url($ilp_img_dir . 'implant-lp-access-photo.webp'); ?>" alt="富士見台さくら歯科の外観" width="952" height="200" loading="lazy">
                    <p class="implant-access__name">富士見台さくら歯科</p>

                    <dl class="implant-access__list">
                        <div class="implant-access__row">
                            <dt><img src="<?php echo esc_url($ilp_img_dir . 'implant-lp-access-icon-tel.webp'); ?>" alt="" width="18" height="18">TEL</dt>
                            <dd>
                                <?php foreach ($ilp_access_tels as $tel) : ?>
                                    <a class="implant-access__tel" href="tel:<?php echo esc_attr(preg_replace('/[^0-9]/', '', $tel['num'])); ?>"><span><?php echo esc_html($tel['num']); ?></span><small>（<?php echo esc_html($tel['type']); ?>）</small></a>
                                <?php endforeach; ?>
                            </dd>
                        </div>
                        <div class="implant-access__row">
                            <dt><img src="<?php echo esc_url($ilp_img_dir . 'implant-lp-access-icon-pin.webp'); ?>" alt="" width="18" height="18">所在地</dt>
                            <dd><address>〒165-0031 東京都中野区上鷺宮3-16-9</address></dd>
                        </div>
                        <div class="implant-access__row">
                            <dt><img src="<?php echo esc_url($ilp_img_dir . 'implant-lp-access-icon-train.webp'); ?>" alt="" width="18" height="18">アクセス</dt>
                            <dd>西武池袋線「富士見台駅」より徒歩3分（千川通り沿い）</dd>
                        </div>
                        <div class="implant-access__row">
                            <dt><img src="<?php echo esc_url($ilp_img_dir . 'implant-lp-access-icon-car.webp'); ?>" alt="" width="18" height="18">駐車場</dt>
                            <dd>医院契約駐車場あり／提携タイムズ 3か所</dd>
                        </div>
                    </dl>

                    <h3 class="screen-reader-text">診療時間</h3>
                    <table class="implant-access__table">
                        <thead>
                            <tr>
                                <th scope="col">診療時間</th>
                                <?php foreach ($ilp_access_days as $day) : ?>
                                    <th scope="col"><?php echo esc_html($day); ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ilp_access_hours as $time => $marks) : ?>
                                <tr>
                                    <th scope="row"><?php echo esc_html($time); ?></th>
                                    <?php foreach ($marks as $mark) : ?>
                                        <td><span class="implant-access__mark <?php echo esc_attr($ilp_access_marks[$mark]['class']); ?>" role="img" aria-label="<?php echo esc_attr($ilp_access_marks[$mark]['label']); ?>"></span></td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <p class="implant-access__note">休診：日・祝 <span class="implant-access__note-mark" aria-hidden="true">▲</span>木曜午後は祝日のある週のみ診療</p>

                    <a class="implant-access__btn" href="<?php echo esc_url($ilp_web_url); ?>">WEB予約はこちら<span class="implant-access__btn-arrow" aria-hidden="true"></span></a>
                </div>

                <div class="implant-access__map">
                    <iframe src="<?php echo esc_url($ilp_access_map); ?>" title="富士見台さくら歯科の地図" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ========================================
         最終CTA（CONSULTATION：まずはお気軽にご相談ください！）
         ・中身は上の $ilp_cta（紺のデザイン・特色の説明文は長い文）
    ========================================= -->
    <?php
    $ilp_cta(array(
        'id'    => 'cta-footer',
        'theme' => 'dark',
        'short' => false,
        'sp_dark' => true, // SPは白い箱＋金のボタンの形（見本 2026/11）
    ));
    ?>

    <!-- ========================================
         RISK & SIDE EFFECTS（インプラント治療のリスク・副作用）
         ・背景：img/implant-lp-risk-bg.webp
    ========================================= -->
    <?php
    $ilp_risks = array(
        array('title' => '手術に関連する事象',         'items' => array('感染（口腔清掃不良・糖尿病などの持病が原因となることも）', '神経損傷（骨が痩せているなどの解剖学的要因による）', '異常出血・異常疼痛', '術後の痛み、歯ぐきの赤み・腫れ、皮下出血・鼻出血')),
        array('title' => '装着・補綴に関連する事象',   'items' => array('インプラント体・アバットメントの破損（過度な噛み合わせの力）', 'スクリュー（ねじ）の緩み（歯ぎしり等）', '人工歯の破損（歯ぎしり・くいしばりなどの習癖）')),
        array('title' => '治療後に生じうる事象',       'items' => array('インプラント周囲炎（インプラントの歯周病。清掃不良や他の歯からの感染で発症）', '骨が痩せることによる歯ぐきの後退・審美障害')),
        array('title' => 'その他の注意点',             'items' => array('自費診療（保険適用外）', '治療期間が長い（骨とインプラントが結合するまで数ヶ月）', '半年〜1年ごとの定期メンテナンスが必要', '毎日のセルフケア（ブラッシング）が重要')),
    );
    ?>
    <section class="implant-risk" id="risk" style="--risk-bg: url('<?php echo esc_url($ilp_img_dir . 'implant-lp-risk-bg.webp'); ?>')">
        <div class="implant-risk__inner">
            <div class="implant-risk__head">
                <p class="implant-risk__en">RISK &amp; SIDE EFFECTS</p>
                <h2 class="implant-risk__heading">
                    <span class="implant-risk__title">インプラント治療の<br class="implant-risk__br-sp">リスク・副作用</span>
                </h2>
                <span class="implant-risk__ornament" aria-hidden="true"><span class="implant-risk__diamond"></span></span>
                <p class="implant-risk__lead">インプラント治療は外科処置を伴う自費診療です。以下のような事象が生じる可能性があります。治療前に<br class="implant-risk__br-pc">十分ご説明します。</p>
            </div>

            <div class="implant-risk__list">
                <?php foreach ($ilp_risks as $i => $risk) : ?>
                    <div class="implant-risk__card">
                        <h3 class="implant-risk__card-title"><span class="implant-risk__num" aria-hidden="true"><?php echo esc_html(sprintf('%02d', $i + 1)); ?></span><?php echo esc_html($risk['title']); ?></h3>
                        <ul class="implant-risk__items">
                            <?php foreach ($risk['items'] as $item) : ?>
                                <li><?php echo esc_html($item); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>
            </div>

            <p class="implant-risk__note"><small>※ 上記は一般的なリスク・副作用です。実際の治療内容・リスクは診察のうえ個別にご説明します。</small></p>
        </div>
    </section>

</div>

<?php get_footer(); ?>
