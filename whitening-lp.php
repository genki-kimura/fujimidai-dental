<?php
/*
Template Name: ホワイトニングLP
*/
get_header();

/* ----------------------------------------
   ホワイトニングLP：メインビジュアル用の値
   文言を変えたいときは、ここだけ書き換えてください
---------------------------------------- */
$wl_img_dir = get_template_directory_uri() . '/img/';

// 配列の行を <br> でつなぐ（改行位置を指定するため）
$wl_br = function ($lines) {
    return implode('<br>', array_map('esc_html', (array) $lines));
};

$wl_mv = array(
    'brand'      => 'WHITE ESSENCE',
    'partner'    => 'ホワイトエッセンス提携医院',
    'label'      => 'WHITENING',
    'lead'       => array('富士見台・中野区の', 'ホワイトニング'), // スマホでは、この位置で改行（PC・h1の文章は1行でつながります）
    'clinic'     => '富士見台さくら歯科',
    'guarantee'  => array('白さに、', '結果保証'),
    'badges'     => array(
        array('追加', '無料'),
        array('全額', '返金'),
        array('中途', '解約'),
    ),
    // 医療広告GLの必須注記（<small>で常時表示・削除不可）。文言は見本から転記 → TODO：実際の条件文言と合っているか確認
    'guarantee_note' => '※他院での施術を含め、ホワイトニングが初めての方が対象です。ホワイトエッセンスコースをご利用のうえ、所定の通院回数・期間などの条件を満たした場合に限ります。',
    'result_label'   => '施術実績',
    'result_number'  => '471',
    'result_unit'    => '万件',
    'result_note'    => array('※2026年3月末時点／', 'ホワイトニング＋クリーニングの合計'),
);

/* ----------------------------------------
   ホワイトニングLP：症例（Before/After）用の値
   ・画像は img フォルダに入れます（未設置の間はグレーの枠が表示されます）
   ・症例は増やせます（2件以上でスライダー左右の矢印が表示されます）
---------------------------------------- */
$wl_case = array(
    'en'       => 'CASE',
    'title'    => 'ホワイトニングの症例',
    'title_sub'=> '（Before/After）',
    'lead'     => '中央のボタンを左右にスライドして、施術前後を見比べられます。',
    'note'     => '※ 施術前後の画像は、一切の加工・修正を行っておりません。',
    'items'    => array(
        array('before' => 'whitening-case01-before.webp', 'after' => 'whitening-case01-after.webp', 'alt' => '症例1'),
        array('before' => 'whitening-case02-before.webp', 'after' => 'whitening-case02-after.webp', 'alt' => '症例2'),
        array('before' => 'whitening-case03-before.webp', 'after' => 'whitening-case03-after.webp', 'alt' => '症例3'),
    ),
    // array(見出し, 内容, 太字にするか)
    'info'     => array(
        array('内容',           'ホワイトニング材とホワイトニング専用照射器を併用して歯を白くします', false),
        array('費用（自費）',   '19,900円（税込）', true),
        array('期間・回数',     '1回', false),
        array('副作用・リスク', '個人差がありますが、施術中や薬剤使用後に歯がしみる場合があります。', false),
        array('所要時間',       '初回90分／2回目以降45分　※初回はカウンセリング込み', false),
    ),
);

// 症例画像を出す（ファイルがなければグレーの枠）
$wl_case_img = function ($file, $alt) use ($wl_img_dir) {
    if ($file && file_exists(get_theme_file_path('/img/' . $file))) {
        return '<img class="wl-case__photo" src="' . esc_url($wl_img_dir . $file) . '" alt="' . esc_attr($alt) . '" loading="lazy" decoding="async" draggable="false">';
    }
    return '<span class="wl-case__placeholder" aria-hidden="true"></span>';
};
$wl_case_count = count($wl_case['items']);

/* ----------------------------------------
   ホワイトニングLP：「ホワイトニングとは」用の値
   ・背景写真：img/whitening-lp-about01.webp
   ・アイコン：img/whitening-lp-about02.webp 〜 04.webp
---------------------------------------- */
$wl_about = array(
    'en'        => 'ABOUT WHITENING',
    'title'     => 'ホワイトニングとは',
    'sub'       => '歯を削らず、内側から白く',
    'catch'     => array('歯の色が変わると、', '笑顔の印象まで|明るくなる。'), // 「|」の位置で、スマホだけ改行
    'texts'     => array(
        '歯を削らずに、あなたらしい白い歯と、心からの笑顔を。当院はホワイトエッセンス提携医院として、本物のホワイトニングをお届けします。',
        '薬剤を歯に塗布し、光を照射することで、歯の内部の黄ばみを分解して白くする施術です。表面の着色だけを落とすセルフケアとは異なり、医療用の薬剤で内側から自然な白さを引き出します。',
    ),
    // array(アイコン画像, 見出し（「|」の位置で、スマホだけ改行）, 説明)
    'points'    => array(
        array('whitening-lp-about02.webp', '内部の黄ばみを|分解',   '歯の表面の汚れだけでなく、内側の黄ばみに作用します。'),
        array('whitening-lp-about03.webp', '歯を削らずに|白く',     '健康な歯を削ることなく、印象を高められるのが魅力です。'),
        array('whitening-lp-about04.webp', '市販品とは違う|効果',   '医療用の薬剤と光照射で、本格的な白さを目指せます。'),
    ),
);

/* ----------------------------------------
   ホワイトニングLP：「シミュレーション（歯の白さで印象が変わる）」用の値
   ・画像は img フォルダに入れます（未設置の間はグレーの枠が表示されます）
     施術前：whitening-lp-simulation01.webp／施術後：whitening-lp-simulation02.webp
---------------------------------------- */
$wl_sim = array(
    'en'     => 'SIMULATION',
    'title'  => '歯の白さで、印象はこんなに変わる',
    'lead'   => '歯が白くなるだけで、清潔感や明るさなど、お顔全体の印象が変わります。',
    // array(画像, 英字ラベル, ひとこと, alt)
    'before' => array('whitening-lp-simulation01.webp', 'BEFORE', '歯の色が気になる印象',   '歯が黄ばんでいる状態のイメージ'),
    'after'  => array('whitening-lp-simulation02.webp', 'AFTER',  '明るく清潔感のある印象', '歯が白くなった状態のイメージ'),
    // 白さの目安バー（シェードガイド）
    'shade'  => array(
        'left'  => '黄ばみ',
        'right' => '白い',
        'steps' => array('C4', 'A3.5', 'B2', 'A1', '040', '020', 'BL'),
    ),
);

// シミュレーション画像を出す（ファイルがなければグレーの枠）
$wl_sim_img = function ($file, $alt) use ($wl_img_dir) {
    if ($file && file_exists(get_theme_file_path('/img/' . $file))) {
        return '<img class="wl-sim__img" src="' . esc_url($wl_img_dir . $file) . '" alt="' . esc_attr($alt) . '" loading="lazy" decoding="async">';
    }
    return '<span class="wl-sim__placeholder" aria-hidden="true"></span>';
};

/* ----------------------------------------
   ホワイトニングLP：「結果（一番人気コースの90%以上がブリーチシェードに到達）」用の値
   ・画像は img フォルダに入れます：whitening-lp-result02.webp（女性・背景透過）
   ・円グラフの長さ(91.4%)は CSS 側（.wl-result__ring）で固定しています。
     数字を変えるときは、CSSの円グラフの角度も合わせて直してください
---------------------------------------- */
$wl_result = array(
    'en'     => 'RESULT',
    'value'  => '91.4',
    'unit'   => '%',
    'title'  => array('一番人気コースの90%以上が', '「ブリーチシェード」に到達'),
    // PCでは行ごとに改行、スマホでは続けて表示
    'lead'   => array('一番人気「ホワイトエッセンスコース」を受けた方', 'の90%以上がブリーチシェードへ到達しています。'),
    'note'   => array('※ 集計期間：2023年1月〜12月／対象者：該当期間にホワイト', 'エッセンスコースを開始した 12,629名'),
    'image'  => 'whitening-lp-result01.webp',
    'image_sp' => 'whitening-lp-result01-sp.webp', // スマホ用（768px以下）。なければPC用の画像を使います
    'alt'    => '歯が白くなって笑顔になった女性',
);

// 配列の行を、1行ずつ <span> にして出す（PCだけ行ごとに改行させるため）
$wl_lines = function ($lines) {
    $out = '';
    foreach ((array) $lines as $line) {
        $out .= '<span class="wl-result__line">' . esc_html($line) . '</span>';
    }
    return $out;
};

/* ----------------------------------------
   ホワイトニングLP：「お悩み（ホワイトニングでよくあるお悩み）」用の値
   ・画像は img フォルダに入れます
     花びら（左）：whitening-lp-trouble01.webp／花びら（右）：whitening-lp-trouble02.webp
     チェックのマーク：whitening-lp-trouble03.webp（未設置の間は、CSSの丸＋「✓」が表示されます）
   ・お悩みは、増減できます（番号は自動で 01, 02… と振られます）
---------------------------------------- */
$wl_trouble = array(
    'en'      => 'TROUBLE',
    'title'   => 'ホワイトニングでよくあるお悩み',
    'petal_l' => 'whitening-lp-trouble01.webp',
    'petal_r' => 'whitening-lp-trouble02.webp',
    'check'   => 'whitening-lp-trouble03.webp',
    'items'   => array(
        '歯の黄ばみ・着色が気になる',
        '市販のホワイトニングでは白くならなかった',
        'ホワイトニングは痛い・しみそうで不安',
        '白さがどのくらい続くのか心配',
        '費用や通う回数がわからない',
        '自分の歯もキレイに白くなる？',
    ),
);

/* ----------------------------------------
   ホワイトニングLP：「ソリューション（そのお悩み、お任せください）」用の値
   ・画像は img フォルダに入れます：whitening-lp-solution01.webp 〜 07.webp
     （未設置の間はグレーの枠が表示されます）
   ・blocks は表示順です。'item'（お悩み01〜06）と 'banner'（紫のバナー）を並べ替え・追加できます
   ・'side' は画像の位置（left＝画像が左／right＝画像が右）
   ・画像は array(ファイル名, alt, 横幅, 縦幅)
---------------------------------------- */
$wl_solution = array(
    'en'    => 'SOLUTION',
    'title' => 'そのお悩み、富士見台さくら歯科にお任せください',
    'lead'  => 'よくいただく6つのご不安それぞれに、ホワイトエッセンス提携医院としての体制でお応えします。',
    'petal' => 'whitening-lp-trouble02.webp', // 右上の花びら（お悩みと共用。なくても表示は崩れません）
    'blocks' => array(
        // ---- 01 ----
        array(
            'type'  => 'item',
            'num'   => '01',
            'tag'   => '黄ばみ・着色',
            'title' => '汚れを落とし、歯そのものを白く',
            'text'  => '着色汚れの除去と、歯の内側から白くする施術を組み合わせた2ステップで対応します。表面のクリーニングだけでは届かない黄ばみにも、順を追ってアプローチできます。',
            'side'  => 'left',
            'image' => array('whitening-lp-solution01.webp', '微細な気泡で着色汚れを浮かせて落とすイメージ', 1378, 1141),
            'equip' => array(
                'label' => '使用設備',
                'name'  => 'ウルトラファインバブルクリーニング',
                'text'  => '微細な気泡で着色汚れを浮かせて除去。同時に歯の表面をコーティングし、汚れのつきにくい状態に整えます。',
                'cards' => array(
                    array('汚れを浮かせて落とす',           '歯ブラシでは届かない着色汚れにアプローチ'),
                    array('コーティングし汚れのつきにくい歯に', '気泡のマイナス電荷がプラークや細菌と反発'),
                ),
                'note'  => '',
            ),
        ),
        // ---- バナー（メンテナンスホワイトニング） ----
        array(
            'type'  => 'banner',
            'side'  => 'left',
            'badge' => '富士見台さくら歯科ならでは',
            'title' => 'メンテナンスホワイトニング＋クリーニング',
            'sub'   => '75分ですべて完了',
            'text'  => 'ホワイトニングサロンや一般的な歯科医院のホワイトニングと違い、歯の汚れを落としてからホワイトニング。白さを引き出しやすくなります。ウルトラファインバブル生成時、微細な気泡の周囲に大量のマイナス電荷が帯電。歯の表面に付着し、コーティング機能が働きます。',
            'image' => array('whitening-lp-solution02.webp', '個室の診療室', 3000, 2001),
        ),
        // ---- 02 ----
        array(
            'type'  => 'item',
            'num'   => '02',
            'tag'   => '市販品で変わらなかった',
            'title' => '歯科医院専用の薬剤を使用',
            'text'  => '薬事承認を受けた歯科専用の薬剤と光照射を組み合わせ、市販品とは異なる方法で白さを引き出します。歯科医院でしか扱えない薬剤を、研修を修了した担当者が扱います。',
            'side'  => 'right',
            'image' => array('whitening-lp-solution03.webp', 'ホワイトニング用のマウスピースに薬剤を入れる様子', 1400, 931),
            'equip' => array(
                'label' => '使用設備',
                'name'  => '高性能ホワイトニング薬剤',
                'text'  => '2018年に開発された薬剤を使用。従来の3倍※のホワイトニング効果が報告されています。',
                'cards' => array(
                    array('従来の3倍※のホワイトニング効果', '少ない回数でも白さの変化を実感しやすい'),
                    array('歯科医院でしか扱えない処方',     '市販品とは濃度・組成が異なる'),
                ),
                'note'  => '※注記文言は提供資料より転記（出典・比較条件を要確認）', // TODO：実際の注記文言に差し替え
            ),
        ),
        // ---- 03 ----
        array(
            'type'  => 'item',
            'num'   => '03',
            'tag'   => '痛み・しみるのが不安',
            'title' => 'しみにくさに配慮した薬剤と設定',
            'text'  => '知覚過敏に配慮した薬剤と照射設定を選択します。事前に歯の状態を確認し、必要に応じてケアを行ってから施術へ。施術中の違和感はその場でご相談いただけます。',
            'side'  => 'left',
            'image' => array('whitening-lp-solution04.webp', '照射器を使ってホワイトニングを行うスタッフ', 1400, 933),
            'equip' => array(
                'label' => '使用設備',
                'name'  => 'ハイパワーホワイトニング照射器',
                'text'  => '熱ではなく光の強さに着目して設計された照射器。従来の1.5倍※の放射照度で、薬剤にはたらきかけます。',
                'cards' => array(
                    array('紫外線領域を避けた光を放射', '歯ぐき・唇の日焼けによる黒ずみリスクを抑制'),
                    array('照射中の歯の温度上昇を抑制', '痛みのリスクを抑制'),
                ),
                'note'  => '※各製品添付文書より従来放射照度との比較（2021年）',
            ),
        ),
        // ---- 04 ----
        array(
            'type'  => 'item',
            'num'   => '04',
            'tag'   => '白さが続くか心配',
            'title' => '後戻りまで見据えたケア設計',
            'text'  => 'ホームケア用品と定期メンテナンスを組み合わせ、施術後の白さを保つプランをご提案します。後戻りの程度や通院間隔の目安も、あわせてお伝えします。',
            'side'  => 'right',
            'image' => array('whitening-lp-solution05.webp', 'ホワイトニング用の歯みがき粉と歯ブラシ', 1400, 933),
            'equip' => array(
                'label' => '使用設備',
                'name'  => '3Dレーザーカットマウスピース',
                'text'  => 'レーザーで精密にカットしたマウスピース。表面の微細な凹凸がジェルを均一に広げ、歯に密着させます。',
                'cards' => array(
                    array('ジェル保持力1.7倍※アップ', 'ジェルが均一に分布し、歯の表面に密着'),
                    array('効果の秘密は表面の微細な凹凸', '自宅でのケアを無理なく続けられる'),
                    array('型がデータとして残る',       'マウスピース再作製時の型取りも不要'),
                ),
                'note'  => '※自社調べ　通常の石膏模型で作ったマウスピースと比較',
            ),
        ),
        // ---- バナー（レザボア構造） ----
        array(
            'type'  => 'banner',
            'side'  => 'right',
            'badge' => 'ホワイトエッセンス特許取得',
            'title' => 'レザボア（液だまり）構造で、薬剤を歯に保持する',
            'sub'   => '',
            'text'  => 'マウスピース内部に無数の小孔や微細な凹凸を設けることで「レザボア（液だまり）」をつくり、薬剤を保持する構造です。薬剤が歯の表面に均一に留まりやすく、色ムラの発生を抑えます。流れ出しや偏りを防いで歯全体に安定して作用し、ホームホワイトニングでも仕上がりを安定させやすくなります。',
            'image' => array('whitening-lp-solution03.webp', 'ホワイトニング用のマウスピース', 1400, 931),
        ),
        // ---- 05 ----
        array(
            'type'  => 'item',
            'num'   => '05',
            'tag'   => '費用・回数がわからない',
            'title' => '料金と通院回数を、事前にご提示',
            'text'  => '目標の白さを確認したうえで、必要な回数と費用の総額をお伝えしてから施術に入ります。追加の費用が発生する場合も、その場でご説明します。',
            'side'  => 'left',
            'image' => array('whitening-lp-solution06.webp', '料金表を見せながら説明するスタッフ', 1400, 933),
            'equip' => array(
                'label' => '使用設備',
                'name'  => '口腔内3Dスキャン',
                'text'  => '口腔内を立体的に記録し、必要な施術回数と費用の見通しを立てやすくします。',
                'cards' => array(), // カードなし（左の説明だけ）
                'note'  => '',
            ),
        ),
        // ---- 06 ----
        array(
            'type'  => 'item',
            'num'   => '06',
            'tag'   => '自分の歯でも白くなる？',
            'title' => '事前に仕上がりを確認できる',
            'text'  => '現在の歯の色を測定し、目指せる白さを事前に確認します。仕上がりのイメージを共有してから始められる、結果保証制度の対象施術です。',
            'side'  => 'right',
            'image' => array('whitening-lp-solution07.webp', '歯の色を測定している女性', 1448, 1086),
            'equip' => array(
                'label' => '使用設備',
                'name'  => 'デジタルティースカラー診断',
                'text'  => '専用機器で歯の色を数値化。日本人平均のA3から、その先のブリーチシェードまで同じ基準で確認できます。',
                'cards' => array(
                    array('目視ではなくデジタルで測定', '室内光の影響を受けにくく、正確に色を記録'),
                    array('目指せる白さを同じ基準で共有', '現在地とゴールを数値で確認してから始められる'),
                ),
                'note'  => '※シェードガイドの表記（A3・B1・ブリーチシェード等）は目安です。到達する白さには個人差があります。',
            ),
        ),
    ),
);

// ソリューション画像を出す（ファイルがなければグレーの枠）
$wl_sol_img = function ($img) use ($wl_img_dir) {
    list($file, $alt, $w, $h) = $img;
    if ($file && file_exists(get_theme_file_path('/img/' . $file))) {
        return '<img class="wl-solution__img" src="' . esc_url($wl_img_dir . $file) . '" alt="' . esc_attr($alt) . '" width="' . (int) $w . '" height="' . (int) $h . '" loading="lazy" decoding="async">';
    }
    return '<span class="wl-solution__placeholder" aria-hidden="true"></span>';
};

/* ----------------------------------------
   ホワイトニングLP：「メニュー（あなたに合う、3つのホワイトニング）」用の値
   ・画像は img フォルダに入れます：whitening-lp-menu01.webp 〜 03.webp（未設置の間はグレーの枠が表示されます）
     右上の花びらは、お悩み・ソリューションと共用：whitening-lp-trouble02.webp
   ・'text' は1行ずつ配列で書きます（PCはこの位置で改行／タブレット・スマホは自動で折り返し）
   ・'accent' を true にすると、タイトルが青紫のグラデーション文字になります
   ・'lower' を true にすると、PCでそのカードだけ少し下がります（真ん中のカード）
   ・画像は array(ファイル名, alt, 横幅, 縦幅)
---------------------------------------- */
$wl_menu = array(
    'en'     => 'MENU',
    'title'  => 'あなたに合う、3つのホワイトニング',
    'lead'   => '（オフィス・ホーム・デュアル）',
    'bgtext' => 'MENU', // 右に大きく敷く、うすい文字
    'petal'  => 'whitening-lp-trouble02.webp', // 右上の花びら（なくても表示は崩れません）
    'items'  => array(
        array(
            'num'    => '01',
            'tag'    => '医院で、プロが白く',
            'title'  => 'オフィスホワイトニング',
            'text'   => array('1回で実感しやすく、短期間で白く。忙しい', '方・イベント前におすすめ。'),
            'image'  => array('whitening-lp-menu01.webp', '専用ライトを当ててホワイトニングを受けている女性', 1400, 933),
            'accent' => false,
            'lower'  => false,
        ),
        array(
            'num'    => '02',
            'tag'    => '自宅で、自分のペースで',
            'title'  => 'ホームホワイトニング',
            'text'   => array('マウスピースで少しずつ。じっくり続けて、', '後戻りしにくい白さに。'),
            'image'  => array('whitening-lp-menu02.webp', 'マウスピースを装着してホームホワイトニングをする女性', 1400, 933),
            'accent' => false,
            'lower'  => true,
        ),
        array(
            'num'    => '03',
            'tag'    => '医院＋自宅で、いちばん白く',
            'title'  => 'デュアルホワイトニング',
            'text'   => array('オフィスとホームの組み合わせ。最も白く、', '長持ちさせたい方に。'),
            'image'  => array('whitening-lp-menu03.webp', '医院でのホワイトニングと、自宅でマウスピースに薬剤を入れる女性', 1400, 933),
            'accent' => true,
            'lower'  => false,
        ),
    ),
);

// メニュー画像を出す（ファイルがなければグレーの枠）
$wl_menu_img = function ($img) use ($wl_img_dir) {
    list($file, $alt, $w, $h) = $img;
    if ($file && file_exists(get_theme_file_path('/img/' . $file))) {
        return '<img class="wl-menu__img" src="' . esc_url($wl_img_dir . $file) . '" alt="' . esc_attr($alt) . '" width="' . (int) $w . '" height="' . (int) $h . '" loading="lazy" decoding="async">';
    }
    return '<span class="wl-menu__placeholder" aria-hidden="true"></span>';
};

// 配列の行を、1行ずつ <span> にして出す（PCだけ行ごとに改行させるため）
$wl_menu_lines = function ($lines) {
    $out = '';
    foreach ((array) $lines as $line) {
        $out .= '<span class="wl-menu__line">' . esc_html($line) . '</span>';
    }
    return $out;
};

/* ----------------------------------------
   ホワイトニングLP：「ブライダル（結婚式・前撮りに）」用の値
   ・画像は img フォルダに入れます：whitening-lp-bridalevent01.webp（花嫁さんの写真・正方形）
     花びらは、お悩み・ソリューション・メニューと共用：whitening-lp-trouble02.webp（なくても表示は崩れません）
   ・'plans' は array(プラン名, 色)。色は gold（ベージュ）／diamond（うすい青）
   ・'timings' は、増減できます
   ・画像は array(ファイル名, alt, 横幅, 縦幅)
---------------------------------------- */
$wl_bridal = array(
    'en'           => 'BRIDAL & EVENT',
    'lead'         => '結婚式・前撮りに',
    'title'        => 'ブライダルホワイトニング',
    'catch'        => array('挙式日から逆算した、', 'あなただけのプラン'),
    'text'         => '挙式・前撮りの日程に合わせて、最短で最も美しい白さへ。お忙しい花嫁・花婿にも、短期集中の「エクスプレスコース」やオフィス施術でしっかり対応します。',
    'plan_label'   => 'おすすめプラン',
    'plans'        => array(
        array('ウエディングスマイルゴールド',   'gold'),
        array('ウエディングスマイルダイヤモンド', 'diamond'),
    ),
    'timing_title' => 'こんなタイミングにも選ばれています',
    'timings'      => array('成人式', '卒業式・入学式', '就活・面接', '同窓会', '記念写真', '接客・営業'),
    'image'        => array('whitening-lp-bridal&event01.webp', 'ブーケを持って微笑む花嫁', 1400, 1400),
    'petal'        => 'whitening-lp-trouble02.webp', // 花びら（なくても表示は崩れません）
);

// ブライダル画像を出す（ファイルがなければグレーの枠）
$wl_bridal_img = function ($img) use ($wl_img_dir) {
    list($file, $alt, $w, $h) = $img;
    if ($file && file_exists(get_theme_file_path('/img/' . $file))) {
        return '<img class="wl-bridal__img" src="' . esc_url($wl_img_dir . $file) . '" alt="' . esc_attr($alt) . '" width="' . (int) $w . '" height="' . (int) $h . '" loading="lazy" decoding="async">';
    }
    return '<span class="wl-bridal__placeholder" aria-hidden="true"></span>';
};

/* ----------------------------------------
   ホワイトニングLP：「ブライダルプラン（挙式までの期間で選ぶ、2つのプラン）」用の値
   ・画像は img フォルダに入れます（未設置の間はグレーの枠が表示されます）
     whitening-lp-bridal-plan01.webp 〜 04.webp（04 は「ダイヤモンド」の3つ目＝ホームホワイトニングの写真）
     花びらは、お悩み・ソリューション・メニュー・ブライダルと共用：whitening-lp-trouble02.webp（なくても表示は崩れません）
   ・'plans' はタブの順です（1つ目が最初に表示されます）。'key' は gold（ベージュ・ピンク）／diamond（青）
   ・'note' は、カードの下に出す注記（空にすると表示されません）
   ・'steps' は array(バッジ, 見出し, 説明, 画像, alt)。増減できます
   ・'shade' は array(表示, 色, 下に出すラベル)。色は 1〜6（黄→白）／avg（日本人平均）／bleach（ブリーチシェード）
---------------------------------------- */
$wl_plan = array(
    'en'            => 'BRIDAL PLAN',
    'title'         => '挙式までの期間で選ぶ、2つのプラン',
    'petal'         => 'whitening-lp-trouble02.webp',
    'flow_title'    => '施術の流れ',
    'content_label' => 'プラン内容',
    'price_label'   => '価格',
    'price_unit'    => '円',
    'price_tax'     => '（税込）',
    'note_sp'       => '※ 価格はホワイトエッセンスのブライダルメニューに基づく参考です。', // スマホだけ、注記のないプランにも出す一文
    // 2つのプランで共通の白さの目安
    'shade'         => array(
        array('C4',  '1',      ''),
        array('A3',  'avg',    '日本人平均'),
        array('D3',  '3',      ''),
        array('C2',  '4',      ''),
        array('A2',  '5',      ''),
        array('B1',  '6',      ''),
        array('040', 'bleach', ''),
        array('020', 'bleach', 'ブリーチシェード'),
        array('010', 'bleach', ''),
    ),
    'plans'         => array(
        // ---- お急ぎの方 ----
        array(
            'key'      => 'gold',
            'tab'      => array('お急ぎの方', '（前日〜1か月以内）'),
            'tag'      => 'お急ぎの方｜前日〜1か月以内',
            'title'    => 'ウエディングスマイル ゴールド【1DAY】',
            'lead'     => '式までに歯を白くしたいけれど、何回も通うのは面倒という方へ。白い歯にかけるのは1日、残りの日は他の美容や式の準備へ。',
            'caption'  => '7〜9段階UPが目指せる → 写真でも映える透明感のある白さへ',
            'contents' => array(
                '歯石・茶渋・細菌膜落とし',
                'ホワイトニング　10分照射×3回',
                'ツヤだし磨き',
            ),
            'price'    => '58,000',
            'note'     => '', // 見本では注記なし。出す場合はここに文言を入れる
            'steps'    => array(
                array('STEP01', '歯石・茶渋・細菌膜落とし', '薬剤が浸透するよう、歯石・茶渋・細菌の膜（バイオフィルム）を除去。歯周病・口臭も予防。', 'whitening-lp-bridal-plan01.webp', '歯石や着色を除去してもらっている女性'),
                array('STEP02', 'ホワイトニング（10分×3回）', '薬剤塗布＋光照射。紫外線を含まない光で、唇・歯茎の黒ずみに配慮して照射します。', 'whitening-lp-bridal-plan02.webp', '照射器でホワイトニングを受けている女性'),
                array('STEP03', 'ツヤだし磨き', 'ナノ粒子ハイドロキシアパタイトで1本1本磨き上げ。白さに加え、透明感・ツヤも追求。', 'whitening-lp-bridal-plan03.webp', '鏡で仕上がりを確認して微笑む女性'),
            ),
        ),
        // ---- 期間がある方 ----
        array(
            'key'      => 'diamond',
            'tab'      => array('期間がある方', '（1か月以上）'),
            'tag'      => '期間がある方｜1か月以上',
            'title'    => 'ウエディングスマイル ダイヤモンド（来院2回）',
            'lead'     => '2回来院いただける方へ。白さをキープできるホームホワイトニング付き。式当日まで輝きを維持できます。',
            'caption'  => '歯石＆茶渋落とし＋オフィス → ホームホワイトニング（ジェル8本）',
            'contents' => array(
                '歯石・茶渋・細菌膜落とし',
                'マウスピースの作製',
                'ホワイトニング　10分照射×3回',
                'ツヤだし磨き',
                'ホームホワイトニングジェル 8本',
            ),
            'price'    => '83,400',
            'note'     => '※ 価格はホワイトエッセンスのブライダルメニューに基づく参考です。',
            'steps'    => array(
                array('来院1回目', '歯石除去／マウスピース作製', '歯をきれいにし、ホームホワイトニング用のマウスピースを作製します。', 'whitening-lp-bridal-plan01.webp', '歯石を除去してもらっている女性'),
                array('来院2回目', 'オフィスホワイトニング', '茶渋・細菌膜除去 → 高性能薬剤でオフィス（10分×3回）→ 研磨。ジェル8本をお渡し。', 'whitening-lp-bridal-plan02.webp', '照射器でホワイトニングを受けている女性'),
                array('式当日まで', 'ホームホワイトニング', 'さらに白く→毎日／白さキープ→週2〜3回。ご自宅で続けて仕上げます。', 'whitening-lp-bridal-plan04.webp', 'ご自宅でマウスピースを使ってホームホワイトニングをする女性'),
            ),
        ),
    ),
);

// ブライダルプランの画像を出す（ファイルがなければグレーの枠）
$wl_plan_img = function ($file, $alt) use ($wl_img_dir) {
    if ($file && file_exists(get_theme_file_path('/img/' . $file))) {
        return '<img class="wl-plan__img" src="' . esc_url($wl_img_dir . $file) . '" alt="' . esc_attr($alt) . '" width="1672" height="941" loading="lazy" decoding="async">';
    }
    return '<span class="wl-plan__placeholder" aria-hidden="true"></span>';
};

/* ----------------------------------------
   ホワイトニングLP：「ご相談（大切な”ハレノヒ”の日程が決まったら、早めのご相談を。）」用の値
   ・画像は img フォルダに入れます：whitening-lp-bridal-consultation01.webp（花嫁さんの写真・縦長でOK／左に表示）
   ・ボタンのリンク先・電話番号は、フッター設定（追従ボタン）の値を使います。
     空欄の場合は、下の 'web_url' / 'tel' の初期値が表示されます
   ・'title' は1行ずつ配列で書きます（PCはこの位置で改行／スマホは自動で折り返し）
     行の中に {br} と書くと、スマホだけその位置で改行します（PCでは改行しません）
---------------------------------------- */
$wl_consult_web = function_exists('get_field') ? (get_field('cta_white_url', 'option') ?: get_field('cta_web_url', 'option')) : '';
$wl_consult_tel = function_exists('get_field') ? get_field('cta_tel', 'option') : '';

$wl_consult = array(
    'en'        => 'BRIDAL CONSULTATION',
    'title'     => array('大切な”ハレノヒ”の{br}日程が決まったら、', '早めのご相談を。'),
    'web_label' => 'WEB予約はこちら',
    'web_url'   => $wl_consult_web ?: '#', // TODO：予約ページのURL（フッター設定が空のときの初期値）
    'tel'       => $wl_consult_tel ?: '03-5848-9373',
    'tel_icon'  => 'whitening-lp-bridal-consultation02.webp', // 電話番号の前のアイコン（未設置の間は、CSSの電話マークが表示されます）
    'image'     => array('whitening-lp-bridal-consultation01.webp', 'ブーケとベールをつけて振り返り、微笑む花嫁', 1122, 1402),
);

// ご相談の画像を出す（ファイルがなければグレーの枠）
$wl_consult_img = function ($img) use ($wl_img_dir) {
    list($file, $alt, $w, $h) = $img;
    if ($file && file_exists(get_theme_file_path('/img/' . $file))) {
        return '<img class="wl-consult__img" src="' . esc_url($wl_img_dir . $file) . '" alt="' . esc_attr($alt) . '" width="' . (int) $w . '" height="' . (int) $h . '" loading="lazy" decoding="async">';
    }
    return '<span class="wl-consult__placeholder" aria-hidden="true"></span>';
};

// 配列の行を、1行ずつ <span> にして出す（PCだけ行ごとに改行させるため）
$wl_consult_lines = function ($lines) {
    $out = '';
    foreach ((array) $lines as $line) {
        // {br} は、スマホだけ効く改行（PCでは CSS で消します）
        $out .= '<span class="wl-consult__line">' . str_replace('{br}', '<br class="wl-consult__br">', esc_html($line)) . '</span>';
    }
    return $out;
};

/* ----------------------------------------
   ホワイトニングLP：「保証（白さに、結果保証。）」用の値
   ・画像は img フォルダに入れます：whitening-lp-guarantee01.webp 〜 03.webp（円形のアイコン・正方形）
     （未設置の間は、うすい円の枠が表示されます）
   ・'items' は増減できます（PCは3列。件数が違うときは、CSS（.wl-guarantee__list）の列数も合わせてください）
   ・'notes' は下の注記（空にすると表示されません）
   ・条件文言は見本から転記したものです。公開前に、実際の保証条件と合っているか確認してください
---------------------------------------- */
$wl_guarantee = array(
    'en'     => 'GUARANTEE',
    'title'  => '白さに、結果保証。',
    'sub'    => 'だから安心してはじめられる',
    // array(バッジ, 見出し, 説明, アイコン画像, alt)
    'items'  => array(
        array('追加無料',     'ブリーチシェード未達なら追加無料※1', 'コース終了時にブリーチシェードへ到達しなかった場合、追加でホワイトニングを無料で行います。', 'whitening-lp-guarantee01.webp', '歯に＋マークのアイコン'),
        array('全額返金',     '全額返金保証※2',                     '初回施術で白さをご実感いただけなかった場合、翌営業日までのご連絡で全額返金します。',         'whitening-lp-guarantee02.webp', '円マークと返金の矢印のアイコン'),
        array('中途解約OK',   '中途解約制度',                       '通えなくなった場合も中途解約が可能です（所定の解約手数料がかかります）。',                   'whitening-lp-guarantee03.webp', 'カレンダーとチェックマークのアイコン'),
    ),
    'notes'  => array(
        '※1 ホワイトエッセンスコースをご利用の方が対象です。所定の通院回数・期間などの条件を満たした場合に限ります。',
        '※2 他院での施術を含め、ホワイトニングが初めての方に限ります。',
    ),
);

// 保証のアイコン画像を出す（ファイルがなければ、うすい円の枠）
$wl_guarantee_img = function ($file, $alt) use ($wl_img_dir) {
    if ($file && file_exists(get_theme_file_path('/img/' . $file))) {
        return '<img class="wl-guarantee__img" src="' . esc_url($wl_img_dir . $file) . '" alt="' . esc_attr($alt) . '" width="311" height="311" loading="lazy" decoding="async">';
    }
    return '<span class="wl-guarantee__placeholder" aria-hidden="true"></span>';
};

/* ----------------------------------------
   ホワイトニングLP：「料金（ホワイトニングのメニュー・料金一覧）」用の値
   ・'rows' は array(メニュー名, 料金)。増減できます（奇数行は白、偶数行はうすい色で交互に表示されます）
   ・'cards' は右側のカード。'example' は空にすると表示されません
   ・料金・条件文言は見本から転記したものです。公開前に、実際の料金表と合っているか確認してください
---------------------------------------- */
$wl_price = array(
    'en'         => 'PRICE',
    'title'      => 'ホワイトニングのメニュー・料金一覧',
    'lead'       => '主なメニューです（税込）。デンタルクレジットは12回まで金利手数料0%。',
    'th_menu'    => 'メニュー',
    'th_price'   => '料金（税込）',
    'rows'       => array(
        array('ホワイトエッセンスコース（オフィス3回＋ホーム＋クリーニング）', '¥118,800'),
        array('ホワイトエッセンスコース ライト',                             '¥79,000'),
        array('ホワイトエッセンスコース エクスプレス（速攻・1ヶ月）',         '¥118,800'),
        array('オフィスホワイトニング プロ',                                 '¥19,900'),
        array('オフィスホワイトニング プロプラス',                           '¥25,400'),
        array('ホームホワイトニング スターターキット',                       '¥19,900'),
    ),
    'note'       => '※ 表示は税込。デュアル・パーソナルチケット等の詳細は料金表をご覧ください。',
    'side_title' => 'お支払い・解約について',
    // array(見出し, 説明, 例（なければ空）)
    'cards'      => array(
        array(
            'デンタルクレジット',
            '12回まで金利手数料0%（当院負担）。月々のお支払いで無理なくはじめられます。',
            '例）ホワイトエッセンスコース ¥118,800 → 月々9,900円（12回）',
        ),
        array(
            '中途解約・クーリングオフ',
            '契約日から8日以内はクーリングオフが可能。お客様都合で通えなくなった場合も中途解約いただけます（返金額＝支払済額−受けた施術分−ホームケア用品代−所定の解約手数料）。',
            '',
        ),
    ),
);

/* ----------------------------------------
   ホワイトニングLP：「流れ（ホワイトニングの流れ）」用の値
   ・画像は img フォルダに入れます：whitening-lp-flow01.webp 〜 05.webp（未設置の間はグレーの枠が表示されます）
   ・'steps' は増減できます（番号は自動で 01, 02… と振られます。PCは5列。件数が違うときは、
     CSS（.wl-flow__list）の列数も合わせてください）
   ・画像は array(ファイル名, alt, 横幅, 縦幅, 写真の見せる位置)。
     見せる位置は CSS の object-position の値（切り抜かれる位置を調整したいときに変えます）
---------------------------------------- */
$wl_flow = array(
    'en'     => 'FLOW',
    'title'  => 'ホワイトニングの流れ',
    'bgtext' => 'FLOW', // 右に大きく敷く、うすい文字
    'steps'  => array(
        array(
            'title' => 'カウンセリング',
            'text'  => '歯の状態とご希望を確認し、最適なプランをご提案。',
            'image' => array('whitening-lp-flow01.webp', 'カウンセリングでプランを説明するスタッフ', 2000, 1334, '34% 50%'),
        ),
        array(
            'title' => 'クリーニング',
            'text'  => '着色や汚れを落とし、効果を高めます。',
            'image' => array('whitening-lp-flow02.webp', '歯科医師とスタッフがクリーニングを行う様子', 1400, 933, '38% 50%'),
        ),
        array(
            'title' => 'ホワイトニング施術',
            'text'  => '薬剤の塗布と光の照射で歯を白く。',
            'image' => array('whitening-lp-flow03.webp', 'ホワイトニングの施術を受ける女性', 1536, 1024, '50% 50%'),
        ),
        array(
            'title' => '仕上げ・確認',
            'text'  => '白さを確認し、コーティングで仕上げ。',
            'image' => array('whitening-lp-flow04.webp', '鏡で白くなった歯を確認して微笑む女性', 1671, 941, '42% 50%'),
        ),
        array(
            'title' => 'アフターケア',
            'text'  => '白さの維持方法と次回をご案内。',
            'image' => array('whitening-lp-flow05.webp', '歯科医師がモニターを見ながら説明する様子', 2000, 1334, '50% 50%'),
        ),
    ),
);

// 流れの写真を出す（ファイルがなければグレーの枠）
$wl_flow_img = function ($img) use ($wl_img_dir) {
    list($file, $alt, $w, $h, $pos) = $img;
    if ($file && file_exists(get_theme_file_path('/img/' . $file))) {
        return '<img class="wl-flow__img" src="' . esc_url($wl_img_dir . $file) . '" alt="' . esc_attr($alt) . '" width="' . (int) $w . '" height="' . (int) $h . '" style="object-position: ' . esc_attr($pos) . '" loading="lazy" decoding="async">';
    }
    return '<span class="wl-flow__placeholder" aria-hidden="true"></span>';
};

/* ----------------------------------------
   ホワイトニングLP：「オプション（ホワイトニングと一緒に）」用の値
   ・画像は img フォルダに入れます：whitening-lp-option01.webp 〜 06.webp（未設置の間はグレーの枠が表示されます）
   ・'items' は増減できます（PCは3列。件数が違うときは、CSS（.wl-option__list）の列数も合わせてください）
   ・画像は array(ファイル名, alt, 横幅, 縦幅, 写真の見せる位置)。
     見せる位置は CSS の object-position の値（横長に切り抜かれる位置を調整したいときに変えます）
   ・各項目の 'url' に、カード全体のリンク先を入れてください（6つとも別々のURLにできます。空欄のときは '#' になります）
   ・下の「デンタルエステを詳しくみる」ボタンのリンク先は、'btn_url' を差し替えてください
---------------------------------------- */
$wl_option = array(
    'en'        => 'OPTION',
    'bgtext'    => 'OPTION', // 左下に大きく敷く、うすい文字
    'title'     => 'ホワイトニングと一緒に',
    'sub'       => 'クリーニング・口元ビューティ',
    'items'     => array(
        array(
            'title' => 'オーラルスパクリーニング',
            'url'   => '#', // TODO：リンク先URL（1番目）
            'image' => array('whitening-lp-option01.webp', '女性にオーラルスパクリーニングを行う様子', 1448, 1086, '50% 50%'),
        ),
        array(
            'title' => 'UFB（ウルトラファインバブル）クリーニング',
            'url'   => '#', // TODO：リンク先URL（2番目）
            'image' => array('whitening-lp-option02.webp', '微細な泡で歯をクリーニングするイメージ', 1448, 1086, '50% 50%'),
        ),
        array(
            'title' => 'オーラルリフレクソロジー',
            'url'   => '#', // TODO：リンク先URL（3番目）
            'image' => array('whitening-lp-option03.webp', '顔まわりのマッサージを受けてリラックスする女性', 1448, 1086, '50% 50%'),
        ),
        array(
            'title' => '歯ぐきピーリング・リップエステ',
            'url'   => '#', // TODO：リンク先URL（4番目）
            'image' => array('whitening-lp-option04.webp', '口元のケアを受ける女性', 1448, 1086, '50% 50%'),
        ),
        array(
            'title' => '歯周病菌DNA検査・むし歯検査',
            'url'   => '#', // TODO：リンク先URL（5番目）
            'image' => array('whitening-lp-option05.webp', '歯周病菌DNA検査のキットと検査結果のイメージ', 1448, 1086, '50% 50%'),
        ),
        array(
            'title' => 'ホームケア用品（歯磨き粉・歯ブラシ 等）',
            'url'   => '#', // TODO：リンク先URL（6番目）
            'image' => array('whitening-lp-option06.webp', 'ホームケア用の歯ブラシ・歯磨き粉・マウスウォッシュ', 1448, 1086, '50% 50%'),
        ),
    ),
    'btn_label' => 'デンタルエステを詳しくみる',
    'btn_url'   => '#', // TODO：デンタルエステのページのURL
);

// オプションの写真を出す（ファイルがなければグレーの枠）
$wl_option_img = function ($img) use ($wl_img_dir) {
    list($file, $alt, $w, $h, $pos) = $img;
    if ($file && file_exists(get_theme_file_path('/img/' . $file))) {
        return '<img class="wl-option__img" src="' . esc_url($wl_img_dir . $file) . '" alt="' . esc_attr($alt) . '" width="' . (int) $w . '" height="' . (int) $h . '" style="object-position: ' . esc_attr($pos) . '" loading="lazy" decoding="async">';
    }
    return '<span class="wl-option__placeholder" aria-hidden="true"></span>';
};

/* ----------------------------------------
   ホワイトニングLP：「お問い合わせ（まずはカウンセリングから、はじめませんか？）」用の値
   ・花びらは、お悩み・ソリューションなどと共用：whitening-lp-trouble02.webp（なくても表示は崩れません）
   ・ボタンのリンク先・電話番号・電話アイコンは、「ご相談」セクション（$wl_consult）と同じ値を使います
     （フッター設定の値 → なければ $wl_consult の初期値）
   ・'title' は1行ずつ配列で書きます（PCはこの位置で改行／スマホは自動で折り返し）
---------------------------------------- */
$wl_contact = array(
    'en'        => 'CONTACT',
    'title'     => array('まずはカウンセリングから、', 'はじめませんか？'),
    'lead'      => array('あなたの歯や希望に合わせて、', '最適な白さのプランをご提案します。'),
    'web_label' => $wl_consult['web_label'],
    'web_url'   => $wl_consult['web_url'],
    'tel'       => $wl_consult['tel'],
    'tel_icon'  => $wl_consult['tel_icon'],
    'petal'     => 'whitening-lp-trouble02.webp',
);

// 配列の行を、1行ずつ <span> にして出す
$wl_contact_lines = function ($lines, $class = 'wl-contact__line') {
    $out = '';
    foreach ((array) $lines as $line) {
        $out .= '<span class="' . esc_attr($class) . '">' . esc_html($line) . '</span>';
    }
    return $out;
};

/* ----------------------------------------
   ホワイトニングLP：「院長紹介（DOCTOR）」用の値
   ・画像は img フォルダに入れます：whitening-lp-doctor01.webp（院長の写真・未設置の間はグレーの枠が表示されます）
   ・画像は array(ファイル名, alt, 横幅, 縦幅, 写真の見せる位置)。
     見せる位置は CSS の object-position の値（縦長に切り抜かれる位置を調整したいときに変えます）
   ・'credentials' は、白いカプセルの中に「／」でつないで並べます（増減できます）
   ・紹介文は、見本から転記したものです。公開前に、実際の内容と合っているか確認してください
---------------------------------------- */
$wl_doctor = array(
    'en'          => 'DOCTOR',
    'bgtext'      => 'DOCTOR', // 右に大きく敷く、うすい文字
    'title'       => '院長紹介',
    'sub'         => '東京医科歯科大学出身の歯学博士',
    'name'        => array('院長', '芳賀 浩昭', '（はが ひろあき）'),
    'text'        => '「自分の笑顔で、多くの人を幸せにする」──これが私のビジョンです。ホワイトエッセンスの理念『笑顔創造産業』に共感し、当院を開業しました。統一された品質の施術はもちろん、接遇・ホスピタリティ・感染防止・滅菌体制を高いレベルで徹底。スタッフ一同、患者様をファミリーのようにお迎えし、ご自宅でくつろぐような感覚で受けていただけるよう努めています。',
    'credentials' => array('歯学博士', '日本口腔インプラント学会 認定専門医', '東京医科歯科大学出身'),
    'image'       => array('whitening-lp-doctor01.webp', 'モニターを見ながら説明する院長', 1400, 933, '10% 50%'),
);

// 院長の写真を出す（ファイルがなければグレーの枠）
$wl_doctor_img = function ($img) use ($wl_img_dir) {
    list($file, $alt, $w, $h, $pos) = $img;
    if ($file && file_exists(get_theme_file_path('/img/' . $file))) {
        return '<img class="wl-doctor__img" src="' . esc_url($wl_img_dir . $file) . '" alt="' . esc_attr($alt) . '" width="' . (int) $w . '" height="' . (int) $h . '" style="object-position: ' . esc_attr($pos) . '" loading="lazy" decoding="async">';
    }
    return '<span class="wl-doctor__placeholder" aria-hidden="true"></span>';
};

/* ----------------------------------------
   ホワイトニングLP：「よくあるご質問（FAQ）」用の値
   ・'items' は array(質問, 回答)。増減できます
   ・'open' は、最初から開いておく質問の番号（0から数えます。-1 にすると全部閉じた状態）
   ・※2問目以降の回答文は仮の文言です。公開前に、実際の対応・内容に合わせて差し替えてください（TODO）
---------------------------------------- */
$wl_faq = array(
    'en'     => 'FAQ',
    'bgtext' => 'FAQ', // 左下に大きく敷く、うすい文字
    'title'  => array('ホワイトニングの', 'よくあるご質問'),
    'open'   => 0,
    'items'  => array(
        array('ホワイトニングは痛いですか？', '施術中や施術後に一時的な知覚過敏（しみる感覚）が生じることがありますが、通常は数日でおさまります。'),
        array('白さはどのくらい持続しますか？', 'テキスト'),
        array('何回くらいで白くなりますか？', 'テキスト'),
        array('妊娠中・授乳中でも受けられますか？', 'テキスト'),
        array('差し歯や詰め物も白くなりますか？', 'テキスト'),
        array('食事に制限はありますか？', 'テキスト'),
    ),
);

/* ----------------------------------------
   ホワイトニングLP：「注意点・副作用（NOTES）」用の値
   ・'items' は array(見出し, 説明)。増減できます（PCは2列。奇数のときは最後が左に1つ残ります）
   ・文言は見本から転記したものです。公開前に、実際の内容と合っているか確認してください
---------------------------------------- */
$wl_notes = array(
    'en'    => 'NOTES',
    'title' => 'ホワイトニングの注意点・副作用',
    // 左の丸の中の「!」は、CSSの疑似要素（.wl-notes__icon::before）で出しています
    'items' => array(
        array('知覚過敏',           '施術中・施術後に一時的に歯がしみることがあります。'),
        array('後戻り',             '時間の経過とともに色は戻るため、定期的なメンテナンスが必要です。'),
        array('適応外の方',         '無カタラーゼ症の方、妊娠中・授乳中の方は受けられません。'),
        array('人工の歯は白くならない', '差し歯・詰め物・被せ物などの人工物は白くなりません。'),
    ),
);

/* ----------------------------------------
   ホワイトニングLP：「診療時間・アクセス（ACCESS）」用の値
   ・'info' は array(見出し, 内容)。増減できます
   ・'hours' は array(時間帯, 各曜日の記号)。記号は o＝診療（●）／t＝祝日のある週のみ（▲）／x＝休診（－）
     曜日の並びは 'days' と同じ（月〜日）です
   ・Googleマップ：'map_src' が空のときは、'address'（住所）から地図を自動で作ります。
     ピンの位置を正確にしたいときは、Googleマップの［共有］→［地図を埋め込む］で出てくる
     <iframe src="…"> の src の URL を 'map_src' に貼ってください
   ・住所・電話番号・診療時間は見本から転記したものです。公開前に、実際の内容と合っているか確認してください
---------------------------------------- */
$wl_access = array(
    'en'          => 'ACCESS',
    'bgtext'      => 'ACCESS', // 右に大きく敷く、うすい文字
    'title'       => '診療時間・アクセス',
    'sub'         => '富士見台駅 徒歩3分',
    'catch'       => '富士見台駅 徒歩3分・平日も毎日診療',
    'name'        => '富士見台さくら歯科',
    'postal'      => '〒165-0031',
    'address'     => '東京都中野区上鷺宮3-16-9',
    'info'        => array(
        array('住所',     '〒165-0031 東京都中野区上鷺宮3-16-9'),
        array('TEL',      "TEL 03-5848-9373（外来）／\n03-5848-8484（訪問）"),
        array('アクセス', '西武池袋線「富士見台駅」より徒歩3分（千川通り沿い）'),
    ),
    'hours_title' => '診療時間',
    'hours_th'    => '時間',
    'days'        => array('月', '火', '水', '木', '金', '土', '日'),
    'hours'       => array(
        array('9:00–12:00',  array('o', 'o', 'o', 'o', 'o', 'o', 'x')),
        array('13:00–18:00', array('o', 'o', 'o', 't', 'o', 'o', 'x')),
    ),
    'marks'       => array('o' => '診療', 't' => '祝日のある週のみ診療', 'x' => '休診'),
    'hours_note'  => '※木曜午後（▲）は祝日のある週のみ／休診：日曜・祝日',
    'map_src'     => '', // 空なら住所から自動作成（上の説明を参照）
    'map_title'   => '富士見台さくら歯科の地図',
);
$wl_access_map = $wl_access['map_src'] ?: ('https://www.google.com/maps?q=' . rawurlencode($wl_access['postal'] . ' ' . $wl_access['address'] . ' ' . $wl_access['name']) . '&output=embed&hl=ja&z=17');

/* ----------------------------------------
   ホワイトニングLP：「最後のご相談（まずはお気軽にご相談ください！）」用の値
   ・花びらは、お悩み・ソリューションなどと共用：whitening-lp-trouble02.webp（なくても表示は崩れません）
   ・ボタンのリンク先・電話番号・電話アイコンは、「ご相談」セクション（$wl_consult）と同じ値を使います
     （フッター設定の値 → なければ $wl_consult の初期値）
   ・'points' は array(見出し, ひとこと)。PCは3列です（件数が違うときは、CSS（.wl-cta__list）の列数も合わせてください）
   ・文言は見本から転記したものです。公開前に、実際の内容と合っているか確認してください
---------------------------------------- */
$wl_cta = array(
    'title'     => "まずはお気軽に\nご相談ください！",
    'lead'      => 'あなたに合う白さのプランを、カウンセリングでご提案します。',
    'points'    => array(
        array('ホワイトエッセンス提携医院', '専門ブランドの品質で施術'),
        array('白さに、結果保証',           '未達なら追加無料／返金保証'),
        array('豊富なメニューから選べる',   'オフィス・ホーム・デュアル'),
    ),
    'web_label' => $wl_consult['web_label'],
    'web_url'   => $wl_consult['web_url'],
    'tel'       => $wl_consult['tel'],
    'tel_icon'  => $wl_consult['tel_icon'],
    'petal'     => 'whitening-lp-trouble02.webp',
);
?>

<section class="wl-mv" id="mv">
    <!-- 背景（女性の写真）。PCは横長、スマホは顔まわりを中心に表示 -->
    <div class="wl-mv__bg" aria-hidden="true">
        <!-- スマホ（〜768px）は縦長の写真（whitening-lp-mv-bg-sp.webp：750×760）、PCは横長 -->
        <picture>
            <source media="(max-width: 768px)" srcset="<?php echo esc_url($wl_img_dir . 'whitening-lp-mv-bg-sp.webp'); ?>" width="750" height="760">
            <img class="wl-mv__bg-img"
                 src="<?php echo esc_url($wl_img_dir . 'whitening-lp-mv-bg.png'); ?>"
                 alt="" width="2000" height="1124" fetchpriority="high" decoding="async">
        </picture>
    </div>

    <!-- 飾り（スマホのみ表示）：花びら2枚＋細い白い丸2つ＋小さな光の点。写真の上・文字の下に重なる -->
    <div class="wl-mv__deco" aria-hidden="true">
        <span class="wl-mv__ring wl-mv__ring--a"></span>
        <span class="wl-mv__ring wl-mv__ring--b"></span>
        <span class="wl-mv__dot wl-mv__dot--a"></span>
        <span class="wl-mv__dot wl-mv__dot--b"></span>
        <span class="wl-mv__dot wl-mv__dot--c"></span>
        <span class="wl-mv__dot wl-mv__dot--d"></span>
        <?php if (file_exists(get_theme_file_path('/img/whitening-lp-trouble01.webp'))) : ?>
            <img class="wl-mv__petal wl-mv__petal--a" src="<?php echo esc_url($wl_img_dir . 'whitening-lp-trouble01.webp'); ?>" alt="" width="58" height="64" decoding="async">
        <?php endif; ?>
        <?php if (file_exists(get_theme_file_path('/img/whitening-lp-trouble02.webp'))) : ?>
            <img class="wl-mv__petal wl-mv__petal--b" src="<?php echo esc_url($wl_img_dir . 'whitening-lp-trouble02.webp'); ?>" alt="" width="88" height="104" decoding="async">
        <?php endif; ?>
    </div>

    <div class="wl-mv__inner">
        <div class="wl-mv__body">
            <p class="wl-mv__eyebrow wl-anim" style="--d: 0s">
                <span class="wl-mv__eyebrow-en"><?php echo esc_html($wl_mv['brand']); ?></span>
                <span class="wl-mv__eyebrow-ja"><?php echo esc_html($wl_mv['partner']); ?></span>
                <span class="wl-mv__eyebrow-line" aria-hidden="true"></span>
                <span class="wl-mv__eyebrow-en wl-mv__eyebrow-en--wide"><?php echo esc_html($wl_mv['label']); ?></span>
            </p>

            <!-- h1：富士見台・中野区のホワイトニング｜富士見台さくら歯科（「｜」は読み上げ用） -->
            <h1 class="wl-mv__lead wl-anim" style="--d: .1s">
                <span class="wl-mv__lead-main"><?php foreach ((array) $wl_mv['lead'] as $lead_line) : ?><span class="wl-mv__lead-line"><?php echo esc_html($lead_line); ?></span><?php endforeach; ?></span>
                <span class="wl-mv__sr">｜</span>
                <span class="wl-mv__lead-clinic"><?php echo esc_html($wl_mv['clinic']); ?></span>
            </h1>

            <!-- キャッチコピー（見出しにしない） -->
            <p class="wl-mv__title wl-anim" style="--d: .2s">
                <span class="wl-mv__title-line"><span class="is-l">理想</span><span class="is-s">の</span><span class="is-l">白</span><span class="is-s">さと、</span></span>
                <span class="wl-mv__title-line"><span class="is-l">続</span><span class="is-s">く</span><span class="is-l">自信</span><span class="is-s">を。</span></span>
            </p>

            <div class="wl-mv__guarantee wl-anim" style="--d: .35s">
                <p class="wl-mv__guarantee-label"><?php echo $wl_br($wl_mv['guarantee']); ?></p>
                <ul class="wl-mv__badges">
                    <?php foreach ($wl_mv['badges'] as $badge) : ?>
                        <li class="wl-mv__badge">
                            <img class="wl-mv__badge-bg" src="<?php echo esc_url($wl_img_dir . 'whitening-lp-mv03.webp'); ?>" alt="" width="304" height="304" decoding="async" aria-hidden="true">
                            <span><?php echo $wl_br($badge); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <small class="wl-mv__note wl-anim" style="--d: .4s"><?php echo esc_html($wl_mv['guarantee_note']); ?></small>

            <div class="wl-mv__result wl-anim" style="--d: .5s">
                <div class="wl-mv__result-head">
                    <span class="wl-mv__result-label"><?php echo esc_html($wl_mv['result_label']); ?></span>
                    <p class="wl-mv__result-main">
                        <span class="wl-mv__result-num" data-countup="<?php echo esc_attr($wl_mv['result_number']); ?>"><?php echo esc_html($wl_mv['result_number']); ?></span>
                        <span class="wl-mv__result-unit"><?php echo esc_html($wl_mv['result_unit']); ?></span>
                    </p>
                </div>
                <p class="wl-mv__result-note"><?php echo $wl_br($wl_mv['result_note']); ?></p>
            </div>
        </div>
    </div>
</section>

<!-- ============ 症例（Before/After） ============ -->
<section class="wl-case" id="case">
    <span class="wl-case__bgtext" aria-hidden="true"><?php echo esc_html($wl_case['en']); ?></span>

    <div class="wl-case__inner">
        <header class="wl-case__head">
            <p class="wl-case__en"><span><?php echo esc_html($wl_case['en']); ?></span></p>
            <h2 class="wl-case__title"><?php echo esc_html($wl_case['title']); ?><span class="wl-case__title-sub"><?php echo esc_html($wl_case['title_sub']); ?></span></h2>
            <p class="wl-case__lead"><?php echo esc_html($wl_case['lead']); ?></p>
        </header>

        <div class="wl-case__body">
            <!-- 左：Before/After スライダー -->
            <div class="wl-case__viewer" data-case-viewer>
                <div class="wl-case__slides">
                    <?php foreach ($wl_case['items'] as $i => $item) : ?>
                        <div class="wl-case__slide<?php echo $i === 0 ? ' is-active' : ''; ?>" data-case-slide<?php echo $i === 0 ? '' : ' aria-hidden="true"'; ?>>
                            <div class="wl-case__compare" data-compare style="--pos: 50%">
                                <div class="wl-case__layer wl-case__layer--after"><?php echo $wl_case_img($item['after'], $item['alt'] . '：施術後'); ?></div>
                                <div class="wl-case__layer wl-case__layer--before"><?php echo $wl_case_img($item['before'], $item['alt'] . '：施術前'); ?></div>
                                <span class="wl-case__tag wl-case__tag--before">BEFORE</span>
                                <span class="wl-case__tag wl-case__tag--after">AFTER</span>
                                <button class="wl-case__handle" type="button" role="slider" aria-label="施術前後の境目を動かす" aria-valuemin="0" aria-valuemax="100" aria-valuenow="50" data-handle>
                                    <span class="wl-case__knob" aria-hidden="true">
                                        <svg width="26" height="12" viewBox="0 0 26 12" fill="#fff"><path d="M0 6 10 0v12zM26 6 16 0v12z"/></svg>
                                    </span>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if ($wl_case_count > 1) : ?>
                    <button class="wl-case__nav wl-case__nav--prev" type="button" aria-label="前の症例" data-case-prev>
                        <svg width="8" height="14" viewBox="0 0 8 14" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M7 1 1 7l6 6"/></svg>
                    </button>
                    <button class="wl-case__nav wl-case__nav--next" type="button" aria-label="次の症例" data-case-next>
                        <svg width="8" height="14" viewBox="0 0 8 14" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M1 1l6 6-6 6"/></svg>
                    </button>
                <?php endif; ?>
            </div>

            <!-- 右：施術の内容 -->
            <dl class="wl-case__info">
                <?php foreach ($wl_case['info'] as $row) : ?>
                    <div class="wl-case__row">
                        <dt><?php echo esc_html($row[0]); ?></dt>
                        <dd<?php echo !empty($row[2]) ? ' class="is-strong"' : ''; ?>><?php echo esc_html($row[1]); ?></dd>
                    </div>
                <?php endforeach; ?>
            </dl>

            <!-- 注記：スマホ・タブレットでは画像と表のあいだに表示（CSSの grid-area で並べ替え） -->
            <small class="wl-case__note"><?php echo esc_html($wl_case['note']); ?></small>
        </div>
    </div>
</section>

<!-- ============ ホワイトニングとは ============ -->
<section class="wl-about" id="about">
    <div class="wl-about__bg" aria-hidden="true">
        <!-- スマホ（〜768px）は専用の写真（whitening-lp-about01-sp.webp：750×540）、PCは横長 -->
        <picture>
            <source media="(max-width: 768px)" srcset="<?php echo esc_url($wl_img_dir . 'whitening-lp-about01-sp.webp'); ?>" width="750" height="540">
            <img class="wl-about__bg-img"
                 src="<?php echo esc_url($wl_img_dir . 'whitening-lp-about01.webp'); ?>"
                 alt="" width="2576" height="1448" loading="lazy" decoding="async">
        </picture>
    </div>

    <div class="wl-about__inner">
        <div class="wl-about__body">
            <p class="wl-about__en"><span><?php echo esc_html($wl_about['en']); ?></span></p>
            <h2 class="wl-about__title"><?php echo esc_html($wl_about['title']); ?></h2>
            <p class="wl-about__sub"><?php echo esc_html($wl_about['sub']); ?></p>
            <h3 class="wl-about__catch"><?php echo implode('<br>', array_map(function ($line) { return implode('<span class="wl-about__catch-br"></span>', array_map('esc_html', explode('|', $line))); }, (array) $wl_about['catch'])); ?></h3>

            <div class="wl-about__texts">
                <?php foreach ($wl_about['texts'] as $text) : ?>
                    <p><?php echo esc_html($text); ?></p>
                <?php endforeach; ?>
            </div>

            <ul class="wl-about__points">
                <?php foreach ($wl_about['points'] as $i => $point) : ?>
                    <li class="wl-about__point">
                        <span class="wl-about__icon">
                            <img src="<?php echo esc_url($wl_img_dir . $point[0]); ?>" alt="" width="64" height="64" loading="lazy" decoding="async">
                            <span class="wl-about__num" aria-hidden="true"><?php echo esc_html($i + 1); ?></span>
                        </span>
                        <div class="wl-about__point-body">
                            <h4 class="wl-about__point-title"><?php echo implode('<span class="wl-about__point-br"></span>', array_map('esc_html', explode('|', $point[1]))); ?></h4>
                            <span class="wl-about__point-text"><?php echo esc_html($point[2]); ?></span>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>

<!-- ============ シミュレーション（歯の白さで印象が変わる） ============ -->
<section class="wl-sim" id="simulation">
    <span class="wl-sim__bgtext" aria-hidden="true"><?php echo esc_html($wl_sim['en']); ?></span>

    <div class="wl-sim__inner">
        <header class="wl-sim__head">
            <p class="wl-sim__en"><span><?php echo esc_html($wl_sim['en']); ?></span></p>
            <h2 class="wl-sim__title"><?php echo str_replace('、', '、<br class="wl-sim__br">', esc_html($wl_sim['title'])); ?></h2>
            <p class="wl-sim__lead"><?php echo esc_html($wl_sim['lead']); ?></p>
        </header>

        <div class="wl-sim__compare">
            <!-- 施術前 -->
            <figure class="wl-sim__item wl-sim__item--before">
                <div class="wl-sim__photo"><?php echo $wl_sim_img($wl_sim['before'][0], $wl_sim['before'][3]); ?></div>
                <span class="wl-sim__tag"><?php echo esc_html($wl_sim['before'][1]); ?></span>
                <figcaption class="wl-sim__caption"><?php echo esc_html($wl_sim['before'][2]); ?></figcaption>
            </figure>

            <span class="wl-sim__arrow" aria-hidden="true">
                <svg width="24" height="10" viewBox="0 0 24 10" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M1 5h21M18 1l4 4-4 4"/></svg>
            </span>

            <!-- 施術後 -->
            <figure class="wl-sim__item wl-sim__item--after">
                <div class="wl-sim__photo"><?php echo $wl_sim_img($wl_sim['after'][0], $wl_sim['after'][3]); ?></div>
                <span class="wl-sim__tag"><?php echo esc_html($wl_sim['after'][1]); ?></span>
                <figcaption class="wl-sim__caption"><?php echo esc_html($wl_sim['after'][2]); ?></figcaption>
            </figure>
        </div>

        <!-- 白さの目安バー -->
        <div class="wl-sim__shade">
            <div class="wl-sim__shade-head">
                <span class="wl-sim__shade-left"><?php echo esc_html($wl_sim['shade']['left']); ?></span>
                <span class="wl-sim__shade-right"><?php echo esc_html($wl_sim['shade']['right']); ?></span>
            </div>
            <?php if (file_exists(get_theme_file_path('/img/whitening-lp-simulation03.webp'))) : ?>
                <img class="wl-sim__bar wl-sim__bar--img" src="<?php echo esc_url($wl_img_dir . 'whitening-lp-simulation03.webp'); ?>" alt="" width="1804" height="48" loading="lazy" decoding="async" aria-hidden="true">
            <?php endif; ?>
            <div class="wl-sim__bar" aria-hidden="true"></div>
            <ul class="wl-sim__steps">
                <?php foreach ($wl_sim['shade']['steps'] as $step) : ?>
                    <li><?php echo esc_html($step); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>

<!-- ============ 結果（一番人気コースの90%以上がブリーチシェードに到達） ============ -->
<section class="wl-result" id="result">
    <div class="wl-result__card">
        <!-- 背景の細い曲線 -->
        <svg class="wl-result__arc" viewBox="0 0 2425 808" preserveAspectRatio="none" aria-hidden="true" focusable="false">
            <path d="M1015 0 Q962 553.5 5 753" fill="none" stroke="currentColor" stroke-width="2" vector-effect="non-scaling-stroke"/>
        </svg>

        <!-- 左：円グラフ -->
        <div class="wl-result__ring" role="img" aria-label="<?php echo esc_attr($wl_result['value'] . $wl_result['unit']); ?>">
            <div class="wl-result__ring-arc" aria-hidden="true">
                <span class="wl-result__ring-track"></span>
                <span class="wl-result__ring-line"></span>
            </div>
            <span class="wl-result__ring-disc" aria-hidden="true"></span>
            <span class="wl-result__ring-dots" aria-hidden="true"></span>
            <p class="wl-result__value" aria-hidden="true"><strong><?php echo esc_html($wl_result['value']); ?></strong><?php echo esc_html($wl_result['unit']); ?></p>
        </div>

        <!-- 中央：白いカード -->
        <div class="wl-result__panel">
            <p class="wl-result__en"><span><?php echo esc_html($wl_result['en']); ?></span></p>
            <h2 class="wl-result__title"><?php echo $wl_lines($wl_result['title']); ?></h2>
            <p class="wl-result__lead"><?php echo $wl_lines($wl_result['lead']); ?></p>
            <p class="wl-result__note"><?php echo $wl_lines($wl_result['note']); ?></p>
        </div>

        <!-- 右：女性の写真 -->
        <?php if (file_exists(get_theme_file_path('/img/' . $wl_result['image']))) : ?>
            <picture>
                <?php if (!empty($wl_result['image_sp']) && file_exists(get_theme_file_path('/img/' . $wl_result['image_sp']))) : ?>
                    <source media="(max-width: 768px)" srcset="<?php echo esc_url($wl_img_dir . $wl_result['image_sp']); ?>">
                <?php endif; ?>
                <img class="wl-result__photo" src="<?php echo esc_url($wl_img_dir . $wl_result['image']); ?>" alt="<?php echo esc_attr($wl_result['alt']); ?>" width="883" height="829" loading="lazy" decoding="async">
            </picture>
        <?php endif; ?>
    </div>
</section>

<!-- ============ お悩み（ホワイトニングでよくあるお悩み） ============ -->
<section class="wl-trouble" id="trouble">
    <?php foreach (array('l' => 'left', 'r' => 'right') as $key => $side) : ?>
        <?php $petal = $wl_trouble['petal_' . $key]; ?>
        <?php if ($petal && file_exists(get_theme_file_path('/img/' . $petal))) : ?>
            <img class="wl-trouble__petal wl-trouble__petal--<?php echo esc_attr($side); ?>" src="<?php echo esc_url($wl_img_dir . $petal); ?>" alt="" width="<?php echo $key === 'l' ? 58 : 88; ?>" height="<?php echo $key === 'l' ? 64 : 104; ?>" loading="lazy" decoding="async" aria-hidden="true">
        <?php endif; ?>
    <?php endforeach; ?>

    <div class="wl-trouble__inner">
        <header class="wl-trouble__head">
            <p class="wl-trouble__en"><span><?php echo esc_html($wl_trouble['en']); ?></span></p>
            <h2 class="wl-trouble__title"><?php echo str_replace('ホワイトニングで', 'ホワイトニングで<br class="wl-trouble__br">', esc_html($wl_trouble['title'])); ?></h2>
        </header>

        <ul class="wl-trouble__list">
            <?php foreach ($wl_trouble['items'] as $i => $text) : ?>
                <li class="wl-trouble__item">
                    <?php if (file_exists(get_theme_file_path('/img/' . $wl_trouble['check']))) : ?>
                        <img class="wl-trouble__check" src="<?php echo esc_url($wl_img_dir . $wl_trouble['check']); ?>" alt="" width="64" height="64" loading="lazy" decoding="async" aria-hidden="true">
                    <?php else : ?>
                        <span class="wl-trouble__check wl-trouble__check--css" aria-hidden="true"></span>
                    <?php endif; ?>
                    <p class="wl-trouble__text"><?php echo esc_html($text); ?></p>
                    <span class="wl-trouble__num" aria-hidden="true"><?php echo esc_html(sprintf('%02d', $i + 1)); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>

<!-- ============ ソリューション（そのお悩み、お任せください） ============ -->
<section class="wl-solution" id="solution">
    <span class="wl-solution__bgtext" aria-hidden="true"><?php echo esc_html($wl_solution['en']); ?></span>

    <!-- 右上の細い曲線 -->
    <svg class="wl-solution__arc" viewBox="0 0 100 36" preserveAspectRatio="none" aria-hidden="true" focusable="false">
        <path d="M64.6 6 A37.45 37.45 0 0 0 100 29.56" fill="none" stroke="currentColor" stroke-width="1.5" vector-effect="non-scaling-stroke"/>
    </svg>
    <?php if ($wl_solution['petal'] && file_exists(get_theme_file_path('/img/' . $wl_solution['petal']))) : ?>
        <img class="wl-solution__petal" src="<?php echo esc_url($wl_img_dir . $wl_solution['petal']); ?>" alt="" width="88" height="104" loading="lazy" decoding="async" aria-hidden="true">
    <?php endif; ?>

    <div class="wl-solution__inner">
        <!-- 見出しの上の「↓」マーク -->
        <span class="wl-solution__badge" aria-hidden="true">
            <svg width="26" height="14" viewBox="0 0 26 14" fill="none" stroke="#fff" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M2 2l11 10L24 2"/></svg>
        </span>

        <header class="wl-solution__head">
            <p class="wl-solution__en"><span><?php echo esc_html($wl_solution['en']); ?></span></p>
            <h2 class="wl-solution__title"><?php echo str_replace(array('、', '歯科に'), array('、<br class="wl-solution__br">', '歯科に<br class="wl-solution__br">'), esc_html($wl_solution['title'])); ?></h2>
            <p class="wl-solution__lead"><?php echo esc_html($wl_solution['lead']); ?></p>
        </header>

        <div class="wl-solution__list">
            <?php foreach ($wl_solution['blocks'] as $block) : ?>
                <?php $side = (isset($block['side']) && $block['side'] === 'right') ? 'right' : 'left'; ?>

                <?php if ($block['type'] === 'banner') : ?>
                    <!-- 紫のバナー -->
                    <aside class="wl-solution__banner wl-solution__banner--<?php echo esc_attr($side); ?>">
                        <svg class="wl-solution__banner-arc" viewBox="0 0 1006 323" preserveAspectRatio="none" aria-hidden="true" focusable="false">
                            <path d="M435 0 Q410 170 0 255" fill="none" stroke="currentColor" stroke-width="1" vector-effect="non-scaling-stroke"/>
                        </svg>
                        <div class="wl-solution__banner-photo"><?php echo $wl_sol_img($block['image']); ?></div>
                        <div class="wl-solution__banner-body">
                            <p class="wl-solution__banner-badge"><?php echo esc_html($block['badge']); ?></p>
                            <h4 class="wl-solution__banner-title"><?php echo str_replace(array('＋', '、'), array('＋<br class="wl-solution__br">', '、<br class="wl-solution__br">'), esc_html($block['title'])); ?></h4>
                            <?php if (!empty($block['sub'])) : ?>
                                <p class="wl-solution__banner-sub"><?php echo esc_html($block['sub']); ?></p>
                            <?php endif; ?>
                            <span class="wl-solution__banner-rule" aria-hidden="true"></span>
                            <p class="wl-solution__banner-text"><?php echo esc_html($block['text']); ?></p>
                        </div>
                    </aside>

                <?php else : ?>
                    <!-- お悩み01〜06 -->
                    <?php $equip = $block['equip']; ?>
                    <article class="wl-solution__block">
                        <div class="wl-solution__item wl-solution__item--<?php echo esc_attr($side); ?>">
                            <div class="wl-solution__photo"><?php echo $wl_sol_img($block['image']); ?></div>
                            <div class="wl-solution__body">
                                <p class="wl-solution__item-head">
                                    <span class="wl-solution__num"><?php echo esc_html($block['num']); ?></span>
                                    <span class="wl-solution__tag"><?php echo esc_html($block['tag']); ?></span>
                                </p>
                                <h3 class="wl-solution__item-title"><?php echo esc_html($block['title']); ?></h3>
                                <p class="wl-solution__item-text"><?php echo esc_html($block['text']); ?></p>
                            </div>
                        </div>

                        <!-- 使用設備 -->
                        <div class="wl-solution__equip<?php echo empty($equip['cards']) ? ' wl-solution__equip--solo' : ''; ?>">
                            <div class="wl-solution__equip-main">
                                <span class="wl-solution__pill"><?php echo esc_html($equip['label']); ?></span>
                                <h4 class="wl-solution__equip-name"><?php echo esc_html($equip['name']); ?></h4>
                                <p class="wl-solution__equip-text"><?php echo esc_html($equip['text']); ?></p>
                            </div>
                            <?php if (!empty($equip['cards'])) : ?>
                                <ul class="wl-solution__cards">
                                    <?php foreach ($equip['cards'] as $card) : ?>
                                        <li class="wl-solution__card">
                                            <strong class="wl-solution__card-title"><?php echo esc_html($card[0]); ?></strong>
                                            <span class="wl-solution__card-text"><?php echo esc_html($card[1]); ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>

                        <?php if (!empty($equip['note'])) : ?>
                            <p class="wl-solution__note"><?php echo esc_html($equip['note']); ?></p>
                        <?php endif; ?>
                    </article>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============ メニュー（あなたに合う、3つのホワイトニング） ============ -->
<section class="wl-menu" id="menu">
    <span class="wl-menu__bgtext" aria-hidden="true"><?php echo esc_html($wl_menu['bgtext']); ?></span>
    <?php if ($wl_menu['petal'] && file_exists(get_theme_file_path('/img/' . $wl_menu['petal']))) : ?>
        <img class="wl-menu__petal" src="<?php echo esc_url($wl_img_dir . $wl_menu['petal']); ?>" alt="" width="88" height="104" loading="lazy" decoding="async" aria-hidden="true">
    <?php endif; ?>

    <div class="wl-menu__inner">
        <header class="wl-menu__head">
            <p class="wl-menu__en"><span><?php echo esc_html($wl_menu['en']); ?></span></p>
            <h2 class="wl-menu__title"><?php echo str_replace('、', '、<span class="wl-menu__br"></span>', esc_html($wl_menu['title'])); ?></h2>
            <p class="wl-menu__lead"><?php echo esc_html($wl_menu['lead']); ?></p>
        </header>

        <div class="wl-menu__slider" data-menu-slider>
        <ul class="wl-menu__list" data-menu-list>
            <?php foreach ($wl_menu['items'] as $item) : ?>
                <?php
                $item_class = 'wl-menu__item';
                if (!empty($item['lower'])) {
                    $item_class .= ' wl-menu__item--lower';
                }
                if (!empty($item['accent'])) {
                    $item_class .= ' wl-menu__item--accent';
                }
                ?>
                <li class="<?php echo esc_attr($item_class); ?>">
                    <div class="wl-menu__photo"><?php echo $wl_menu_img($item['image']); ?></div>
                    <div class="wl-menu__body">
                        <p class="wl-menu__item-head">
                            <span class="wl-menu__num"><?php echo esc_html($item['num']); ?></span>
                            <span class="wl-menu__tag"><?php echo esc_html($item['tag']); ?></span>
                        </p>
                        <h3 class="wl-menu__item-title"><?php echo esc_html($item['title']); ?></h3>
                        <p class="wl-menu__item-text"><?php echo $wl_menu_lines($item['text']); ?></p>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

        <!-- スマホだけ：スライドの位置を示すドット（タップで移動） -->
        <div class="wl-menu__dots">
            <?php foreach ($wl_menu['items'] as $i => $item) : ?>
                <button type="button" class="wl-menu__dot<?php echo 0 === $i ? ' is-active' : ''; ?>" data-menu-dot aria-label="<?php echo esc_attr($item['title']); ?>を表示"></button>
            <?php endforeach; ?>
        </div>
        </div>
    </div>
</section>

<!-- ============ ブライダル（結婚式・前撮りに） ============ -->
<section class="wl-bridal" id="bridal">
    <!-- 背景の細い曲線 -->
    <svg class="wl-bridal__arc" viewBox="0 0 2576 1367" preserveAspectRatio="none" aria-hidden="true" focusable="false">
        <path d="M1131 0 C1128 200 1080 380 905 595" fill="none" stroke="currentColor" stroke-width="1.5" vector-effect="non-scaling-stroke"/>
        <path d="M0 918 Q120 945 235 942" fill="none" stroke="currentColor" stroke-width="1.5" vector-effect="non-scaling-stroke"/>
    </svg>
    <?php if ($wl_bridal['petal'] && file_exists(get_theme_file_path('/img/' . $wl_bridal['petal']))) : ?>
        <?php foreach (array('a', 'b', 'c', 'd') as $petal_key) : ?>
            <img class="wl-bridal__petal wl-bridal__petal--<?php echo esc_attr($petal_key); ?>" src="<?php echo esc_url($wl_img_dir . $wl_bridal['petal']); ?>" alt="" width="88" height="104" loading="lazy" decoding="async" aria-hidden="true">
        <?php endforeach; ?>
    <?php endif; ?>

    <div class="wl-bridal__inner">
        <header class="wl-bridal__head">
            <p class="wl-bridal__en"><span><?php echo esc_html($wl_bridal['en']); ?></span></p>
            <p class="wl-bridal__lead"><?php echo esc_html($wl_bridal['lead']); ?></p>
            <h2 class="wl-bridal__title"><?php echo esc_html($wl_bridal['title']); ?></h2>
        </header>

        <div class="wl-bridal__body">
            <!-- 左：アーチ形の写真 -->
            <div class="wl-bridal__photo"><?php echo $wl_bridal_img($wl_bridal['image']); ?></div>

            <!-- 右：文章・おすすめプラン・選ばれるタイミング -->
            <div class="wl-bridal__content">
                <h3 class="wl-bridal__catch"><?php echo $wl_br($wl_bridal['catch']); ?></h3>
                <p class="wl-bridal__text"><?php echo esc_html($wl_bridal['text']); ?></p>

                <div class="wl-bridal__plan">
                    <p class="wl-bridal__plan-label"><?php echo esc_html($wl_bridal['plan_label']); ?></p>
                    <ul class="wl-bridal__plan-list">
                        <?php foreach ($wl_bridal['plans'] as $plan) : ?>
                            <li class="wl-bridal__pill wl-bridal__pill--<?php echo esc_attr($plan[1]); ?>"><?php echo esc_html($plan[0]); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <h3 class="wl-bridal__timing-title"><?php echo esc_html($wl_bridal['timing_title']); ?></h3>
                <ul class="wl-bridal__chips">
                    <?php foreach ($wl_bridal['timings'] as $timing) : ?>
                        <li class="wl-bridal__chip"><?php echo esc_html($timing); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- ============ ブライダルプラン（挙式までの期間で選ぶ、2つのプラン） ============ -->
<section class="wl-plan" id="plan">
    <?php if ($wl_plan['petal'] && file_exists(get_theme_file_path('/img/' . $wl_plan['petal']))) : ?>
        <?php foreach (array('a', 'b') as $petal_key) : ?>
            <img class="wl-plan__petal wl-plan__petal--<?php echo esc_attr($petal_key); ?>" src="<?php echo esc_url($wl_img_dir . $wl_plan['petal']); ?>" alt="" width="88" height="104" loading="lazy" decoding="async" aria-hidden="true">
        <?php endforeach; ?>
    <?php endif; ?>

    <div class="wl-plan__inner" data-plan-tabs>
        <header class="wl-plan__head">
            <p class="wl-plan__en"><span><?php echo esc_html($wl_plan['en']); ?></span></p>
            <h2 class="wl-plan__title"><?php echo esc_html($wl_plan['title']); ?></h2>
        </header>

        <!-- タブ -->
        <div class="wl-plan__tabs" role="tablist" aria-label="挙式までの期間でプランを選ぶ">
            <?php foreach ($wl_plan['plans'] as $i => $plan) : ?>
                <button class="wl-plan__tab wl-plan__tab--<?php echo esc_attr($plan['key']); ?><?php echo $i === 0 ? ' is-active' : ''; ?>" type="button" role="tab"
                        id="wl-plan-tab-<?php echo esc_attr($plan['key']); ?>"
                        aria-controls="wl-plan-panel-<?php echo esc_attr($plan['key']); ?>"
                        aria-selected="<?php echo $i === 0 ? 'true' : 'false'; ?>"
                        tabindex="<?php echo $i === 0 ? '0' : '-1'; ?>" data-plan-tab>
                    <span class="wl-plan__tab-main"><?php echo esc_html($plan['tab'][0]); ?></span><span class="wl-plan__tab-sub"><?php echo esc_html($plan['tab'][1]); ?></span>
                </button>
            <?php endforeach; ?>
        </div>

        <!-- プラン（タブで切り替え）。全パネルを同じ位置に重ね、いちばん高いパネルに高さを合わせる -->
        <div class="wl-plan__panels">
        <?php foreach ($wl_plan['plans'] as $i => $plan) : ?>
            <div class="wl-plan__panel wl-plan__panel--<?php echo esc_attr($plan['key']); ?><?php echo $i === 0 ? ' is-active' : ''; ?>" role="tabpanel"
                 id="wl-plan-panel-<?php echo esc_attr($plan['key']); ?>"
                 aria-labelledby="wl-plan-tab-<?php echo esc_attr($plan['key']); ?>"
                 <?php echo $i === 0 ? '' : 'hidden'; ?> data-plan-panel>
                <div class="wl-plan__card">
                    <!-- 左：プランの内容 -->
                    <div class="wl-plan__main">
                        <p class="wl-plan__tag"><?php echo esc_html($plan['tag']); ?></p>
                        <h3 class="wl-plan__name"><?php echo esc_html($plan['title']); ?></h3>
                        <p class="wl-plan__lead"><?php echo esc_html($plan['lead']); ?></p>

                        <!-- 白さの目安 -->
                        <div class="wl-plan__shade">
                            <ul class="wl-plan__chips">
                                <?php foreach ($wl_plan['shade'] as $chip) : ?>
                                    <li class="wl-plan__chip wl-plan__chip--<?php echo esc_attr($chip[1] === 'avg' || $chip[1] === 'bleach' ? $chip[1] : 't' . $chip[1]); ?>">
                                        <?php echo esc_html($chip[0]); ?>
                                        <?php if ($chip[2] !== '') : ?>
                                            <small class="wl-plan__chip-note"><?php echo esc_html($chip[2]); ?></small>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <p class="wl-plan__caption"><?php echo esc_html($plan['caption']); ?></p>
                        </div>

                        <!-- プラン内容・価格 -->
                        <dl class="wl-plan__buy">
                            <div class="wl-plan__contents">
                                <dt class="wl-plan__contents-label"><?php echo esc_html($wl_plan['content_label']); ?></dt>
                                <dd class="wl-plan__contents-body">
                                    <ul class="wl-plan__contents-list">
                                        <?php foreach ($plan['contents'] as $content) : ?>
                                            <li><?php echo esc_html($content); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </dd>
                            </div>
                            <div class="wl-plan__price">
                                <dt class="wl-plan__price-label"><?php echo esc_html($wl_plan['price_label']); ?></dt>
                                <dd class="wl-plan__price-body">
                                    <strong class="wl-plan__price-strong">
                                        <span class="wl-plan__price-main"><span class="wl-plan__price-num"><?php echo esc_html($plan['price']); ?></span><span class="wl-plan__price-unit"><?php echo esc_html($wl_plan['price_unit']); ?></span></span>
                                        <small class="wl-plan__price-tax"><?php echo esc_html($wl_plan['price_tax']); ?></small>
                                    </strong>
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <!-- 右：施術の流れ -->
                    <div class="wl-plan__flow" data-plan-flow>
                        <h4 class="wl-plan__flow-title"><?php echo esc_html($wl_plan['flow_title']); ?></h4>
                        <ol class="wl-plan__steps" data-plan-steps>
                            <?php foreach ($plan['steps'] as $step) : ?>
                                <li class="wl-plan__step">
                                    <div class="wl-plan__step-photo"><?php echo $wl_plan_img($step[3], $step[4]); ?></div>
                                    <div class="wl-plan__step-body">
                                        <span class="wl-plan__step-badge"><?php echo esc_html($step[0]); ?></span>
                                        <h5 class="wl-plan__step-title"><?php echo esc_html($step[1]); ?></h5>
                                        <p class="wl-plan__step-text"><?php echo esc_html($step[2]); ?></p>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ol>

                        <!-- スマホだけ：施術の流れの位置を示すドット（タップで移動） -->
                        <div class="wl-plan__dots">
                            <?php foreach ($plan['steps'] as $n => $step) : ?>
                                <button type="button" class="wl-plan__dot<?php echo 0 === $n ? ' is-active' : ''; ?>" data-plan-dot aria-label="<?php echo esc_attr($step[0] . '：' . $step[1]); ?>を表示"></button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <?php /* 注記がないプランも、注記1行ぶんの場所は残す（タブを切り替えても、カードの高さを同じにするため） */ ?>
                <?php if (!empty($plan['note'])) : ?>
                    <p class="wl-plan__note"><?php echo esc_html($plan['note']); ?></p>
                <?php else : ?>
                    <p class="wl-plan__note is-empty"><span class="wl-plan__note-pc" aria-hidden="true">&nbsp;</span><span class="wl-plan__note-sp"><?php echo esc_html($wl_plan['note_sp']); ?></span></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============ ご相談（大切な”ハレノヒ”の日程が決まったら、早めのご相談を。） ============ -->
<section class="wl-consult" id="consult">
    <div class="wl-consult__inner">
        <div class="wl-consult__card">
            <!-- 左：写真 -->
            <div class="wl-consult__photo"><?php echo $wl_consult_img($wl_consult['image']); ?></div>

            <!-- 右：文章・ボタン -->
            <div class="wl-consult__body">
                <p class="wl-consult__en"><?php echo esc_html($wl_consult['en']); ?></p>
                <h2 class="wl-consult__title"><?php echo $wl_consult_lines($wl_consult['title']); ?></h2>

                <div class="wl-consult__actions">
                    <a class="wl-consult__btn wl-consult__btn--web" href="<?php echo esc_url($wl_consult['web_url']); ?>">
                        <span class="wl-consult__btn-label"><?php echo esc_html($wl_consult['web_label']); ?></span>
                        <span class="wl-consult__arrow" aria-hidden="true">
                            <svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="#fff" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M1 5h11M8 1l4 4-4 4"/></svg>
                        </span>
                    </a>
                    <a class="wl-consult__btn wl-consult__btn--tel" href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $wl_consult['tel'])); ?>">
                        <?php if (file_exists(get_theme_file_path('/img/' . $wl_consult['tel_icon']))) : ?>
                            <img class="wl-consult__tel-icon" src="<?php echo esc_url($wl_img_dir . $wl_consult['tel_icon']); ?>" alt="" width="28" height="21" loading="lazy" decoding="async" aria-hidden="true">
                        <?php else : ?>
                            <svg class="wl-consult__tel-icon" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"><path d="M6.6 10.8a15.1 15.1 0 0 0 6.6 6.6l2.2-2.2a1 1 0 0 1 1-.25 11.4 11.4 0 0 0 3.6.57 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.45.57 3.6a1 1 0 0 1-.25 1z"/></svg>
                        <?php endif; ?>
                        <span class="wl-consult__tel-num"><?php echo esc_html($wl_consult['tel']); ?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ 保証（白さに、結果保証。） ============ -->
<section class="wl-guarantee" id="guarantee">
    <span class="wl-guarantee__bgtext" aria-hidden="true"><?php echo esc_html($wl_guarantee['en']); ?></span>

    <div class="wl-guarantee__inner">
        <header class="wl-guarantee__head">
            <p class="wl-guarantee__en"><span><?php echo esc_html($wl_guarantee['en']); ?></span></p>
            <h2 class="wl-guarantee__title"><?php echo esc_html($wl_guarantee['title']); ?></h2>
            <p class="wl-guarantee__sub"><?php echo esc_html($wl_guarantee['sub']); ?></p>
        </header>

        <ul class="wl-guarantee__list">
            <?php foreach ($wl_guarantee['items'] as $item) : ?>
                <li class="wl-guarantee__item">
                    <div class="wl-guarantee__icon"><?php echo $wl_guarantee_img($item[3], $item[4]); ?></div>
                    <p class="wl-guarantee__tag"><?php echo esc_html($item[0]); ?></p>
                    <h3 class="wl-guarantee__item-title"><?php echo esc_html($item[1]); ?></h3>
                    <p class="wl-guarantee__item-text"><?php echo esc_html($item[2]); ?></p>
                </li>
            <?php endforeach; ?>
        </ul>

        <?php if (!empty($wl_guarantee['notes'])) : ?>
            <ul class="wl-guarantee__notes">
                <?php foreach ($wl_guarantee['notes'] as $note) : ?>
                    <li><small><?php echo esc_html($note); ?></small></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>

<!-- ============ 料金（ホワイトニングのメニュー・料金一覧） ============ -->
<section class="wl-price" id="price">
    <span class="wl-price__bgtext" aria-hidden="true"><?php echo esc_html($wl_price['en']); ?></span>

    <div class="wl-price__inner">
        <header class="wl-price__head">
            <p class="wl-price__en"><span><?php echo esc_html($wl_price['en']); ?></span></p>
            <h2 class="wl-price__title"><?php echo str_replace('ホワイトニングの', 'ホワイトニングの<br class="wl-price__br">', esc_html($wl_price['title'])); ?></h2>
            <p class="wl-price__lead"><?php echo esc_html($wl_price['lead']); ?></p>
        </header>

        <div class="wl-price__body">
            <!-- 左：料金表 -->
            <div class="wl-price__main">
                <div class="wl-price__table-wrap">
                    <table class="wl-price__table">
                        <caption class="wl-price__caption"><?php echo esc_html($wl_price['title']); ?>（税込）</caption>
                        <thead>
                            <tr>
                                <th scope="col" class="wl-price__th wl-price__th--menu"><?php echo esc_html($wl_price['th_menu']); ?></th>
                                <th scope="col" class="wl-price__th wl-price__th--price"><?php echo esc_html($wl_price['th_price']); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($wl_price['rows'] as $row) : ?>
                                <tr>
                                    <td class="wl-price__name"><?php echo esc_html($row[0]); ?></td>
                                    <td class="wl-price__value"><span class="wl-price__num"><?php echo esc_html($row[1]); ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($wl_price['note'])) : ?>
                    <small class="wl-price__note"><?php echo esc_html($wl_price['note']); ?></small>
                <?php endif; ?>
            </div>

            <!-- 右：お支払い・解約について -->
            <aside class="wl-price__side">
                <h3 class="wl-price__side-title"><?php echo esc_html($wl_price['side_title']); ?></h3>
                <?php foreach ($wl_price['cards'] as $card) : ?>
                    <div class="wl-price__card">
                        <h4 class="wl-price__card-title"><?php echo esc_html($card[0]); ?></h4>
                        <p class="wl-price__card-text"><?php echo esc_html($card[1]); ?></p>
                        <?php if (!empty($card[2])) : ?>
                            <p class="wl-price__example"><?php echo esc_html($card[2]); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </aside>
        </div>
    </div>
</section>

<!-- ============ 流れ（ホワイトニングの流れ） ============ -->
<section class="wl-flow" id="flow" data-flow>
    <span class="wl-flow__bgtext" aria-hidden="true"><?php echo esc_html($wl_flow['bgtext']); ?></span>

    <div class="wl-flow__inner">
        <header class="wl-flow__head">
            <p class="wl-flow__en"><span><?php echo esc_html($wl_flow['en']); ?></span></p>
            <h2 class="wl-flow__title"><?php echo esc_html($wl_flow['title']); ?></h2>
        </header>

        <!-- スマホ：丸い番号のボタン（押すと、その写真へ移動） -->
        <div class="wl-flow__nav">
            <?php foreach ($wl_flow['steps'] as $i => $step) : ?>
                <button type="button" class="wl-flow__nav-btn" data-flow-nav aria-label="<?php echo esc_attr(sprintf('%02d', $i + 1) . ' ' . $step['title']); ?>を表示">
                    <span class="wl-flow__nav-circle" aria-hidden="true"><?php echo esc_html(sprintf('%02d', $i + 1)); ?></span>
                    <span class="wl-flow__nav-label"><?php echo esc_html($step['title']); ?></span>
                </button>
            <?php endforeach; ?>
        </div>

        <ol class="wl-flow__list" data-flow-steps>
            <?php foreach ($wl_flow['steps'] as $i => $step) : ?>
                <li class="wl-flow__item">
                    <div class="wl-flow__photo"><?php echo $wl_flow_img($step['image']); ?></div>
                    <div class="wl-flow__body">
                        <span class="wl-flow__num" aria-hidden="true"><?php echo esc_html(sprintf('%02d', $i + 1)); ?></span>
                        <h3 class="wl-flow__item-title"><?php echo esc_html($step['title']); ?></h3>
                        <p class="wl-flow__item-text"><?php echo esc_html($step['text']); ?></p>
                    </div>
                </li>
            <?php endforeach; ?>
        </ol>

        <!-- スマホ：スライダーの現在位置（押すと移動） -->
        <div class="wl-flow__dots">
            <?php foreach ($wl_flow['steps'] as $i => $step) : ?>
                <button type="button" class="wl-flow__dot<?php echo 0 === $i ? ' is-active' : ''; ?>" data-flow-dot aria-label="<?php echo esc_attr(sprintf('%02d', $i + 1) . ' ' . $step['title']); ?>を表示"></button>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============ オプション（ホワイトニングと一緒に） ============ -->
<section class="wl-option" id="option">
    <span class="wl-option__bgtext" aria-hidden="true"><?php echo esc_html($wl_option['bgtext']); ?></span>

    <div class="wl-option__inner">
        <header class="wl-option__head">
            <p class="wl-option__en"><span><?php echo esc_html($wl_option['en']); ?></span></p>
            <h2 class="wl-option__title"><?php echo esc_html($wl_option['title']); ?></h2>
            <p class="wl-option__sub"><?php echo esc_html($wl_option['sub']); ?></p>
        </header>

        <ul class="wl-option__list">
            <?php foreach ($wl_option['items'] as $item) : ?>
                <li class="wl-option__item">
                    <a class="wl-option__link" href="<?php echo esc_url(!empty($item['url']) ? $item['url'] : '#'); ?>">
                        <div class="wl-option__photo"><?php echo $wl_option_img($item['image']); ?></div>
                        <div class="wl-option__body">
                            <span class="wl-option__bar" aria-hidden="true"></span>
                            <h3 class="wl-option__item-title"><?php echo esc_html($item['title']); ?></h3>
                        </div>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="wl-option__more">
            <a class="wl-option__btn" href="<?php echo esc_url($wl_option['btn_url']); ?>">
                <span class="wl-option__btn-label"><?php echo esc_html($wl_option['btn_label']); ?></span>
                <span class="wl-option__btn-arrow" aria-hidden="true">
                    <svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="#fff" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M1 5h11M8 1l4 4-4 4"/></svg>
                </span>
            </a>
        </div>
    </div>
</section>

<!-- ============ お問い合わせ（まずはカウンセリングから、はじめませんか？） ============ -->
<section class="wl-contact" id="contact">
    <!-- 背景の細い曲線 -->
    <svg class="wl-contact__arc" viewBox="0 0 1366 468" preserveAspectRatio="none" aria-hidden="true" focusable="false">
        <path d="M925 0 C880 90 810 200 802 468" fill="none" stroke="currentColor" stroke-width="1.5" vector-effect="non-scaling-stroke"/>
    </svg>
    <?php if ($wl_contact['petal'] && file_exists(get_theme_file_path('/img/' . $wl_contact['petal']))) : ?>
        <?php foreach (array('a', 'b', 'c') as $petal_key) : ?>
            <img class="wl-contact__petal wl-contact__petal--<?php echo esc_attr($petal_key); ?>" src="<?php echo esc_url($wl_img_dir . $wl_contact['petal']); ?>" alt="" width="88" height="104" loading="lazy" decoding="async" aria-hidden="true">
        <?php endforeach; ?>
    <?php endif; ?>

    <div class="wl-contact__inner">
        <p class="wl-contact__en"><span><?php echo esc_html($wl_contact['en']); ?></span></p>
        <h2 class="wl-contact__title"><?php echo $wl_contact_lines($wl_contact['title']); ?></h2>
        <p class="wl-contact__lead"><?php echo $wl_contact_lines($wl_contact['lead'], 'wl-contact__lead-line'); ?></p>

        <div class="wl-contact__actions">
            <a class="wl-contact__btn wl-contact__btn--web" href="<?php echo esc_url($wl_contact['web_url']); ?>">
                <span class="wl-contact__btn-label"><?php echo esc_html($wl_contact['web_label']); ?></span>
                <span class="wl-contact__arrow" aria-hidden="true">
                    <svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M1 5h11M8 1l4 4-4 4"/></svg>
                </span>
            </a>
            <a class="wl-contact__btn wl-contact__btn--tel" href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $wl_contact['tel'])); ?>">
                <?php if (file_exists(get_theme_file_path('/img/' . $wl_contact['tel_icon']))) : ?>
                    <img class="wl-contact__tel-icon" src="<?php echo esc_url($wl_img_dir . $wl_contact['tel_icon']); ?>" alt="" width="28" height="21" loading="lazy" decoding="async" aria-hidden="true">
                <?php else : ?>
                    <svg class="wl-contact__tel-icon" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"><path d="M6.6 10.8a15.1 15.1 0 0 0 6.6 6.6l2.2-2.2a1 1 0 0 1 1-.25 11.4 11.4 0 0 0 3.6.57 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.45.57 3.6a1 1 0 0 1-.25 1z"/></svg>
                <?php endif; ?>
                <span class="wl-contact__tel-num"><?php echo esc_html($wl_contact['tel']); ?></span>
            </a>
        </div>
    </div>
</section>

<!-- ============ 院長紹介（DOCTOR） ============ -->
<section class="wl-doctor" id="doctor">
    <span class="wl-doctor__bgtext" aria-hidden="true"><?php echo esc_html($wl_doctor['bgtext']); ?></span>

    <div class="wl-doctor__inner">
        <header class="wl-doctor__head">
            <p class="wl-doctor__en"><span><?php echo esc_html($wl_doctor['en']); ?></span></p>
            <h2 class="wl-doctor__title"><?php echo esc_html($wl_doctor['title']); ?></h2>
            <p class="wl-doctor__sub"><?php echo esc_html($wl_doctor['sub']); ?></p>
        </header>

        <div class="wl-doctor__body">
            <!-- 左：院長の写真 -->
            <div class="wl-doctor__photo"><?php echo $wl_doctor_img($wl_doctor['image']); ?></div>

            <!-- 右：名前・紹介文・経歴 -->
            <div class="wl-doctor__content">
                <h3 class="wl-doctor__name"><?php echo $wl_contact_lines($wl_doctor['name'], 'wl-doctor__name-line'); ?></h3>
                <span class="wl-doctor__rule" aria-hidden="true"></span>
                <p class="wl-doctor__text"><?php echo esc_html($wl_doctor['text']); ?></p>
                <ul class="wl-doctor__creds">
                    <?php foreach ($wl_doctor['credentials'] as $cred) : ?>
                        <li class="wl-doctor__cred"><?php echo esc_html($cred); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- ============ よくあるご質問（FAQ） ============ -->
<section class="wl-faq" id="faq">
    <span class="wl-faq__bgtext" aria-hidden="true"><?php echo esc_html($wl_faq['bgtext']); ?></span>

    <div class="wl-faq__inner">
        <header class="wl-faq__head">
            <p class="wl-faq__en"><span><?php echo esc_html($wl_faq['en']); ?></span></p>
            <h2 class="wl-faq__title"><?php echo $wl_contact_lines($wl_faq['title'], 'wl-faq__line'); ?></h2>
        </header>

        <dl class="wl-faq__list" data-faq>
            <?php foreach ($wl_faq['items'] as $i => $item) : ?>
                <?php $is_open = ($i === (int) $wl_faq['open']); ?>
                <div class="wl-faq__item<?php echo $is_open ? ' is-open' : ''; ?>" data-faq-item>
                    <dt class="wl-faq__q">
                        <button class="wl-faq__trigger" type="button"
                                id="wl-faq-q<?php echo esc_attr($i + 1); ?>"
                                aria-expanded="<?php echo $is_open ? 'true' : 'false'; ?>"
                                aria-controls="wl-faq-a<?php echo esc_attr($i + 1); ?>" data-faq-trigger>
                            <span class="wl-faq__badge wl-faq__badge--q" aria-hidden="true">Q</span>
                            <span class="wl-faq__q-text"><?php echo esc_html($item[0]); ?></span>
                            <span class="wl-faq__icon" aria-hidden="true"></span>
                        </button>
                    </dt>
                    <dd class="wl-faq__panel" id="wl-faq-a<?php echo esc_attr($i + 1); ?>" role="region" aria-labelledby="wl-faq-q<?php echo esc_attr($i + 1); ?>">
                        <div class="wl-faq__panel-inner">
                            <div class="wl-faq__a">
                                <span class="wl-faq__badge wl-faq__badge--a" aria-hidden="true">A</span>
                                <p class="wl-faq__a-text"><?php echo esc_html($item[1]); ?></p>
                            </div>
                        </div>
                    </dd>
                </div>
            <?php endforeach; ?>
        </dl>
    </div>
</section>

<!-- ============ 注意点・副作用（NOTES） ============ -->
<section class="wl-notes" id="notes">
    <div class="wl-notes__inner">
        <header class="wl-notes__head">
            <p class="wl-notes__en"><span><?php echo esc_html($wl_notes['en']); ?></span></p>
            <h2 class="wl-notes__title"><?php echo str_replace('ホワイトニングの', 'ホワイトニングの<br class="wl-notes__br">', esc_html($wl_notes['title'])); ?></h2>
        </header>

        <ul class="wl-notes__list">
            <?php foreach ($wl_notes['items'] as $item) : ?>
                <li class="wl-notes__item">
                    <span class="wl-notes__icon" aria-hidden="true"></span>
                    <div class="wl-notes__body">
                        <h3 class="wl-notes__item-title"><?php echo esc_html($item[0]); ?></h3>
                        <p class="wl-notes__item-text"><?php echo esc_html($item[1]); ?></p>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>

<!-- ============ 診療時間・アクセス（ACCESS） ============ -->
<section class="wl-access" id="access">
    <span class="wl-access__bgtext" aria-hidden="true"><?php echo esc_html($wl_access['bgtext']); ?></span>

    <div class="wl-access__inner">
        <header class="wl-access__head">
            <p class="wl-access__en"><span><?php echo esc_html($wl_access['en']); ?></span></p>
            <h2 class="wl-access__title"><?php echo esc_html($wl_access['title']); ?></h2>
            <p class="wl-access__sub"><?php echo esc_html($wl_access['sub']); ?></p>
            <p class="wl-access__catch">
                <span class="wl-access__slash wl-access__slash--l" aria-hidden="true"><svg viewBox="0 0 36 36" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"><path d="M2 2l32 32"/></svg></span>
                <span class="wl-access__catch-text"><?php echo esc_html($wl_access['catch']); ?></span>
                <span class="wl-access__slash wl-access__slash--r" aria-hidden="true"><svg viewBox="0 0 36 36" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"><path d="M34 2L2 34"/></svg></span>
            </p>
        </header>

        <div class="wl-access__body">
            <!-- 左：医院情報・診療時間 -->
            <div class="wl-access__main">
                <div class="wl-access__card">
                    <p class="wl-access__name"><?php echo esc_html($wl_access['name']); ?></p>
                    <dl class="wl-access__info">
                        <?php foreach ($wl_access['info'] as $row) : ?>
                            <div class="wl-access__row">
                                <dt><?php echo esc_html($row[0]); ?></dt>
                                <dd><?php echo str_replace("\n", '<br class="wl-access__br">', esc_html($row[1])); ?></dd>
                            </div>
                        <?php endforeach; ?>
                    </dl>
                </div>

                <h3 class="wl-access__hours-title"><?php echo esc_html($wl_access['hours_title']); ?></h3>
                <div class="wl-access__table-wrap">
                    <table class="wl-access__table">
                        <thead>
                            <tr>
                                <th scope="col" class="wl-access__th-time"><span class="wl-access__sr"><?php echo esc_html($wl_access['hours_th']); ?></span></th>
                                <?php foreach ($wl_access['days'] as $day) : ?>
                                    <th scope="col"><?php echo esc_html($day); ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($wl_access['hours'] as $hour) : ?>
                                <tr>
                                    <th scope="row" class="wl-access__time"><?php echo esc_html($hour[0]); ?></th>
                                    <?php foreach ($hour[1] as $mark) : ?>
                                        <td><span class="wl-access__mark wl-access__mark--<?php echo esc_attr($mark); ?>" role="img" aria-label="<?php echo esc_attr(isset($wl_access['marks'][$mark]) ? $wl_access['marks'][$mark] : ''); ?>"></span></td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($wl_access['hours_note'])) : ?>
                    <p class="wl-access__note"><?php echo esc_html($wl_access['hours_note']); ?></p>
                <?php endif; ?>
            </div>

            <!-- 右：Googleマップ -->
            <div class="wl-access__map">
                <iframe class="wl-access__iframe" src="<?php echo esc_url($wl_access_map); ?>" title="<?php echo esc_attr($wl_access['map_title']); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                <div class="wl-access__map-card">
                    <p class="wl-access__map-name"><?php echo esc_html($wl_access['name']); ?></p>
                    <p class="wl-access__map-address"><?php echo esc_html($wl_access['postal'] . ' ' . $wl_access['address']); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ 最後のご相談（まずはお気軽にご相談ください！） ============ -->
<section class="wl-cta" id="cta">
    <!-- 背景の細い曲線（白） -->
    <svg class="wl-cta__arc" viewBox="0 0 2576 1102" preserveAspectRatio="none" aria-hidden="true" focusable="false">
        <path d="M1127 0 C1115 220 1030 420 900 560 C700 770 380 940 0 942" fill="none" stroke="currentColor" stroke-width="1.5" vector-effect="non-scaling-stroke"/>
        <path d="M2576 378 C2420 380 2280 410 2180 458" fill="none" stroke="currentColor" stroke-width="1.5" vector-effect="non-scaling-stroke"/>
        <path d="M1860 700 C1840 760 1820 800 1800 830" fill="none" stroke="currentColor" stroke-width="1.5" vector-effect="non-scaling-stroke"/>
    </svg>
    <?php if ($wl_cta['petal'] && file_exists(get_theme_file_path('/img/' . $wl_cta['petal']))) : ?>
        <?php foreach (array('a', 'b', 'c', 'd') as $petal_key) : ?>
            <img class="wl-cta__petal wl-cta__petal--<?php echo esc_attr($petal_key); ?>" src="<?php echo esc_url($wl_img_dir . $wl_cta['petal']); ?>" alt="" width="88" height="104" loading="lazy" decoding="async" aria-hidden="true">
        <?php endforeach; ?>
    <?php endif; ?>

    <div class="wl-cta__inner">
        <h2 class="wl-cta__title"><?php echo str_replace("\n", '<br class="wl-cta__br">', esc_html($wl_cta['title'])); ?></h2>
        <p class="wl-cta__lead"><?php echo esc_html($wl_cta['lead']); ?></p>

        <ul class="wl-cta__list">
            <?php foreach ($wl_cta['points'] as $point) : ?>
                <li class="wl-cta__card">
                    <span class="wl-cta__check" aria-hidden="true">
                        <svg viewBox="0 0 12 10" fill="none" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M1.2 5.3 4.3 8.4 10.8 1.6"/></svg>
                    </span>
                    <p class="wl-cta__card-title"><?php echo esc_html($point[0]); ?></p>
                    <p class="wl-cta__card-text"><?php echo esc_html($point[1]); ?></p>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="wl-cta__actions">
            <a class="wl-cta__btn wl-cta__btn--web" href="<?php echo esc_url($wl_cta['web_url']); ?>">
                <span class="wl-cta__btn-label"><?php echo esc_html($wl_cta['web_label']); ?></span>
                <span class="wl-cta__arrow" aria-hidden="true">
                    <svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M1 5h11M8 1l4 4-4 4"/></svg>
                </span>
            </a>
            <a class="wl-cta__btn wl-cta__btn--tel" href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $wl_cta['tel'])); ?>">
                <?php if (file_exists(get_theme_file_path('/img/' . $wl_cta['tel_icon']))) : ?>
                    <img class="wl-cta__tel-icon" src="<?php echo esc_url($wl_img_dir . $wl_cta['tel_icon']); ?>" alt="" width="28" height="21" loading="lazy" decoding="async" aria-hidden="true">
                <?php else : ?>
                    <svg class="wl-cta__tel-icon" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"><path d="M6.6 10.8a15.1 15.1 0 0 0 6.6 6.6l2.2-2.2a1 1 0 0 1 1-.25 11.4 11.4 0 0 0 3.6.57 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.45.57 3.6a1 1 0 0 1-.25 1z"/></svg>
                <?php endif; ?>
                <span class="wl-cta__tel-num"><?php echo esc_html($wl_cta['tel']); ?></span>
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
