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
	<style>.preloader{top:0;bottom:0;left:0;right:0;position:fixed;display:flex;align-items:center;align-content:center;justify-content:center;background-color:#fff;font-size:5em;;z-index: 999999999999;}.preloader i{color:#537791;}</style>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title><?php wp_title(); ?></title>
	<? wp_site_icon(); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="preloader"><i class="icon-spin icon-2x animate-spin"></i></div>
<header> 
</header>