<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage cesselWebgateTheme
 * @since cesselWebgateTheme 0.1.5
 */
?>

<footer>
    <div class="container">
        <div class="inner">
            <div class="footer__blockLine">
                <div class="footer__block">
			        <? dynamic_sidebar( 'footer-left-sidebar' ); ?>
                </div>
                <div class="footer__block">
			        <? dynamic_sidebar( 'footer-center-sidebar' ); ?>
                </div>
                <div class="footer__block">
			        <? dynamic_sidebar( 'footer-right-sidebar' ); ?>
                </div>
            </div>
            <div class="footer__blockLine">
                <div class="footer__block w100">
			        <? dynamic_sidebar( 'footer-bottom-sidebar' ); ?>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>