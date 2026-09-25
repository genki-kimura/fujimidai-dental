<?php
    // ページのタイトル
    $page_title = get_the_title();

    // コピーライトの日付
    $copyright_year = '2024'; // ここにコピーライトの日付を設定してください

    // ページの概要（description）
    $page_description = ''; // ここにページの概要を設定してください

    // 現在表示されているページのURL
    $current_url = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    // JSON-LDデータの構築
    $json_ld = array(
        '@context' => 'http://schema.org',
        '@type' => 'website',
        'name' => '',
        'inLanguage' => 'jp',
        'publisher' => array(
            '@type' => 'Organization',
            'name' => '',
            'logo' => array(
                '@type' => 'ImageObject',
                'url' => ''
            )
        ),
        'copyrightYear' => $copyright_year,
        'headline' => $page_title,
        'description' => $page_description,
        'url' => $current_url
    );

    // JSON-LDのスクリプトを出力
    echo '<script type="application/ld+json">' . wp_json_encode($json_ld) . '</script>';
?>

<script type="application/ld+json">
    {
    "@context": "https://schema.org",
    "@type": "MedicalBusiness", 
    "image": [
        "https://naminamicl.jp/wp-content/themes/naminamicl.jp/img/OGP.jpg"
    ],
    "name": "店舗名",
    "description":"",
    "address": {
        "@type": "PostalAddress",
        "streetAddress": "",
        "addressLocality": "",
        "addressRegion": "",
        "postalCode": "",
        "addressCountry": "JP"
    },
    "geo": {
        "@type": "GeoCoordinates",
        "latitude": 35.634376,
        "longitude": 139.711366
    },
    "url": "",
    "telephone": "",
    "openingHoursSpecification": [
            {
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": [
                    "Monday",
                    "Tuesday",
                    "Thursday",
                    "Friday"
                ],
                "opens": "09:00",
                "closes": "13:00"
            },
            {
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": [
                    "Monday",
                    "Tuesday",
                    "Thursday",
                    "Friday"
                ],
                "opens": "14:30",
                "closes": "19:30"
            },
            {
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": "Wednesday",
                "opens": "09:00",
                "closes": "13:00"
            },
            {
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": "Wednesday",
                "opens": "14:30",
                "closes": "17:00"
            },
            {
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": [
                    "Saturday",
                    "Sunday"
                ],
                "opens": "09:00",
                "closes": "13:00"
            },
            {
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": [
                    "Saturday",
                    "Sunday"
                ],
                "opens": "14:30",
                "closes": "17:00"
            }
        ]
    }
</script>