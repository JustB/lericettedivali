<?php
/**
 * Template Name: Advanced Search Page
 *
 * A custom page template without sidebar.
 *
 * The "Template Name:" bit above allows this to be selectable
 * from a dropdown menu on the edit page screen.
 *
 * @package WordPress
 * @subpackage purepress
 * @since purepress 1.0
 */
get_header();

?>

<h2 class="template-subtitle">
    <span><?php the_title(); ?>
    </span>
</h2>
<section id="content" role="main" >
    <?php get_template_part( 'searchformadv' ); ?>


    <?php /* Display navigation to next/previous pages when applicable */ ?>

    <?php
if ( get_query_var('paged') ) {
                        $paged = get_query_var('paged');
                } elseif ( get_query_var('page') ) {
                        $paged = get_query_var('page');
                } else {
                        $paged = 1;
                }
  if ($_GET['submit']) {
      
        $args = array(
                
                'tax_query' => array(
                        'relation' => 'AND'
                ),
                'post_type' => 'post',
                'posts_per_page' => 10,
                  'paged' => $paged 
        );

        $cat = $_GET['cat'];
        $categories = array();
        if($cat) {
            $categories = array (
                    'taxonomy' => 'category',
                    'field' => 'term_id',
                    'terms' => array( $cat )
            );
            array_push($args['tax_query'],$categories);
        }

        $level = $_GET['level'];
        $levels = array();
        if($level) {
            $levels = array (
                    'taxonomy' => 'level',
                    'field' => 'slug',
                    'terms' => array( $level )
            );
            array_push($args['tax_query'],$levels);
        }

        $serving = $_GET['serving'];
        if($serving) {
            $servings = array (
                    'taxonomy' => 'serving',
                    'field' => 'slug',
                    'terms' => array( $serving )
            );
            array_push($args['tax_query'],$servings);
        }

        $time = $_GET['timeneeded'];
        if($time) {
            $times = array (
                    'taxonomy' => 'timeneeded',
                    'field' => 'slug',
                    'terms' => array( $time )
            );
            array_push($args['tax_query'],$times);
        }

  
        $allergen = $_GET['allergens'];
        if($allergen) {
            $allergens = array (
                    'taxonomy' => 'allergen',
                    'field' => 'slug',
                    'terms' => $allergen
            );
            array_push($args['tax_query'],$allergens);
        }

        $tags = $_GET['include_ing'];

        if($_GET['relation']=='all') {
            if($tags) {
                foreach ($tags as $t) {
                    $tagsquery = array (
                            'taxonomy' => 'post_tag',
                            'field' => 'slug',
                            'terms' => $t
                    );
                    array_push($args['tax_query'],$tagsquery);
                }
            }
        } else {
            if($tags) {
                $tagsquery = array (
                        'taxonomy' => 'post_tag',
                        'field' => 'slug',
                        'terms' => $tags
                );
                
                array_push($args['tax_query'],$tagsquery);
            }
       }

        $extags = $_GET['exclude_ing'];
        if($extags) {
                $extagsquery = array (
                        'taxonomy' => 'post_tag',
                        'field' => 'slug',
                        'terms' => $extags,
                        'operator' => 'NOT IN'
                );
                array_push($args['tax_query'],$extagsquery);
            }

// The Query
//        query_posts($args);

           $the_query= null;
query_posts($args); 
//     $the_query->query( $args );


        echo '<section id="articles">';
        
         if (!have_posts()) : ?>
    <article id="post-0" class="post error404 not-found">
        <h2 class="entry-title"><?php _e('Not Found', 'purepress'); ?></h2>
        <div class="entry-content">
            <p><?php _e('Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'purepress'); ?></p>
              
        </div><!-- .entry-content -->
    </article><!-- #post-0 -->
    <?php endif; ?>
    <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
                <?php if (has_post_thumbnail()) { ?>
            <a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'purepress'), the_title_attribute('echo=0')); ?>" rel="bookmark">
                        <?php the_post_thumbnail(); ?>
            </a>
                    <?php } ?>

                <?php printf( '<a href="%1$s" class="published-time" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',get_permalink(),esc_attr( get_the_time() ),get_the_date()); ?>
            <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'purepress'), the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

                <?php if (has_post_thumbnail() == FALSE ) { ?>

            <div class="entry-content">
                        <?php if (post_password_required()) : ?>
                            <?php echo get_the_excerpt('Read more &raquo;'); ?><a class='read-more' href="<?php get_permalink(); ?>">&hellip;</a>
                        <?php else : ?>
                            <?php echo get_the_excerpt('Read more &raquo;');
                            echo "<a class='read-more' href=".get_permalink()."> read more &rarr;</a>";
                        endif; ?>
            </div><!-- .entry-content -->
                    <?php } ?>
            <footer>
                    <?php purepress_postmeta() ?>
            </footer>
        </article><!-- #post-## -->
        <?php endwhile; // End the loop. Whew.?>
</section>
<?php /* Display navigation to next/previous pages when applicable */ ?>


<nav id="nav-below" class="navigation">
        <div class="nav-previous"><?php next_posts_link(__('&larr; Older posts', 'purepress')); ?></div>
        <div class="nav-next"><?php previous_posts_link(__('Newer posts &rarr;', 'purepress')); ?></div>
</nav><!-- #nav-below -->
<?php 

// Reset Post Data
        
    }
?>

</section>

</section>


<div id="primary">
    <?php echo get_sidebar(); ?></div>
</div>

<?php get_footer(); ?>
