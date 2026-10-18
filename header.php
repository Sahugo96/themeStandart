<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google" content="notranslate">
    <link rel="icon" href="<?= THEME_PATH; ?>/favicon.ico">
    <link rel="mask-icon" href="<?= THEME_PATH; ?>/favicon.ico">
    <link rel="shortcut icon" href="<?= THEME_PATH; ?>/favicon.ico">
    <link rel="apple-touch-icon" href="<?= THEME_PATH; ?>/favicon.ico">
    <?php wp_head(); ?>
</head>

<body class="load-on-vissible--js notranslate" data-module="./modules/lazyLoad.js,./modules/menu.js">
    <div class="wrapper">

        <header class="header load-on-vissible--js" data-module="./modules/lazyLoad.js,./modules/headerScroll.js,./modules/menu.js,./modules/headerServicesPanel.js,./modules/modal.js,./modules/animSection.js,./modules/anchorScroll.js">
                <?php
                    get_template_part('modules/header-menu');
                ?>
        </header>