<?
/**
 * The Header template for our theme
 *
 *
 *
 * @package WordPress
 * @subpackage cesselWebgateTheme
 * @since cesselWebgateTheme 0.1.5
 */
?><!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title><?php wp_title(); ?></title>
	<? wp_site_icon(); ?>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&amp;subset=cyrillic,cyrillic-ext" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php get_template_part('modals'); ?>

<?php /* БЛОК НАСТРОЕК */ ?>
<?php $contacts['tel'] = get_option('option_phone'); ?>

<header>
</header>