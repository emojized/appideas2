<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


function index_enqueue_styles()  {
//    wp_enqueue_script( 'isotope-sortjs', get_stylesheet_directory_uri() . '/js/isotope-sort.js', '', '', true );
    wp_enqueue_script( 'dropdown', get_stylesheet_directory_uri() . '/js/dropdown.js', '', '', true );
    wp_enqueue_script( 'isotope-searchfilter', get_stylesheet_directory_uri() . '/js/isotope-searchfilter.js', '', '', true );
    wp_enqueue_style( 'isotope-designcss', get_stylesheet_directory_uri() . '/css/isotope-design.css', '', '', false );
    wp_enqueue_style( 'index-designcss', get_stylesheet_directory_uri() . '/css/index-design.css', '', '', false );
	}

add_action( 'wp_enqueue_scripts', 'index_enqueue_styles' );

get_header();


$container = get_theme_mod( 'understrap_container_type' );
?>

<?php if ( is_front_page() && is_home() ) : ?>
	<?php get_template_part( 'global-templates/hero' ); ?>
<?php endif; ?>

<div class="wrapper" id="index-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

				<!-- Do the left sidebar check and opens the primary div -->
				<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

				<main class="site-main" id="main">

					<?php
					if ( have_posts() ) {
						// Start the Loop.
					


echo '<div class="flex-container">';
echo '<div class="bground">';
echo '&nbsp;&nbsp;' .get_bloginfo(). '&nbsp&nbsp;';
echo '</div>';

?>




<div id="form-ui">
 <div class="dropdown bground">
  <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"><span class="dropdown-text"> Filters</span>
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <!-- <li><a href="#"><label><input type="checkbox" class="selectall" /><span class="select-text"> Select</span> All</label></a></li> -->
    <li class="divider"></li>

	<?php

	$args = array(
        'hide_empty' => true,
    	'orderby' => 'name',
        'order'   => 'ASC'
    );
    $categories = get_categories($args);
	

    foreach( $categories as $category ) {
	
        if ($category->name!=='Uncategorized')
        {
		echo '<li><a href="#"><label><input name="options[]" type="checkbox" class="option justone" value=".';
		echo $category->name .'"/> ' .$category->name .'</label></a></li>';
        }
    }


	?>


  </ul>
 </div>
</div>



<input type="text" class="quicksearch bground" size="40" placeholder="  Search..." />

<!-- <span style="position: relative; left: -75px; z-index: 2;" class="dashicons dashicons-search"></span> -->

<!-- Link to profile page -->
<!-- <a href="<?php esc_attr_e(get_edit_profile_url()); ?>"> -->
<a href="<?php echo get_site_url(); ?>/index.php/profile/">
    <?php echo get_avatar(get_current_user_id(), 26); ?>
</a>

<!-- Link to new post page -->
<!-- <a href="<?php // echo get_site_url(); ?>/wp-admin/post-new.php" class="bground">+</a> -->
<a href="<?php echo get_site_url(); ?>/index.php/newpost/" class="bgrounddarknewpost">+</a>


</div>


<?php


						// echo '<div class="button-group sort-by-button-group">';
                        // echo '<button class="button" data-sort-value="name">Name</button>';
                        // echo '<button class="button is-checked" data-sort-value="postid">Datum</button>';
                        // echo '<button class="button" data-sort-value="rating">Rating</button>';
                        // echo '</div>';
						echo '<div class="grid">';

						while ( have_posts() ) {
							the_post();
							/*
							* Include the Post-Format-specific template for the content.
							* If you want to override this in a child theme, then include a file
							* called content-___.php (where ___ is the Post Format name) and that will be used instead.
							*/


							get_template_part( 'loop-templates/content', get_post_format() );

						}

						echo '</div>';

					} else {
						get_template_part( 'loop-templates/content', 'none' );
					}
					?>

				</main><!-- #main -->
				

			<!-- The pagination component -->
			<?php understrap_pagination(); ?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #index-wrapper -->


<?php
get_footer();

