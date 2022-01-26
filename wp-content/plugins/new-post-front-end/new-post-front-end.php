<?php
/*
Plugin Name: Totally Simple shortcode for new Post [newidea]
Plugin URI: -
Description: -
Author: -
Version: 0.1a
Author URI: -
*/

add_shortcode('newidea','newidea_callback');




function enqueue_styles()  {
	
	wp_enqueue_style( 'materialicons', 'https://fonts.googleapis.com/icon?family=Material+Icons', '', '', false );
	wp_enqueue_style( 'materialroboto', 'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700', '', '', false );
	
	wp_enqueue_style( 'materialcss', 'https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css', '', '', false );
	wp_enqueue_script( 'materialjs', 'https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js', '', '', true );
	
	wp_enqueue_script( 'initjs', plugins_url( '/init.js' , __FILE__ ), '', '', true );

	wp_enqueue_style( 'npfe-designcss', plugin_dir_url( __FILE__ ). 'npfe_design.css', '', '', false );

}

add_action( 'wp_enqueue_scripts', 'enqueue_styles' );


function newidea_callback()
{



?>

<style>
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






</style>


<?php


// Step B: In our file that handles the request, verify the nonce.
$nonce = '';
if(isset($_REQUEST['check']))
{
	$nonce = $_REQUEST['check'];
}
if ( ! wp_verify_nonce( $nonce, 'app-idea' ) ) {
	

echo '<form action="" method="post" enctype="multipart/form-data">';
	
$nonce = wp_create_nonce( 'app-idea' );
echo '<input type="hidden" name="check" value="'.$nonce.'" />';
	
?>
	

<div style="position: relative; left: 380px">
    <a href="<?php echo home_url(); ?>"><span class="bgroundback dashicons dashicons-no-alt"></span></a>
</div>

    <br><br>

	<div class="mdc-text-field mdc-text-field--outlined">
	    <label for="title"> </label>
		<input type="text" id="title" name="title" class="mdc-text-field__input">
		<div class="mdc-notched-outline">
			<div class="mdc-notched-outline__leading"></div>
			<div class="mdc-notched-outline__notch">
				<label for="title" class="mdc-floating-label">Name der Idee...</label>
			</div>
			<div class="mdc-notched-outline__trailing"></div>
		</div>
	</div>

    <br><br>
	



<label class="mdc-text-field mdc-text-field--outlined mdc-text-field--textarea mdc-text-field--with-internal-counter">
  <span class="mdc-notched-outline">
    <span class="mdc-notched-outline__leading"></span>
    <span class="mdc-notched-outline__notch">
      <span class="mdc-floating-label" id="content">Beschreibung...</span>
    </span>
    <span class="mdc-notched-outline__trailing"></span>
  </span>
  <span class="mdc-text-field__resizer">
    <textarea class="mdc-text-field__input" aria-labelledby="my-label-id" rows="8" cols="45" maxlength="1000" id="content" name="content"></textarea>
    <span class="mdc-text-field-character-counter">0 / 1000</span>
  </span>
</label>


    <br><br>



	
<?php



    $args = array(
        'hide_empty' => false,
    	'orderby' => 'name',
        'order'   => 'ASC'
    );
    $categories = get_categories($args);


	echo '<label for="file-upload" class="custom-file-upload"><i class="fa fa-cloud-upload"></i> Laden sie ein Foto hoch';
	echo '<input id="file-upload" type="file" name="profilepicture" accept="image/png, image/jpeg, image/gif" /></label>';
    echo '<br><br>';

    echo '<div>';

    foreach( $categories as $category ) {
	
        if ($category->name!=='Uncategorized' and $category->name!=='Designer' and $category->name!=='Entwickler' and $category->name!=='Allgemein')
        {

            echo '<label class="labeltags" for="' .$category->term_id .'">';
            echo '<input type="checkbox" id="' .$category->term_id .'" value="' .$category->term_id .'" name="cat[]">';
			echo '<span>' .$category->name .'</span></label>';
			
        }
    }

    echo '</div>';
    echo '<br>';
	

    echo '<div>';

    foreach( $categories as $category ) {
	
        if ($category->name=='Designer')
        {
            // echo '<input type="radio" id="' .$category->term_id .'" name="desentw" value="' .$category->term_id .'" checked>';
            // echo '<label for="' .$category->term_id .'">' .$category->name .'</label>';
			
            echo '<label class="labeltags" for="' .$category->term_id .'">';
			echo '<input type="radio" id="' .$category->term_id .'" name="desentw" value="' .$category->term_id .'" checked>';
			echo '<span>' .$category->name .'</span></label>';

			
			
        }
		
        if ($category->name=='Entwickler')
        {
            echo '<label class="labeltags" for="' .$category->term_id .'">';
			echo '<input type="radio" id="' .$category->term_id .'" name="desentw" value="' .$category->term_id .'">';
			echo '<span>' .$category->name .'</span></label>';
        }
		
		
		
    } 

    echo '</div>';
    echo '<br>';

	
	echo '<button class="buttonbright" type="submit" formaction="' .home_url() .'">&nbsp;&nbsp;&nbsp; Abbrechen &nbsp;&nbsp;&nbsp;</button>';
	echo '&nbsp;&nbsp;&nbsp;&nbsp;';
	echo '<button class="buttondark" name="subject" type="submit">&nbsp;&nbsp;&nbsp; Erstellen &nbsp;&nbsp;&nbsp;</button>';
	echo '</form>';





} else
{
	

    if (empty($_POST['title']))
	{
		// Go back to homepage if title is missing
		?> <meta http-equiv="refresh" content="0; URL=<?php echo home_url(); ?>"> <?php
		die();
	}



    $selectedcat = [];

	if (isset($_POST['cat']))
	{
	    $selectedcat = $_POST['cat'];
	}
	
	$desentw = $_POST['desentw'];
	
	$selectedcat[] = $desentw;
	
	
    // Create post object
	$my_post = array(
  		'post_title'    => wp_strip_all_tags( $_POST['title'] ),
  		'post_content'  => $_POST['content'],
  		'post_status'   => 'publish',
  		'post_author'   => get_current_user_id(),
		'post_category' => $selectedcat,
	);
	 
	// Insert the post into the database
	$postid = wp_insert_post( $my_post );
	

    // WordPress environment
    require( dirname(__FILE__) . '/../../../wp-load.php' );

    $wordpress_upload_dir = wp_upload_dir();
    // $wordpress_upload_dir['path'] is the full server path to wp-content/uploads/2022/01, for multisite works good as well
    // $wordpress_upload_dir['url'] the absolute URL to the same folder, actually we do not need it, just to show the link to file
    $i = 1; // number of tries if the file with the same name already exists

    $profilepicture = $_FILES['profilepicture'];

    if( empty($profilepicture) or empty($profilepicture['name']))
    {
    	// die( 'File is not selected.' );
        ?> <meta http-equiv="refresh" content="0; URL=<?php echo home_url(); ?>"> <?php
        die();
    }


    $new_file_path = $wordpress_upload_dir['path'] . '/' . $profilepicture['name'];

    $new_file_mime = mime_content_type( $profilepicture['tmp_name'] );


    if( $profilepicture['error'] )
    {
    	die( $profilepicture['error'] );
    }
	
    if( $profilepicture['size'] > wp_max_upload_size() )
    {
    	die( 'File too large.' );
    }
	
    if( !in_array( $new_file_mime, get_allowed_mime_types() ) )
    {
    	die( 'WordPress doesn\'t allow this type of uploads.' );
    }

	
    while( file_exists( $new_file_path ) ) {
    	$i++;
    	$new_file_path = $wordpress_upload_dir['path'] . '/' . $i . '_' . $profilepicture['name'];
    }

    // looks like everything is OK
    if( move_uploaded_file( $profilepicture['tmp_name'], $new_file_path ) ) {
	

    	$upload_id = wp_insert_attachment( array(
    		'guid'           => $new_file_path, 
	    	'post_mime_type' => $new_file_mime,
	    	'post_title'     => preg_replace( '/\.[^.]+$/', '', $profilepicture['name'] ),
	    	'post_content'   => '',
	    	'post_status'    => 'inherit'
    	), $new_file_path );

	    // wp_generate_attachment_metadata() won't work if you do not include this file
	    require_once( ABSPATH . 'wp-admin/includes/image.php' );

	    // Generate and save the attachment metas into the database
	    wp_update_attachment_metadata( $upload_id, wp_generate_attachment_metadata( $upload_id, $new_file_path ) );

    	// Show the uploaded file in browser
    	// wp_redirect( $wordpress_upload_dir['url'] . '/' . basename( $new_file_path ) );
	
	    // set thumbnail
	    set_post_thumbnail( $postid, $upload_id );
	
	    // redirect to homepage
	    ?> <meta http-equiv="refresh" content="0; URL=<?php echo home_url(); ?>"> <?php

    }
	

}



}