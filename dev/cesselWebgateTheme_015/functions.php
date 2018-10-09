<?php
require_once(get_template_directory().'/theme_settings/settings.php');
define('CES_IMG',get_template_directory_uri()."/img");
/* global $post */
// Удаляем лишнее с head части сайта при необходимости раскоментировать
/*
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links',       2 );
remove_action( 'wp_head', 'rsd_link'            ); 
remove_action( 'wp_head', 'wlwmanifest_link'    );
add_filter('the_generator', '__return_empty_string'); 
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );
remove_action( 'wp_head', 'wp_resource_hints', 2); 
remove_action('wp_head','start_post_rel_link',10,0);
remove_action( 'wp_head', 'rest_output_link_wp_head');
remove_action( 'wp_head', 'wp_oembed_add_discovery_links');
remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );
*/

function icon($iconname)
    {
        echo "<i class='icon-".$iconname."'></i>";
    }
function logo()
    {
	    $logo_src = wp_get_attachment_image_url(get_theme_mod( 'custom_logo'),'full');
        echo "<img src='".$logo_src."' alt='".get_bloginfo('name')." - наш логотип'>";
    }

/* АВТОМАТИЧЕСКОЕ ПОДКЛЮЧЕНИЕ JS И CSS ФАЙЛОВ ИЗ ПАПКИ /js/ и /css/ СООТВЕТСТВЕННО */
/*Для включения кеша закомментировать $v = time(); */

function CWG_scripts()
	{
		$v = 1;
        $v = time();
		$dir_js = get_template_directory().'/js/lib/';
		$dir_css = get_template_directory().'/css/libs/';
		$js_files=scandir($dir_js);
		$css_files=scandir($dir_css);
		$i=0;
		$uri_css = get_template_directory_uri() . '/css/';
		$uri_js = get_template_directory_uri() . '/js/';
		foreach ($js_files as $js)
			{
				$extension = explode('.',$js);
				if($extension[count($extension)-1]=='js')
					{
						wp_enqueue_script('script'.$i++,  $uri_js.'/lib/'. $js);
					}
				
			}
			$i=0;
		foreach ($css_files as $css)
			{
				$extension = explode('.',$css);
				if($extension[count($extension)-1]=='css')
					{
						wp_enqueue_style('style'.$i++, $uri_css .'/libs/'. $css);
					}
			}
		wp_enqueue_style('style_main', $uri_css . '/styles.css?v='.$v);
		//wp_enqueue_style('style_main', $uri_css . '/style.min.css?v='.$v);
		wp_enqueue_script('script_main', $uri_js . '/misc.js','jquery',$v);
	}
add_action( 'wp_enqueue_scripts', 'CWG_scripts' );


function modal_toggle_link($link_text,$id_modal,$link_class='site-btn')
	{
		echo '<a href="'.$id_modal.'" data-toggle="modal" data-target="'.$id_modal.'" class="'.$link_class.'">'.$link_text.'</a>';
	}
function get_sitedata($varname)
	{
		$page = get_page_by_title('Главная');
		return get_metadata('post',$page->ID, $varname, true);
		
	}
 function get_sitedata_dy_page_id($varname,$id)
	{
		$page = get_post( $id );
		return get_metadata('post',$page->ID, $varname, true);
		
	}
function remove_opensans_font()
	{
			
	}


register_nav_menus(array(
	'top'    => 'Верхнее меню',    //Название месторасположения меню в шаблоне
	'bottom' => 'Нижнее меню'      //Название другого месторасположения меню в шаблоне
));

function wp_kama_theme_setup(){
	// Поддержка миниатюр
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo' );
	add_theme_support( 'custom-header' );
	add_theme_support( 'custom-background' );
	add_theme_support('woocommerce');

}

add_action( 'after_setup_theme', 'wp_kama_theme_setup' );

add_action( 'widgets_init', 'register_my_widgets' );

function register_my_widgets() {
	register_sidebar( array(
		'name'          => 'Подвал - левый блок',
		'id'            => "footer-left-sidebar",
		'description'   => '',
		'class'         => '',
		'before_widget' => '<div class="widgetWrapper">',
		'after_widget'  => "</div>",
		'before_title'  => '<p class="widget__title">',
		'after_title'   => "</p>",
	) );
	register_sidebar( array(
		'name'          => 'Контакты - правый блок',
		'id'            => "contacts-sidebar",
		'description'   => '',
		'class'         => '',
		'before_widget' => '<div class="contactsWidgetWrapper">',
		'after_widget'  => "</div>",
		'before_title'  => '<p class="widget__title">',
		'after_title'   => "</p>",
	) );
	register_sidebar( array(
		'name'          => 'Контакты в подвале - левый блок',
		'id'            => "footer-contacts-left-sidebar",
		'description'   => '',
		'class'         => '',
		'before_widget' => '<div class="widgetWrapper">',
		'after_widget'  => "</div>",
		'before_title'  => '<p class="widget__title">',
		'after_title'   => "</p>",
	) );
	register_sidebar( array(
		'name'          => 'Контакты в подвале - центральный блок',
		'id'            => "footer-contacts-center-sidebar",
		'description'   => '',
		'class'         => '',
		'before_widget' => '<div class="widgetWrapper">',
		'after_widget'  => "</div>",
		'before_title'  => '<p class="widget__title">',
		'after_title'   => "</p>",
	) );
	register_sidebar( array(
		'name'          => 'Контакты в подвале - правый блок',
		'id'            => "footer-contacts-right-sidebar",
		'description'   => '',
		'class'         => '',
		'before_widget' => '<div class="widgetWrapper">',
		'after_widget'  => "</div>",
		'before_title'  => '<p class="widget__title">',
		'after_title'   => "</p>",
	) );
	register_sidebar( array(
		'name'          => 'Блок слайдера на главной странице',
		'id'            => "frontpage-banner",
		'description'   => '',
		'class'         => '',
		'before_widget' => '<div class="banner__carouselWrapper">',
		'after_widget'  => "</div>",
		'before_title'  => '',
		'after_title'   => "",
	) );
	register_sidebar( array(
		'name'          => 'Подвал - средний блок',
		'id'            => "footer-center-sidebar",
		'description'   => '',
		'class'         => '',
		'before_widget' => '<div class="widgetWrapper">',
		'after_widget'  => "</div>",
		'before_title'  => '<p class="widget__title">',
		'after_title'   => "</p>",
	) );
	register_sidebar( array(
		'name'          => 'Подвал - правый блок',
		'id'            => "footer-right-sidebar",
		'description'   => '',
		'class'         => '',
		'before_widget' => '<div class="widgetWrapper">',
		'after_widget'  => "</div>",
		'before_title'  => '<p class="widget__title">',
		'after_title'   => "</p>",
	) );
	register_sidebar( array(
		'name'          => 'Подвал - нижний блок',
		'id'            => "footer-bottom-sidebar",
		'description'   => '',
		'class'         => '',
		'before_widget' => '<div class="widgetWrapper">',
		'after_widget'  => "</div>",
		'before_title'  => '<p class="widget__title">',
		'after_title'   => "</p>",
	) );
}

function rus_date() {
// Перевод
 $translate = array(
 "am" => "дп",
 "pm" => "пп",
 "AM" => "ДП",
 "PM" => "ПП",
 "Monday" => "Понедельник",
 "Mon" => "Пн",
 "Tuesday" => "Вторник",
 "Tue" => "Вт",
 "Wednesday" => "Среда",
 "Wed" => "Ср",
 "Thursday" => "Четверг",
 "Thu" => "Чт",
 "Friday" => "Пятница",
 "Fri" => "Пт",
 "Saturday" => "Суббота",
 "Sat" => "Сб",
 "Sunday" => "Воскресенье",
 "Sun" => "Вс",
 "January" => "Января",
 "Jan" => "Янв",
 "February" => "Февраля",
 "Feb" => "Фев",
 "March" => "Марта",
 "Mar" => "Мар",
 "April" => "Апреля",
 "Apr" => "Апр",
 "May" => "Мая",
 "May" => "Мая",
 "June" => "Июня",
 "Jun" => "Июн",
 "July" => "Июля",
 "Jul" => "Июл",
 "August" => "Августа",
 "Aug" => "Авг",
 "September" => "Сентября",
 "Sep" => "Сен",
 "October" => "Октября",
 "Oct" => "Окт",
 "November" => "Ноября",
 "Nov" => "Ноя",
 "December" => "Декабря",
 "Dec" => "Дек",
 "st" => "ое",
 "nd" => "ое",
 "rd" => "е",
 "th" => "ое"
 );
 // если передали дату, то переводим ее
 if (func_num_args() > 1) {
 $timestamp = func_get_arg(1);
 return strtr(date(func_get_arg(0), $timestamp), $translate);
 } else {
// иначе текущую дату
 return strtr(date(func_get_arg(0)), $translate);
 }
 }
function phone_convert_to_link($tel,$class = '', $ancor = false)
{
	$ancor = $ancor ? $ancor : $tel;

	echo "<a href='tel:".preg_replace('/[ \-()]/','',$tel)."' class='".$class."'>".$ancor."</a>";
}
function email_convert_to_link($email,$class = '')
{
	echo "<a href='mailto:".$email."' class='".$class."'>".$email."</a>";
}
function skype_convert_to_link($skype)
	{
		echo "<a href='skype:".$skype."?chat'>$skype</a>";
	}
function generate_owl_from_post($cat_id,$numposts)
	{
		$args = array
			(
				'category' => $cat_id,
				'numberposts' => $numposts
			);
		$posts = get_posts($args);
		
		$return = "<div class='owl-carousel'>";
		
		foreach ($posts as $post)
			{
				
			}
			
		$return .= "</div>";
		return $return;
	}
	
	/* для bootstrap4 меню*/
add_filter( 'nav_menu_css_class', 'add_my_class_to_nav_menu', 10, 3 );
function add_my_class_to_nav_menu( $classes, $item  ){
	$classes[] = 'nav-item';
	return $classes;
}
add_filter( 'nav_menu_link_attributes', 'nav_link_filter', 10, 4 );
function nav_link_filter( $atts, $item, $args, $depth ){
	$atts['class'] = 'nav-link';
	return $atts;
}
add_shortcode( 'button', 'button_shortcode' );

function button_shortcode( $attr ){

	$link ='#link';
    if(isset($attr['link']))
        {
            $link = $attr['link'];
        }
	return "<a href='".$link."' class='btn ".$attr['class']."' >".$attr['text']."</a>";

}
add_shortcode( 'contacts', 'contacts_shortcode' );

function contacts_shortcode()
	{
		$contacts['tel'] = get_option('option_phone');
		return "<p class='contacts__line'>".phone_convert_to_link($contacts['tel'],false)."</p>";

}
add_shortcode( 'show_map', 'show_map_shortcode' );

function show_map_shortcode()
	{
		$contacts['adress'] = get_option('option_adress');
		$contacts['adress2'] = get_option('option_adress2');
		return "<div id='mapWidget' data-adress='".$contacts['adress']."' data-adress2='".$contacts['adress2']."' data-sitename='".get_bloginfo('name')."'></div>";

}


if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> 'Настройки сайта',
		'menu_title'	=> 'Настройки сайта',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}

























