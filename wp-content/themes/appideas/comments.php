
<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

?>


<style>

.card {
  width: 18rem;
  background-color: #f7f7fc!important;
  border-color: #e9ebf7;
}

</style>

<?php




/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>


<div class="comments-area" id="comments">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>


		<?php understrap_comment_navigation( 'comment-nav-above' ); ?>



		<!-- <div class="card" style="margin: auto;">
            <div class="card-body">

	            <?php // comment_form(); // Render comments form. ?>

			</div> 

		</div> 
        <br> -->


		<?php
				
		    wp_list_comments(
			    array(
			    	'style'      => 'ol',
			    	'short_ping' => true,
					'callback' => 'better_comments'
			    )
		    );

		?>

		<!-- .comment-list -->

		<?php understrap_comment_navigation( 'comment-nav-below' ); ?>

	<?php endif; // End of if have_comments(). ?>
	
	
	<?php // if ( !have_comments() ) : ?>
	
	<!-- <div class="card" style="margin: auto;">
        <div class="card-body"> -->
	
	        <?php // comment_form(); // Render comments form. ?>
			
		<!-- </div>
		
	</div> -->

	<?php // endif; // End of if !have_comments(). ?>


</div><!-- #comments -->
