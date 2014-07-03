<?php
/**
 * The template for displaying attachments.
 *
 * @package WordPress
 * @subpackage purepress
 * @since purepress 1.0
 */
get_header();

?>

<section id="content">
    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
            <?php if ( ! empty( $post->post_parent ) ) : ?>
    
        
    <article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
        <a class="page-title" href="<?php echo get_permalink( $post->post_parent ); ?>" title="<?php esc_attr( printf( __( 'Return to %s', 'purepress' ), get_the_title( $post->post_parent ) ) ); ?>" rel="gallery">
            <span><?php printf( __( '<span class="meta-nav">&larr;</span> %s', 'purepress' ), get_the_title( $post->post_parent ) ); ?></span>
        </a>
            <?php endif; ?>
        <h2 class="entry-title"><?php the_title(); ?></h2>

        <div class="entry-content">
            <div class="entry-attachment">
                        <?php if ( wp_attachment_is_image() ) :
                            $attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
                            foreach ( $attachments as $k => $attachment ) {
                                if ( $attachment->ID == $post->ID )
                                    break;
                            }
                            $k++;
                            // If there is more than 1 image attachment in a gallery
                            if ( count( $attachments ) > 1 ) {
                                if ( isset( $attachments[ $k ] ) )
                                // get the URL of the next image attachment
                                    $next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
                                else
                                // or get the URL of the first image attachment
                                    $next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
                            } else {
                                // or, if there's only 1 image attachment, get the URL of the image
                                $next_attachment_url = wp_get_attachment_url();
                            }
                            ?>
                            <p><a href="<?php echo $next_attachment_url; ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php
                                                $attachment_size = apply_filters( 'purepress_attachment_size', 700 );
                                                echo wp_get_attachment_image( $post->ID, array( $attachment_size, 9999 ) ); // filterable image width with, essentially, no limit for image height.
                                                ?></a></p>
                             <div class="entry-meta">
                            <?php
                            printf(__('By %2$s', 'purepress'),
                                    'meta-prep meta-prep-author',
                                    sprintf( '<a class="url fn n" href="%1$s" title="%2$s">%3$s</a>',
                                    get_author_posts_url( get_the_author_meta( 'ID' ) ),
                                    sprintf( esc_attr__( 'View all posts by %s', 'purepress' ), get_the_author() ),
                                    get_the_author()
                                    )
                            );
                            ?>
                    <span>|</span>
                            <?php
                            printf( __('Published %2$s', 'purepress'),
                                    'meta-prep meta-prep-entry-date',
                                    sprintf( '<abbr title="%1$s">%2$s</abbr>',
                                    esc_attr( get_the_time() ),
                                    get_the_date()
                                    )
                            );
                            if ( wp_attachment_is_image() ) {
                                echo ' | ';
                                $metadata = wp_get_attachment_metadata();
                                printf( __( 'Full size is %s pixels', 'purepress'),
                                        sprintf( '<a href="%1$s" title="%2$s">%3$s &times; %4$s</a>',
                                        wp_get_attachment_url(),
                                        esc_attr( __('Link to full-size image', 'purepress') ),
                                        $metadata['width'],
                                        $metadata['height']
                                        )
                                );
                            }
                            ?>
                            <?php edit_post_link( __( 'Edit', 'purepress' ), '', '' ); ?>
                </div><!-- .entry-meta -->
                            <div class="entry-caption">
                                                <?php if ( !empty( $post->post_excerpt ) ) the_excerpt(); ?>
                                   <?php the_content( __( 'Continue reading &rarr;', 'purepress' ) ); ?>
                            </div>
                            
                    <?php wp_link_pages( array( 'before' => '' . __( 'Pages:', 'purepress' ), 'after' => '' ) ); ?>
                        
                        <?php else : ?>
                <a href="<?php echo wp_get_attachment_url(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php echo basename( get_permalink() ); ?></a>
                        <?php endif; ?>
            </div><!-- .entry-attachment -->
   
    <nav id="nav-below" class="navigation">
                                <?php $prev_img = get_prev_image_url(); if($prev_img){ ?>
                                <div class="nav-previous">
                                  <?php $image = vt_resize( '', $prev_img, 64, 64, true );
                                        echo '<img src="'.$image['url'].'" width="64" height="64" align="left"/>';
                                  ?>
                                    <p <?php if(!$prev_img){ echo 'class="no-image"';} ?>><?php _e( 'Previous image', 'purepress' ); ?><br/><?php previous_image_link(false); ?></p>
                                </div>
                                 <?php } ?>
                                <?php $next_img = get_prev_image_url(false);
                                 if($next_img){ ?>
                                    <div class="nav-next">
                                      <?php $image = vt_resize( '', $next_img,64, 64, true );
                                            echo '<img src="'.$image['url'].'" width="64" height="64" align="right"/>';
                                      ?>
                                      <p <?php if(!$next_img){ echo 'class="no-image"';} ?>><?php _e( 'Next image', 'purepress' ); ?><br/><?php next_image_link(false); ?></p>
                                    </div>
                                  <?php } ?>
                            </nav><!-- #nav-below -->
        </div><!-- .entry-content -->
    </article>
        <?php endwhile; ?>
</section>

</div>
<?php comments_template('', true); ?>

<?php get_footer(); ?>

