<?php
/**
 * Post rendering content according to caller of get_template_part
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>


<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">


	<header class="entry-header">
	

        <div class="card" style="width: 18rem;">
            <div class="card-img-top"><?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?></div>
  
            <div class="card-body">
  
                <?php if ( 'post' === get_post_type() ) : ?>

		        <?php endif; ?>
  
                <h5 class="card-title">
	    	        <?php
			        the_title(
		        		sprintf( '<h5 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
		        		'</a></h5>'
		        	);
		        	?>
                </h5>
				
                <p class="card-text">
        		    <div class="entry-content">
				        <?php
				        the_excerpt();
		        		understrap_link_pages();
		        		?>
	        		</div><!-- .entry-content -->
	
	                <div class="card-footer">
	
	                    <small class="text-muted">
		    	    	<div class="entry-meta">
					    	<?php understrap_posted_on(); ?>
				    	</div><!-- .entry-meta -->
						</small>
			        </div>
	            </p>
	
    	    <footer class="entry-footer">
		    	<?php understrap_entry_footer(); ?>
    	    </footer><!-- .entry-footer -->
	
            </div>
        </div>

	</header><!-- .entry-header -->

</article><!-- #post-## -->


