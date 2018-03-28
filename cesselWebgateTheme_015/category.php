<?php
/**
 * Created by PhpStorm.
 * User: cesse
 * Date: 27.10.2017
 * Time: 13:38
 */

get_header(); ?>


<div class="container category">
    <div class="inner">
<?

$cat = get_queried_object();
$currentCatId = $cat->term_id;

?>

    <h1 class='category__title'><? echo $cat->name; ?></h1>

    <div class="category__wrapper">
        <?php  if( have_posts() ){while(have_posts()){the_post(); ?>

            <? $content = (has_excerpt()) ? get_the_excerpt($post->ID) : wp_trim_words($post->post_content,55); ?>

            <div class="category__item">
                <div class="category__itemImg"><img src="<? echo get_the_post_thumbnail_url($post->ID); ?>" alt=""></div>
                <div class="category__itemContent">
                    <div class="category__itemTitle">
                        <h2><a href="<? echo get_post_permalink($post->ID); ?>"><? the_title(); ?></a></h2>
                    </div>
                    <div class="category__itemData">
                        <span>Дата:</span>
                        <span><? echo get_the_date( '', $post ); ?></span>
                    </div>
                    <div class="category__itemExcerpt"><? echo $content; ?></div>
                    <div class="category__itemMoreBtn">
                        <a class='site-btn' href="<? echo get_post_permalink($post->ID); ?>">Подробнее...</a>
                    </div>
                </div>
            </div>



       <? }} else echo "<h2>Записей нет.</h2>";?>



    </div>
	<?php echo paginate_links(); ?>

    </div>
</div>






<? get_footer();?>