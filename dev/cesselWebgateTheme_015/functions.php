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
/* Админ бар */
add_filter('show_admin_bar', '__return_false'); // отключить
//add_filter('show_admin_bar', '__return_true'); // включить

if ( ! is_admin() ) {
	remove_action( 'wp_head', 'wp_print_scripts' );
	remove_action( 'wp_head', 'wp_print_head_scripts', 9 );
	remove_action( 'wp_head', 'wp_enqueue_scripts', 1 );
	add_action( 'wp_footer', 'wp_print_scripts', 5 );
	add_action( 'wp_footer', 'wp_enqueue_scripts', 5 );
	add_action( 'wp_footer', 'wp_print_head_scripts', 5 );
}

function icon($iconname)
    {
        echo "<i class='icon-".$iconname."'></i>";
    }
function logo($with_link = true)
{
	$logo_src = wp_get_attachment_image_url(get_theme_mod( 'custom_logo'),'full');
	$logo_html = ($with_link && !(is_home()||is_front_page())) ? "<a href='".get_home_url()."' title='".get_bloginfo('name')." - на главную'><img src='".$logo_src."' alt='".get_bloginfo('name')." - наш логотип'></a>" : "<img src='".$logo_src."' alt='".get_bloginfo('name')." - наш логотип'>";

	echo $logo_html;
}

/* АВТОМАТИЧЕСКОЕ ПОДКЛЮЧЕНИЕ JS И CSS ФАЙЛОВ ИЗ ПАПКИ /js/ и /css/ СООТВЕТСТВЕННО */
/*Для включения кеша закомментировать $v = time(); */

function CWG_scripts()
	{
		$v = 1;
        $v = time();
		$uri_css = get_template_directory_uri() . '/css';
		$uri_js = get_template_directory_uri() . '/js';

		wp_enqueue_style('style_main_lib', $uri_css . '/libs/libs.min.css','',$v);
		wp_enqueue_style('style_main', $uri_css . '/styles.css','',$v);
		wp_enqueue_script('script_main_lib', $uri_js . '/libs/libs.min.js','',$v);
		if(function_exists('get_field') && get_field('включить_яндекс_карты','options'))
			{
				wp_enqueue_script('yandex_map', 'https://api-maps.yandex.ru/2.1/?lang=ru_RU');
			}
		wp_enqueue_script('script_main', $uri_js . '/misc.js','',$v);
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

function show_map($longtitude, $lattitude,$adress,$sitename = false)
	{
		$sitename = ($sitename) ? $sitename : bloginfo('name');
		echo '<!-- MAP SECTION --><div class="ymap-container"><div class="loader loader-default"></div><div id="map-yandex" data-sitename="'.$sitename.'" data-adress="'.$adress.'" data-lat="'.$lattitude.'" data-long="'.$longtitude.'"></div></div><!-- .ymap-container --><!-- END MAP SECTION -->';
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
if( function_exists('acf_add_local_field') ) {
	acf_add_local_field(array(
		'key' => 'field_enable_ymaps',
		'label' => 'Включить Яндекс карты',
		'name' => 'включить_яндекс_карты',
		'type' => 'true_false',
		'parent' => 'site-settings'
	));
}
if( function_exists('acf_add_local_field_group') ) {
	acf_add_local_field_group(array(
		'key' => 'site-settings',
		'title' => 'Настройки сайта',
		'fields' => array (),
		'location' => array (
			array (
				array (
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'theme-general-settings',
				),
			),
		),
	));
}

function some_replaces($content)
    {
        $replaces[] = array('find' => '[FIRMNAME]','replace' => get_bloginfo('name'));
	    foreach ( $replaces as $replace ) {
		    $content = str_replace($replace['find'],$replace['replace'],$content);
        }
        return $content;
    }
add_filter('the_content','some_replaces');

function get_image_field($selector,$post_id,$size = 'large',$img_tag = false){
	if(function_exists('get_field')){
			$image_id = get_field($selector,$post_id);
	$size = (!empty($size)) ? $size : 'large' ;
	$return = wp_get_attachment_image_url($image_id,$size); 
	
	$return = ($img_tag) ? '<img src="'.$return.'" alt="">' : $return ;
	}
	else{
		$return = false;
	}
	return $return;
}
	
function generate_excerpt($post,$numwords = 10) 
	{
		$experpt = (has_excerpt($post->ID)) ? wp_trim_words(shortcode_remover(get_the_excerpt($post->ID),$numwords)) : wp_trim_words(shortcode_remover($post->post_content),$numwords) ;
		return $experpt;
}
function shortcode_remover($content)
    {
	    $content = strip_shortcodes(preg_replace( '~\[[^\]]+\]~', '', strip_tags($content)));
        return $content;
    }
