    </main>

<?php
/* ----------------------------------------
   フッター・追従ボタン用の値（ACFオプションページ「フッター設定」から取得）
   ACF未導入・未入力の場合は、右側の初期値が表示されます
---------------------------------------- */
$footer_field = function ($name, $default = '') {
    $value = function_exists('get_field') ? get_field($name, 'option') : '';
    return $value ? $value : $default;
};

// 「/staff/」のような相対パスはサイトURLを付けて出力
$footer_url = function ($url) {
    $url = (string) $url;
    return (strpos($url, '/') === 0) ? home_url($url) : $url;
};

// メニューのリストを出力
$footer_list = function ($items, $class = 'footer__list', $style = '') use ($footer_url) {
    if (!is_array($items)) {
        return;
    }
    $style_attr = $style ? ' style="' . esc_attr($style) . '"' : '';
    echo '<ul class="' . esc_attr($class) . '"' . $style_attr . '>';
    foreach ($items as $item) {
        if (empty($item['label'])) {
            continue;
        }
        $href = isset($item['url']) ? $item['url'] : '';
        echo '<li class="footer__item"><a class="footer__link" href="' . esc_url($footer_url($href)) . '">' . esc_html($item['label']) . '</a></li>';
    }
    echo '</ul>';
};

// ▼ リンク先は仮のURLです。ACFで設定するか、ここを書き換えてください
$footer_menu_about = $footer_field('footer_menu_about', array(
    array('label' => '当院の理念・特徴', 'url' => '/philosophy/'),
    array('label' => 'スタッフ紹介',     'url' => '/staff/'),
    array('label' => 'クリニック紹介',   'url' => '/clinic/'),
    array('label' => '初めての方へ',     'url' => '/first/'),
    array('label' => '料金表',           'url' => '/price/'),
    array('label' => 'アクセス案内',     'url' => '/access/'),
));

// 診療案内は「左の列 → 右の列」の順に、半分ずつ2列で表示されます
$footer_menu_treatment = $footer_field('footer_menu_treatment', array(
    array('label' => 'インプラント',           'url' => '/implant/'),
    array('label' => 'ホワイトニング',         'url' => '/whitening/'),
    array('label' => 'デンタルエステ',         'url' => '/dental-esthetic/'),
    array('label' => '一般歯科（むし歯治療）', 'url' => '/general/'),
    array('label' => '根管治療',               'url' => '/root-canal/'),
    array('label' => '予防歯科',               'url' => '/prevention/'),
    array('label' => '訪問歯科診療',           'url' => '/home-visit/'),
    array('label' => '審美歯科',               'url' => '/esthetic/'),
    array('label' => '歯周病',                 'url' => '/periodontal/'),
    array('label' => '口腔外科（親知らず）',   'url' => '/oral-surgery/'),
    array('label' => '矯正歯科治療',           'url' => '/orthodontics/'),
    array('label' => '小児歯科',               'url' => '/pediatric/'),
    array('label' => '睡眠時無呼吸症候群',     'url' => '/sleep-apnea/'),
    array('label' => '入れ歯・義歯',           'url' => '/denture/'),
));
$footer_treatment_rows = is_array($footer_menu_treatment) ? (int) ceil(count($footer_menu_treatment) / 2) : 7;

$footer_menu_other = $footer_field('footer_menu_other', array(
    array('label' => '症例紹介',           'url' => '/case/'),
    array('label' => 'プライバシーポリシー', 'url' => '/privacy-policy/'),
    array('label' => 'サイトマップ',       'url' => '/sitemap/'),
));

$footer_guideline_text = $footer_field('footer_guideline_text', '当院は2018年6月に施行された改正医療法を遵守し、医療機関としての適切な情報を元に当Webサイトを運営しております。');
$footer_guideline_links = $footer_field('footer_guideline_links', array(
    array('label' => '医療法における病院等の広告規制について', 'url' => 'https://www.mhlw.go.jp/stf/seisakunitsuite/bunya/kenkou_iryou/iryou/kokokukisei/index.html'),
    array('label' => '医業若しくは歯科医業又は病院若しくは診療所に関する広告等に関する指針(医療広告ガイドライン)等について', 'url' => 'https://www.mhlw.go.jp/stf/seisakunitsuite/bunya/kenkou_iryou/iryou/kokokukisei/index.html'),
));
$footer_copyright = $footer_field('footer_copyright', '© ' . wp_date('Y') . ' 富士見台さくら歯科 / 医療法人社団 以和貴会');

// 追従ボタン
$cta_web_url   = $footer_field('cta_web_url', '#');
$cta_white_url = $footer_field('cta_white_url', '#');
$cta_tel       = $footer_field('cta_tel', '03-5848-9373');
$cta_tel_hours = $footer_field('cta_tel_hours', '受付 月〜土 9:00-12:00 / 13:00-18:00');
$cta_tel_href  = 'tel:' . preg_replace('/[^0-9+]/', '', $cta_tel);
?>
    <footer class="footer">
        <div class="footer__inner">
            <!-- 右側の飾り（花は止まり、文字だけがゆっくり回る） -->
            <span class="footer__emblem emblem" aria-hidden="true">
                <img class="emblem__flower" src="<?php echo esc_url(get_template_directory_uri() . '/img/Logo02-flower.webp'); ?>" alt="" width="834" height="1106" loading="lazy">
                <img class="emblem__text" src="<?php echo esc_url(get_template_directory_uri() . '/img/Logo02-text.webp'); ?>" alt="" width="834" height="1106" loading="lazy">
            </span>
            <nav class="footer__nav" aria-label="フッターメニュー">
                <div class="footer__group">
                    <p class="footer__heading">医院について</p>
                    <?php $footer_list($footer_menu_about); ?>
                </div>
                <div class="footer__group footer__group--treatment">
                    <p class="footer__heading">診療案内</p>
                    <?php $footer_list($footer_menu_treatment, 'footer__list footer__list--2col', '--footer-rows: ' . $footer_treatment_rows); ?>
                </div>
                <div class="footer__group">
                    <p class="footer__heading">その他</p>
                    <?php $footer_list($footer_menu_other); ?>
                </div>
            </nav>

            <div class="footer__guideline">
                <p class="footer__guideline-title">医療広告ガイドラインの遵守について</p>
                <p class="footer__guideline-text"><?php echo esc_html($footer_guideline_text); ?></p>
                <?php if (is_array($footer_guideline_links)) : ?>
                    <ul class="footer__guideline-links">
                        <?php foreach ($footer_guideline_links as $item) : ?>
                            <?php if (empty($item['label'])) { continue; } ?>
                            <li>
                                <a href="<?php echo esc_url($footer_url(isset($item['url']) ? $item['url'] : '')); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($item['label']); ?><span aria-hidden="true"> ↗</span></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <div class="footer__bottom">
                <p class="footer__copy"><?php echo esc_html($footer_copyright); ?></p>
            </div>
        </div>
    </footer>

    <!-- 画面右側に追従するボタン（スマホでは画面下部のバーになり、文言が短くなります） -->
    <aside class="floating-cta" aria-label="ご予約・お問い合わせ">
        <a class="floating-cta__btn floating-cta__btn--web" href="<?php echo esc_url($footer_url($cta_web_url)); ?>">
            <span class="floating-cta__label">24時間受付中</span>
            <span class="floating-cta__main"><span class="floating-cta__pc">WEB予約する</span><span class="floating-cta__sp">WEB予約</span></span>
        </a>
        <a class="floating-cta__btn floating-cta__btn--white" href="<?php echo esc_url($footer_url($cta_white_url)); ?>">
            <span class="floating-cta__label"><span class="floating-cta__pc">ホワイトエッセンス加盟店</span><span class="floating-cta__sp">ホワイトエッセンス</span></span>
            <span class="floating-cta__main"><span class="floating-cta__pc">ホワイトニングを予約</span><span class="floating-cta__sp">ホワイトニング</span></span>
        </a>
        <address class="floating-cta__address">
            <a class="floating-cta__btn floating-cta__btn--tel" href="<?php echo esc_attr($cta_tel_href); ?>">
                <span class="floating-cta__label"><span class="floating-cta__pc"><?php echo esc_html($cta_tel_hours); ?></span><span class="floating-cta__sp"><?php echo esc_html($cta_tel); ?></span></span>
                <span class="floating-cta__main"><span class="floating-cta__pc">TEL <?php echo esc_html($cta_tel); ?></span><span class="floating-cta__sp">電話する</span></span>
            </a>
        </address>
    </aside>

    <?php wp_footer(); ?>
</body>
</html>
