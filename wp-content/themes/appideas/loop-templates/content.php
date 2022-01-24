<?php
/**
 * Post rendering content according to caller of get_template_part
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

    // retrieve average rating
    $postid = get_the_ID();
    $ratingavg = get_post_meta($postid, 'smp_rating_avg', true);

    if (empty($ratingavg))
    {
    $ratingavg = 0;
    }

	// retrieve categories
	$categories = get_the_category();
	$separator = ' ';
	$outputtags = '';
	$catclass = '';
	if ( !empty( $categories ) ) {
  	    foreach( $categories as $category ) {
  		// $output .= '<div class="tag"><a href="' . esc_url( get_category_link( $category->term_id ) ) . '" >&nbsp;&nbsp;'. esc_html( $category->name ) .'&nbsp;&nbsp;</a></div>' . $separator;
  		$outputtags .= '<div class="tag">&nbsp;&nbsp;'. esc_html( $category->name ) .'&nbsp;&nbsp;</div>' . $separator;
		$catclass .= esc_html( $category->name ) .' ';
 		}
	$catclass = trim($catclass);
	}





?>

<style>


 .tag {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  background-color: #e3e4f1;
  color: black;
  min-width: 1em;
  min-height: 1em;
  border-radius: 50px;
  vertical-align: middle;
  border: 1px solid #bebfda;
}

.card {
  width: 18rem;
  background-color: #f7f7fc!important;
  border-color: #e9ebf7;
}

/* unvisited link */
a:link {
  color: black;
}

/* visited link */
a:visited {
  color: black;
}

/* mouse over link */
a:hover {
  color: black;
  text-decoration: none;
}

/* selected link */
a:active {
  color: black;
  text-decoration: none;
}
}

</style>


<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">


	<header class="entry-header">

	    <!-- write categories into classes for filtering with isotope -->
        <div class="element-item <?php echo $catclass; ?>">


		    <!-- only needed for sorting -->
		    <!-- <div class="name"><?php // the_title() ?></div> -->
            <!-- <div class="postid"><?php // the_ID(); ?></div> -->
            <!-- <div class="rating"><?php // echo $ratingavg; ?></div> -->

            <div class="card" style="margin: auto;">

                <div class="card-body">

                    <?php if ( 'post' === get_post_type() ) : ?>

		            <?php endif; ?>

	    	            <?php
			            the_title(
		            		sprintf( '<h5 class="entry-title card-title"><a href="%s" rel="bookmark" style="color: #161615">', esc_url( get_permalink() ) ),
		        		'</a></h5>'
		            	);

                        // show tags
		            	if ( !empty( $categories ) ) {
  		            	    echo '<font size="2">' .trim($outputtags, $separator) .'</font>';
		            	}


		            	?>

                    <p class="card-text">
        	    	    <div class="entry-content">
				            <?php
				            // the_excerpt();
							the_content();
		            		understrap_link_pages();
		            		?>
	        	    	</div><!-- .entry-content -->


	                </p>

	
	                    <small class="text-muted">
		    	        <div class="entry-meta" align="right">

				            <?php echo get_the_date( 'd.m.Y' ); ?>

				        </div><!-- .entry-meta -->
				    	</small>



    	        <!-- <footer class="entry-footer"> -->
		        	<?php // understrap_entry_footer(); ?>
    	       <!-- </footer> --> <!-- .entry-footer -->

				</div>
            </div>
        </div>

	</header><!-- .entry-header -->

</article><!-- #post-## -->