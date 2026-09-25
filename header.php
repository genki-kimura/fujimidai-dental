<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
    <!-- favicon OGP-->
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/img/favicon.svg" type="image/svg+xml">
    <meta property="og:title" content="">
    <meta property="og:description" content="">
    <meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/img/OGP.jpg">
    <?php get_template_part('/json/json-basic'); ?>
    <?php get_template_part('/json/json-faq'); ?>
    <?php if(is_single()){get_template_part('/json/json-column');}; ?>
</head>
<body>
    <header></header>
    <main>