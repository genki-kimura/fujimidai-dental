<?php
/* ----------------------------------------
// テーマのセットアップ
---------------------------------------- */
function my_setup()
{
  add_theme_support('post-thumbnails'); 
  add_theme_support('automatic-feed-links'); 
  add_theme_support('title-tag'); 
  add_theme_support(
    'html5',
    array( 
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
    )
  );
}
add_action('after_setup_theme', 'my_setup');

/* ----------------------------------------
// css,jsのセットアップ
---------------------------------------- */
function my_script_init()
{
  $style_css_path = get_theme_file_path('/css/style.css');
  $style_css_version = file_exists($style_css_path) ? md5_file($style_css_path) : '1.0.0';
  $block_css_path = get_theme_file_path('/css/block.css');
  $block_css_version = file_exists($block_css_path) ? md5_file($block_css_path) : '1.0.0';
  $script_js_path = get_theme_file_path('/js/script.js');
  $script_js_version = file_exists($script_js_path) ? md5_file($script_js_path) : '1.0.0';
  wp_enqueue_style('fontawesome', 'https://use.fontawesome.com/releases/v5.8.2/css/all.css', array(), '5.8.2', 'all');
  wp_enqueue_style('destyle', get_template_directory_uri() . '/css/destyle.css', array(), '1.0.0', 'all');
  wp_enqueue_style('my', get_template_directory_uri() . '/css/style.css', array(), $style_css_version, 'all');
  wp_enqueue_style('block', get_template_directory_uri() . '/css/block.css', array('my'), $block_css_version, 'all');

  wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.6.1.min.js"integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="crossorigin="anonymous' , array(), '1.0.0', true);
  wp_enqueue_script('my', get_template_directory_uri() . '/js/script.js', array('jquery'), $script_js_version, true);
}
add_action('wp_enqueue_scripts', 'my_script_init');

/* ----------------------------------------
// 基本の投稿を任意の名前に変更
---------------------------------------- */
function post_has_archive( $args, $post_type ) {
if ( 'post' == $post_type ) {
  $args['rewrite'] = true;
  $args['has_archive'] = 'column'; //任意のスラッグ名　←アーカイブページを有効に
  $args['label'] = 'コラム'; //管理画面左ナビに「投稿」の代わりに表示される
  }
  return $args;
}
add_filter( 'register_post_type_args', 'post_has_archive', 10, 2 );

add_filter( 'post_type_archive_link', function( $link, $post_type ) {
  if ( 'post' === $post_type ) {
  $post_type_object = get_post_type_object( 'post' );
  $slug = $post_type_object->has_archive;
  $link = get_home_url( null, '/' . $slug . '/' );
  }
  return $link;
 }, 10, 2 );
 function add_article_post_permalink( $permalink ) {
 $permalink = '/column' . $permalink; //「blog」は任意のものに変えて下さい。
  return $permalink;
 }
 add_filter( 'pre_post_link', 'add_article_post_permalink' );
 function add_article_post_rewrite_rules( $post_rewrite ) {
  $return_rule = array();
  foreach ( $post_rewrite as $regex => $rewrite ) {
  $return_rule['column/' . $regex] = $rewrite; //「blog」は任意のものに変えて下さい。
  }
 return $return_rule;
 }
 add_filter( 'post_rewrite_rules', 'add_article_post_rewrite_rules' );

/* ----------------------------------------
// cf7の自動挿入タグを無効
---------------------------------------- */
add_filter('wpcf7_autop_or_not', 'wpcf7_autop_return_false');
function wpcf7_autop_return_false() {
  return false;
} 

//----------------------------------------------------
// ビジュアルエディタにスタイルを適用
//----------------------------------------------------

function my_theme_setup() {
  // editor-styles を指定
  add_theme_support('editor-styles');
  // 読み込むスタイルシートの場所を指定
  add_editor_style('editor-style.css'); 
}
add_action('after_setup_theme', 'my_theme_setup');

//----------------------------------------------------
// 抜粋の記号と文字数の設定
//----------------------------------------------------

function excerpt_word() {
  return '...';
}
add_filter('excerpt_more','excerpt_word');

function excerpt_length() {
  return 80;
}
add_filter( 'excerpt_mblength', 'excerpt_length');

//----------------------------------------------------
// アーカイブTOPのパンクズ
//----------------------------------------------------
function my_static_breadcrumb_adder( $breadcrumb_trail ) {
  // 投稿タイプが 'post' またはカテゴリページ、検索結果ページ、単一投稿ページの場合に実行する
  if ( is_post_type_archive('post') || is_category() || is_search() || is_single() ) {

    $item = null; // $item を初期化

    if ( is_post_type_archive('post') || is_category() || is_search() ) { // 投稿一覧ページ、カテゴリページ、検索結果ページの場合
      $item = new bcn_breadcrumb('コラム一覧', null, array('post'), home_url('columns/'), null, true);
    } elseif ( is_single() && get_post_type() === 'post' ) { // 単一投稿ページで投稿タイプが 'post' の場合
      $item = new bcn_breadcrumb('コラム一覧', null, array('post'), home_url('columns/'), null, true);
    }

    if ( $item ) {
      $stuck = array_pop( $breadcrumb_trail->breadcrumbs ); // HOME 一時退避
      $breadcrumb_trail->breadcrumbs[] = $item; // コラム一覧 追加
      $breadcrumb_trail->breadcrumbs[] = $stuck; // HOME 戻す
    }
  }
}
add_action('bcn_after_fill', 'my_static_breadcrumb_adder');

//----------------------------------------------------
// エディター
//----------------------------------------------------
add_action('after_setup_theme', 'block_editor_css');
function block_editor_css() {
	add_theme_support('editor-styles');
	add_editor_style('css/style.css'); //サイトオリジナル
  add_editor_style('css/block.css');
	add_editor_style('editor-style.css'); //エディタ専用
}

//----------------------------------------------------
// メディアwebpアップ対応
//----------------------------------------------------
function custom_mime_types( $mimes ) {
  $mimes['webp'] = 'image/webp';
  return $mimes;
}

//----------------------------------------------------
// Yoast SEO：タイトル＆ディスクリプション設定のカスタマイズ
//----------------------------------------------------

// タイトル設定
function custom_wpseo_title($title){ 
  if ( is_post_type_archive( 'post' ) ) {
    $title = '新着コラム一覧 | レディースクリニックなみなみ【東京都目黒区】';
  }elseif( is_single() ){
    $title = get_the_title().' | レディースクリニックなみなみ【東京都目黒区】';
  }
  
  // 
  return $title; 
} 
add_filter('wpseo_title', 'custom_wpseo_title');

//----------------------------------------------------
// タグアーカイブページを無効に
//----------------------------------------------------
function disable_tag_archive( $query ) {
  if ( $query->is_tag() ) {
      $query->set_404();
  }
}
add_action( 'pre_get_posts', 'disable_tag_archive' );

//----------------------------------------------------
// パンクズの構造化データ
//----------------------------------------------------
function json_breadcrumb() {
 
  if( is_admin() || is_home() || is_front_page() ){ return; }
 
  $position  = 1;
  $query_obj = get_queried_object();
  $permalink = ( empty($_SERVER["HTTPS"] ) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
 
  $json_breadcrumb = array(
    "@context"        => "http://schema.org",
    "@type"           => "BreadcrumbList",
    "name"            => "パンくずリスト",
    "itemListElement" => array(
      array(
        "@type"    => "ListItem",
        "position" => $position++,
        "item"     => array(
          "name" => "HOME",
          "@id"  => esc_url( home_url('/') ),
        )
      ),
    ),
  );
 
  if( is_page() ) {
 
    $ancestors   = get_ancestors( $query_obj->ID, 'page' );
    $ancestors_r = array_reverse($ancestors);
    if ( count( $ancestors_r ) != 0 ) {
      foreach ($ancestors_r as $key => $ancestor_id) {
        $ancestor_obj = get_post($ancestor_id);
        $json_breadcrumb['itemListElement'][] = array(
          "@type"    => "ListItem",
          "position" => $position++,
          "item"     => array(
            "name" => esc_html($ancestor_obj->post_title),
            "@id"  => esc_url( get_the_permalink($ancestor_obj->ID) ),
          )
        );
      }
    }
    $json_breadcrumb['itemListElement'][] = array(
      "@type"    => "ListItem",
      "position" => $position++,
      "item"     => array(
        "name" => esc_html($query_obj->post_title),
        "@id"  => $permalink,
      )
    );
 
  } elseif( is_post_type_archive() ) {
 
    $json_breadcrumb['itemListElement'][] = array(
      "@type"    => "ListItem",
      "position" => $position++,
      "item"     => array(
        "name" => $query_obj->label,
        "@id"  => esc_url( get_post_type_archive_link( $query_obj->name ) ),
      )
    );
 
  } elseif( is_tax() || is_category() ) {
 
    if ( !is_category() ) {
      $post_type = get_taxonomy( $query_obj->taxonomy )->object_type[0];
      $pt_obj    = get_post_type_object( $post_type );
      $json_breadcrumb['itemListElement'][] = array(
        "@type"    => "ListItem",
        "position" => $position++,
        "item"     => array(
          "name" => $pt_obj->label,
          "@id"  => esc_url( get_post_type_archive_link($pt_obj->name) ),
        )
      );
    }
 
    $ancestors   = get_ancestors( $query_obj->term_id, $query_obj->taxonomy );
    $ancestors_r = array_reverse($ancestors);
    foreach ($ancestors_r as $key => $ancestor_id) {
      $json_breadcrumb['itemListElement'][] = array(
        "@type"    => "ListItem",
        "position" => $position++,
        "item"     => array(
          "name" => esc_html( get_cat_name($ancestor_id) ),
          "@id"  => esc_url( get_term_link($ancestor_id, $query_obj->taxonomy) ),
        )
      );
    }
 
    $json_breadcrumb['itemListElement'][] = array(
      "@type"    => "ListItem",
      "position" => $position++,
      "item"     => array(
        "name" => esc_html( $query_obj->name ),
        "@id"  => esc_url( get_term_link($query_obj) ),
      )
    );
 
  } elseif( is_single() ) {
 
    if ( !is_single('post') ) {
      $pt_obj = get_post_type_object( $query_obj->post_type );
      $json_breadcrumb['itemListElement'][] = array(
        "@type"    => "ListItem",
        "position" => $position++,
        "item"     => array(
          "name" => $pt_obj->label,
          "@id"  => esc_url( get_post_type_archive_link($pt_obj->name) ),
        )
      );
    }
 
    $json_breadcrumb['itemListElement'][] = array(
      "@type"    => "ListItem",
      "position" => $position++,
      "item"     => array(
        "name" => esc_html( $query_obj->post_title ),
        "@id"  => $permalink,
      )
    );
 
  } elseif( is_404() ) {
 
    $json_breadcrumb['itemListElement'][] = array(
      "@type"    => "ListItem",
      "position" => $position++,
      "item"     => array(
        "name" => "404 Not found",
        "@id"  => $permalink,
      )
    );
 
  } elseif( is_search() ) {
 
    $json_breadcrumb['itemListElement'][] = array(
      "@type"    => "ListItem",
      "position" => $position++,
      "item"     => array(
        "name" => "「" . get_search_query(). "」の検索結果",
        "@id"  => $permalink,
      )
    );
 
  }
 
  echo '<script type="application/ld+json">'.json_encode($json_breadcrumb).'</script>';
}
 
add_action( 'wp_head', 'json_breadcrumb' );

// ACFのオプションページ「ヘッダー設定」と入力項目を登録
// ※オプションページとリピーターは ACF Pro の機能です
add_action('acf/init', function () {
    if (!function_exists('acf_add_options_page') || !function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_options_page(array(
        'page_title' => 'ヘッダー設定',
        'menu_title' => 'ヘッダー設定',
        'menu_slug'  => 'header-settings',
        'capability' => 'edit_posts',
        'redirect'   => false,
    ));

    acf_add_local_field_group(array(
        'key'    => 'group_header_settings',
        'title'  => 'ヘッダー設定',
        'fields' => array(
            array(
                'key'   => 'field_header_catch',
                'label' => 'キャッチコピー（小さい文字）',
                'name'  => 'header_catch',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_header_address',
                'label' => '住所',
                'name'  => 'header_address',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_header_hours',
                'label' => '診療時間',
                'name'  => 'header_hours',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_header_closed',
                'label' => '休診日',
                'name'  => 'header_closed',
                'type'  => 'text',
            ),
            array(
                'key'          => 'field_header_nav',
                'label'        => 'ナビゲーション',
                'name'         => 'header_nav',
                'type'         => 'repeater',
                'layout'       => 'table',
                'button_label' => 'メニューを追加',
                'sub_fields'   => array(
                    array(
                        'key'   => 'field_header_nav_label',
                        'label' => '表示名',
                        'name'  => 'label',
                        'type'  => 'text',
                    ),
                    array(
                        'key'          => 'field_header_nav_url',
                        'label'        => 'リンク先（例：/staff/ または https://…）',
                        'name'         => 'url',
                        'type'         => 'text',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'options_page',
                    'operator' => '==',
                    'value'    => 'header-settings',
                ),
            ),
        ),
    ));
});

/* ----------------------------------------
// Googleフォント（Noto Sans JP / Shippori Mincho）
// ※すでにstyle.cssなどで読み込んでいる場合は、この処理は削除してください
---------------------------------------- */
function theme_google_fonts_url() {
    return 'https://fonts.googleapis.com/css2?family=Jost:wght@400;600&family=Noto+Sans+JP:wght@400;500;700&family=Shippori+Mincho:wght@400;500&display=swap';
}

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'theme-google-fonts',
        theme_google_fonts_url(),
        array(),
        null
    );
});

// ブロックエディタ(編集画面)でも同じフォントを読み込む
// ※ wp_enqueue_scripts は編集画面では動かないため、enqueue_block_assets を使う
add_action('enqueue_block_assets', function () {
    if (!is_admin()) {
        return;
    }
    wp_enqueue_style(
        'theme-google-fonts-editor',
        theme_google_fonts_url(),
        array(),
        null
    );
});

/* ----------------------------------------
// ACF：フッター設定（オプションページ）
// ※オプションページとリピーターは ACF Pro の機能です
// ※空欄の項目は、footer.php に書いてある初期値が表示されます
---------------------------------------- */
add_action('acf/init', function () {
    if (!function_exists('acf_add_options_page') || !function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_options_page(array(
        'page_title' => 'フッター設定',
        'menu_title' => 'フッター設定',
        'menu_slug'  => 'footer-settings',
        'capability' => 'edit_posts',
        'redirect'   => false,
    ));

    // 「表示名 + リンク先」のリピーター
    $menu_repeater = function ($key, $label, $name, $instructions = '') {
        return array(
            'key'          => 'field_' . $key,
            'label'        => $label,
            'name'         => $name,
            'type'         => 'repeater',
            'instructions' => $instructions,
            'layout'       => 'table',
            'button_label' => '項目を追加',
            'sub_fields'   => array(
                array(
                    'key'   => 'field_' . $key . '_label',
                    'label' => '表示名',
                    'name'  => 'label',
                    'type'  => 'text',
                ),
                array(
                    'key'   => 'field_' . $key . '_url',
                    'label' => 'リンク先（例：/staff/ または https://…）',
                    'name'  => 'url',
                    'type'  => 'text',
                ),
            ),
        );
    };

    acf_add_local_field_group(array(
        'key'    => 'group_footer_settings',
        'title'  => 'フッター設定',
        'fields' => array(
            // ---- フッターメニュー ----
            array(
                'key'       => 'field_footer_tab_menu',
                'label'     => 'フッターメニュー',
                'name'      => '',
                'type'      => 'tab',
                'placement' => 'top',
            ),
            $menu_repeater('footer_menu_about', '医院について', 'footer_menu_about', '空欄の場合は初期値が表示されます'),
            $menu_repeater('footer_menu_treatment', '診療案内', 'footer_menu_treatment', '件数の半分ずつ、左の列から順に2列で表示されます'),
            $menu_repeater('footer_menu_other', 'その他', 'footer_menu_other'),

            // ---- ガイドライン・コピーライト ----
            array(
                'key'       => 'field_footer_tab_guideline',
                'label'     => 'ガイドライン・コピーライト',
                'name'      => '',
                'type'      => 'tab',
                'placement' => 'top',
            ),
            array(
                'key'   => 'field_footer_guideline_text',
                'label' => '医療広告ガイドラインの説明文',
                'name'  => 'footer_guideline_text',
                'type'  => 'textarea',
                'rows'  => 3,
            ),
            $menu_repeater('footer_guideline_links', 'ガイドラインのリンク', 'footer_guideline_links', '別タブで開きます'),
            array(
                'key'   => 'field_footer_copyright',
                'label' => 'コピーライト',
                'name'  => 'footer_copyright',
                'type'  => 'text',
            ),

            // ---- 追従ボタン ----
            array(
                'key'       => 'field_footer_tab_cta',
                'label'     => '追従ボタン',
                'name'      => '',
                'type'      => 'tab',
                'placement' => 'top',
            ),
            array(
                'key'   => 'field_cta_web_url',
                'label' => 'WEB予約のリンク先',
                'name'  => 'cta_web_url',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_cta_white_url',
                'label' => 'ホワイトニング予約のリンク先',
                'name'  => 'cta_white_url',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_cta_tel',
                'label' => '電話番号（例：03-5848-9373）',
                'name'  => 'cta_tel',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_cta_tel_hours',
                'label' => '電話の受付時間の表記',
                'name'  => 'cta_tel_hours',
                'type'  => 'text',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'options_page',
                    'operator' => '==',
                    'value'    => 'footer-settings',
                ),
            ),
        ),
    ));
});

/* ----------------------------------------
// ACF：トップページのメインビジュアル（トップページの編集画面に表示されます）
// ※リピーターは ACF Pro の機能です
// ※「設定 > 表示設定」でトップページを固定ページに設定している場合に表示されます
// ※空欄の項目は、front-page.php に書いてある初期値が表示されます
---------------------------------------- */
add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key'    => 'group_front_mv',
        'title'  => 'メインビジュアル',
        'fields' => array(
            array(
                'key'   => 'field_mv_en',
                'label' => '英字コピー（小さい文字）',
                'name'  => 'mv_en',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_mv_lead',
                'label' => 'サブコピー',
                'name'  => 'mv_lead',
                'type'  => 'text',
            ),
            array(
                'key'          => 'field_mv_badges',
                'label'        => '丸いバッジ（最大3つ）',
                'name'         => 'mv_badges',
                'type'         => 'repeater',
                'instructions' => '改行した位置で、そのまま行が変わります',
                'layout'       => 'table',
                'max'          => 3,
                'button_label' => 'バッジを追加',
                'sub_fields'   => array(
                    array(
                        'key'   => 'field_mv_badges_text',
                        'label' => '文言',
                        'name'  => 'text',
                        'type'  => 'textarea',
                        'rows'  => 3,
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'page_type',
                    'operator' => '==',
                    'value'    => 'front_page',
                ),
            ),
        ),
    ));
});

/* ----------------------------------------
// ACF：トップページの Instagram 新着投稿（トップページの編集画面に表示されます）
// ※リピーターは ACF Pro の機能です
// ※画像は 1080×1350px（縦長 4:5）を推奨。表示は最大5件までです
// ※空欄の場合は、front-page.php でグレーの枠が仮表示されます
---------------------------------------- */
add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key'    => 'group_front_instagram',
        'title'  => 'Instagram 新着投稿',
        'fields' => array(
            array(
                'key'          => 'field_insta_posts',
                'label'        => '投稿',
                'name'         => 'insta_posts',
                'type'         => 'repeater',
                'instructions' => '最大5件まで。順番に真ん中へ回ってきます。画像は 1080×1350px（縦長）がおすすめです',
                'layout'       => 'table',
                'max'          => 5,
                'button_label' => '投稿を追加',
                'sub_fields'   => array(
                    array(
                        'key'           => 'field_insta_posts_image',
                        'label'         => '画像',
                        'name'          => 'image',
                        'type'          => 'image',
                        'return_format' => 'id',
                        'preview_size'  => 'medium',
                    ),
                    array(
                        'key'   => 'field_insta_posts_url',
                        'label' => 'リンク先（Instagramの投稿URL・空欄ならリンクなし）',
                        'name'  => 'url',
                        'type'  => 'url',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'page_type',
                    'operator' => '==',
                    'value'    => 'front_page',
                ),
            ),
        ),
    ));
});
