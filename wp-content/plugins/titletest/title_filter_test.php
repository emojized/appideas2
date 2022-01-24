<?php
/*
Plugin Name: Title Filter Test
Description: TFT
Author: TFT
Version: 0.2
*/

add_filter('the_title','get_some_cool_stuff_to_the_title', 5000);


function get_some_cool_stuff_to_the_title($post_title)
{

	$post_title = '<span class="iam-title-left">'.$post_title.'</span> ';
	$post_title .= '<span class="iam-title-right">'.some_real_crazy_stuff().'</span>';

	return $post_title;
}

function some_real_crazy_stuff()
{
	// buffer start
	ob_start();
	
	echo '<div style="width:40px;height:40px;display:inline-block;border-radius:50px">';
	echo '[crazy_form_in_shortcode]'; // einmal funktion blöde umgehen
	echo '</div>';
	
	return ob_get_clean();

}

// shortcode für meien funktion
add_shortcode('crazy_form_in_shortcode','crazy_form_in_shortcode');

// der Title muss aber auch Shortcode ausführen
add_action('the_title','do_shortcode', 5001);

function crazy_form_in_shortcode()
{
	global $post;
	ob_start();
	echo '<form><input type="text" value="'.$post->ID.'"><input type="submit" value="boah" /></form>';
	return ob_get_clean();
}