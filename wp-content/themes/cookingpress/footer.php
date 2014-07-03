<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage purepress
 * @since purepress 1.0
 */
?>
</section><!-- #main -->

<footer role="contentinfo" class="contentinfo">
    <div id="pattern-container">
        <div class="container">
            <div class="footer-widgets clearfix">

                <div id="footer-left-column" class="fcolumn">
                    <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Left Column')) : ?>
                    <?php endif; ?>
                </div>
                <div id="footer-center-column" class="fcolumn">
                    <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Center Column')) : ?>
                    <?php endif; ?>
                </div>
                <div id="footer-right-column" class="fcolumn">
                    <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Right Column')) : ?>
                    <?php endif; ?>
                </div>
                
                
                <div id="footer-bottom">
                      <?php echo get_option(PPTNAME.'_copyrights'); ?>
                    <a href="#top" id="gototop"><?php _e( 'Go to top &uarr;', 'purepress' ); ?></a>
                </div>
            </div>

           
        </div>
    </div>
</footer><!-- footer -->
</div> <!-- container -->
<?php
/* Always have wp_footer() just before the closing </body>
 * tag of your theme, or you will break many plugins, which
 * generally use this hook to reference JavaScript files.
 */
wp_footer();
?>

<script type="text/javascript" src="http://assets.pinterest.com/js/pinit.js"></script>
</body>
</html>