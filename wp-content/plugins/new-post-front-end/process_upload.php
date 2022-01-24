<?php

// WordPress environment
require( dirname(__FILE__) . '/../../../wp-load.php' );

$wordpress_upload_dir = wp_upload_dir();
// $wordpress_upload_dir['path'] is the full server path to wp-content/uploads/2017/05, for multisite works good as well
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
	set_post_thumbnail( $_POST['actpostid'], $upload_id );
	
	// redirect to homepage
	?> <meta http-equiv="refresh" content="0; URL=<?php echo home_url(); ?>"> <?php

}