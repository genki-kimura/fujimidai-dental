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
    array('label' => 'インプラント',           'url' => '/treatment/implant/'),
    array('label' => 'ホワイトニング',         'url' => '/treatment/whitening/'),
    array('label' => 'デンタルエステ',         'url' => '/treatment/dental-esthetic/'),
    array('label' => '一般歯科（むし歯治療）', 'url' => '/treatment/general/'),
    array('label' => '根管治療',               'url' => '/treatment/root-canal/'),
    array('label' => '予防歯科',               'url' => '/treatment/prevention/'),
    array('label' => '訪問歯科診療',           'url' => '/treatment/home-visit/'),
    array('label' => '審美歯科',               'url' => '/treatment/esthetic/'),
    array('label' => '歯周病',                 'url' => '/treatment/periodontal/'),
    array('label' => '口腔外科（親知らず）',   'url' => '/treatment/oral-surgery/'),
    array('label' => '矯正歯科治療',           'url' => '/treatment/orthodontics/'),
    array('label' => '小児歯科',               'url' => '/treatment/pediatric/'),
    array('label' => '睡眠時無呼吸症候群',     'url' => '/treatment/sleep-apnea/'),
    array('label' => '入れ歯・義歯',           'url' => '/treatment/denture/'),
));
$footer_treatment_rows = is_array($footer_menu_treatment) ? (int) ceil(count($footer_menu_treatment) / 2) : 7;

$footer_menu_other = $footer_field('footer_menu_other', array(
    // array('label' => '症例紹介',           'url' => '/case/'), // 非表示中（再表示する場合は先頭の // を外す）
    array('label' => 'プライバシーポリシー', 'url' => '/privacy-policy/'),
    array('label' => 'サイトマップ',         'url' => '/sitemap/'),
    array('label' => '医療広告ガイドライン', 'url' => '/guidelines/'),
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
// 追従ボタンのアイコン（img フォルダ内）
$cta_icon_dir  = get_template_directory_uri() . '/img/';
?>
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

                                <a href="<?php echo esc_url(home_url('/treatment/home-visit/')); ?>" class="Access__banner">
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
    <aside class="floating-cta is-scrolling" aria-label="ご予約・お問い合わせ">
        <a class="floating-cta__btn floating-cta__btn--web" href="<?php echo esc_url($footer_url($cta_web_url)); ?>" style="--cta-icon: url('<?php echo esc_url($cta_icon_dir . 'cta-icon01.webp'); ?>')">
            <span class="floating-cta__icon" aria-hidden="true"></span>
            <span class="floating-cta__text">
                <span class="floating-cta__label">24時間受付中</span>
                <span class="floating-cta__main"><span class="floating-cta__pc">WEB予約する</span><span class="floating-cta__sp">WEB予約</span></span>
            </span>
        </a>
        <a class="floating-cta__btn floating-cta__btn--white" href="<?php echo esc_url($footer_url($cta_white_url)); ?>" style="--cta-icon: url('<?php echo esc_url($cta_icon_dir . 'cta-icon02.webp'); ?>')">
            <span class="floating-cta__icon" aria-hidden="true"></span>
            <span class="floating-cta__text">
                <span class="floating-cta__label"><span class="floating-cta__pc">ホワイトエッセンス加盟店</span><span class="floating-cta__sp">ホワイトエッセンス</span></span>
                <span class="floating-cta__main"><span class="floating-cta__pc">ホワイトニングを予約</span><span class="floating-cta__sp">ホワイトニング予約</span></span>
            </span>
        </a>
        <address class="floating-cta__address">
            <a class="floating-cta__btn floating-cta__btn--tel" href="<?php echo esc_attr($cta_tel_href); ?>" style="--cta-icon: url('<?php echo esc_url($cta_icon_dir . 'cta-icon03.webp'); ?>')">
                <span class="floating-cta__icon" aria-hidden="true"></span>
                <span class="floating-cta__text">
                    <span class="floating-cta__label"><span class="floating-cta__pc">月〜土 9:00-12:00 / 13:00-18:00</span><span class="floating-cta__sp"></span></span>
                    <span class="floating-cta__label"><span class="floating-cta__sp"><?php echo esc_html($cta_tel); ?></span></span>
                    <span class="floating-cta__main"><span class="floating-cta__pc"><?php echo esc_html($cta_tel); ?></span><span class="floating-cta__sp">電話する</span></span>
                </span>
            </a>
        </address>
    </aside>

    <!-- ページ上部へ戻るボタン（スクロールすると表示。スマホでは追従バーの右上に小さく表示） -->
    <button type="button" class="page-top" aria-label="ページの先頭へ戻る" style="--page-top-flower: url('<?php echo esc_url(get_template_directory_uri() . '/img/Logo02-flower.webp'); ?>')">
        <span class="page-top__arrow" aria-hidden="true"></span>
        <span class="page-top__text">TOPへ戻る</span>
    </button>

    <?php wp_footer(); ?>
</body>
</html>
