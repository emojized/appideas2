<?php
/*
Plugin Name: Star my Posts
Description: Simple Plugin to star a post
Author: Thomas Schaub
Version: 1.7
Author URI: http://twofold.swiss/
*/

/*
Star my Posts and Pages is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
Star my Posts and Pages is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with Star my Posts and Pages. If not, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.html.
*/

// Objectives
// this simple plugin should just show the selected stars from many users
// it is limited to logged in users , so the other visitors just see the stars but cant vote
//
// for first test stars could be in the add_filter("the_title"
// don't use an external star image instead use the dashicon for a star
// https://developer.wordpress.org/resource/dashicons/#star (note: to use them you need to enqueue them in front end)
// with the half star you have the possibility to show a value like 3.5
// these part is already seen in the example
// When someone votes on the stars, the total number and the user is saved in the post_meta,
// or if it makes sense in the user_meta. be creative whats the best option here.
// not recommended!!!: creating an extra table for the votes in the WordPress Database.
// In the normal case, the user can always vote for the stars but only in such a way that his old value is overwritten.
// So if he doesn't like the post anymore, he can give it 1 star, even though he previously gave it 4.
// it should be possible to sort by votes in the front end.
// if we like it, we can think of to publish it to the wordpress repository and of course use it ourself
// we simply can't wrote twofold as author uri than we have no approval.
defined('ABSPATH') || exit;


add_action('wp_enqueue_scripts', 'smp_dashicons_front_end');

function smp_dashicons_front_end()
{
    wp_enqueue_style('dashicons');
	wp_enqueue_style('smp-designcss', plugin_dir_url( __FILE__ ). 'smp-design.css', '', '', false );
}

add_filter('the_title','smp_title_plus_stars', 5000);


function smp_title_plus_stars($title)
{
	
	// if not a post then return the $title as is
    if ('post' !== get_post_type() or !in_the_loop() or is_nav_menu_item() ) {
        return $title;
    }
	
    return '<span class="title-left">' .$title .'</span><span class="stars-right">' .smp_show_the_stars() .'</span>';
}


function smp_show_the_stars()
{



    // refresh necessary to show correct average value after submitting the form
    if (isset($_POST['star1']) or isset($_POST['star2']) or isset($_POST['star3']) or isset($_POST['star4']))
    {
        echo '<meta http-equiv="refresh" content="0">';
    }

    // setting variable based on chosen rating by the user
	if (isset($_POST['star1']))
	{
		$starvalue = intval($_POST['star1']);
    }
	elseif (isset($_POST['star2']))
	{
		$starvalue = intval($_POST['star2']);
    }
	elseif (isset($_POST['star3']))
	{
		$starvalue = intval($_POST['star3']);
    }
	elseif (isset($_POST['star4']))
	{
		$starvalue = intval($_POST['star4']);
    }
	else
	{
		$starvalue = NULL;
	}

    if ($starvalue < 1 and $starvalue !== 0)
    {
        $starvalue = 1;
    }
    elseif ($starvalue > 4)
    {
        $starvalue = 4;
    }

    // setting different variables
	
    if (isset($_POST['postidcheck']))
	{
        $postidcheck = $_POST['postidcheck'];
	}
	else
	{
		$postidcheck = NULL;
    }

    $userid = get_current_user_id();
    $postid = get_the_ID();
	$oldrating = array();
	$ratinguser = array();
	$ratingnew = array();
	
    $starfilledshow = '<span class="dashicons star-color-filled"></span>';
	$starhalfshow = '<span class="dashicons star-color-half"></span>';
    // $starfilledshow = '<span class="dashicons dashicons-star-filled star-color-filled"></span>';
    $staremptyshow = '<span class="dashicons star-color-empty"></span>';
    // $staremptyshow = '<span class="dashicons dashicons-star-empty star-color"></span>';

    // var_dump($postid);

    // retrieving saved values from the database (wp_postmeta)
    $oldrating = get_post_meta($postid, 'smp_rating_user', false);
    $ratingtotal = intval(get_post_meta($postid, 'smp_rating_total', true));
    $ratingcount = intval(get_post_meta($postid, 'smp_rating_count', true));
    $ratingavg = get_post_meta($postid, 'smp_rating_avg', true);
	
    if (!empty($oldrating))
	{
        $oldrating = $oldrating[0];
	}

    if (!empty($oldrating) and !empty($oldrating[$userid]))
	{
     // retrieving previous rating of current user
        $olduserrating = $oldrating[$userid];
	
     // difference between current rating and previous rating used for calculating new total
        $diff = intval($olduserrating) - intval($starvalue);
	}
	else
	{
		$olduserrating = NULL;
	}
	
	
    // putting the user id and new rating in an array
    $ratinguser = array(
        $userid => intval($starvalue) ,
    );


    ob_start();

    // only show stars (average rating) to not logged in users, no modification possible (userid 0 is guest)
    if ($userid == 0)
    {


        if (is_null($ratingavg) or $ratingavg < 1)
        {
        echo ' ' .$staremptyshow .$staremptyshow .$staremptyshow .$staremptyshow;
        }

        elseif ($ratingavg >= 1 and $ratingavg < 1.25)
        {
        echo ' ' .$starfilledshow .$staremptyshow .$staremptyshow .$staremptyshow;
        }

        elseif ($ratingavg >= 1.25 and $ratingavg < 1.75)
        {
        echo ' ' .$starfilledshow .$starhalfshow .$staremptyshow .$staremptyshow;
        }

        elseif ($ratingavg >= 1.75 and $ratingavg < 2.25)
        {
        echo ' ' .$starfilledshow .$starfilledshow .$staremptyshow .$staremptyshow;
        }

        elseif ($ratingavg >= 2.25 and $ratingavg < 2.75)
        {
        echo ' ' .$starfilledshow .$starfilledshow .$starhalfshow .$staremptyshow;
        }

        elseif ($ratingavg >= 2.75 and $ratingavg < 3.25)
        {
        echo ' ' .$starfilledshow .$starfilledshow .$starfilledshow .$staremptyshow;
        }

        elseif ($ratingavg >= 3.25 and $ratingavg < 3.75)
        {
        echo ' ' .$starfilledshow .$starfilledshow .$starfilledshow .$starhalfshow;
        }

        elseif ($ratingavg >= 3.75)
        {
        echo ' ' .$starfilledshow .$starfilledshow .$starfilledshow .$starfilledshow;
        }

	    return ob_get_clean();
    }


    // logged in users see the average rating and can vote themselves
	

    echo '<form id="stars" method="POST">';

    if (is_null($ratingavg) or $ratingavg < 1)
    {
         echo '<button class="buttonstar" id="star1" name="star1" type="submit" value="1">' .$staremptyshow .'</button>'.
              '<button class="buttonstar" id="star2" name="star2" type="submit" value="2">' .$staremptyshow .'</button>'.
              '<button class="buttonstar" id="star3" name="star3" type="submit" value="3">' .$staremptyshow .'</button>'.
              '<button class="buttonstar" id="star4" name="star4" type="submit" value="4">' .$staremptyshow .'</button>';
    }

    elseif ($ratingavg >= 1 and $ratingavg < 1.25)
    {
         echo '<button class="buttonstar" id="star1" name="star1" type="submit" value="1">' .$starfilledshow .'</button>'.
              '<button class="buttonstar" id="star2" name="star2" type="submit" value="2">' .$staremptyshow .'</button>'.
              '<button class="buttonstar" id="star3" name="star3" type="submit" value="3">' .$staremptyshow .'</button>'.
              '<button class="buttonstar" id="star4" name="star4" type="submit" value="4">' .$staremptyshow. '</button>';
    }

    elseif ($ratingavg >= 1.25 and $ratingavg < 1.75)
    {
         echo '<button class="buttonstar" id="star1" name="star1" type="submit" value="1">' .$starfilledshow .'</button>'.
              '<button class="buttonstar" id="star2" name="star2" type="submit" value="2">' .$starhalfshow .'</button>'.
              '<button class="buttonstar" id="star3" name="star3" type="submit" value="3">' .$staremptyshow .'</button>'.
              '<button class="buttonstar" id="star4" name="star4" type="submit" value="4">' .$staremptyshow. '</button>';
    }

    elseif ($ratingavg >= 1.75 and $ratingavg < 2.25)
    {
         echo '<button class="buttonstar" id="star1" name="star1" type="submit" value="1">' .$starfilledshow .'</button>'.
              '<button class="buttonstar" id="star2" name="star2" type="submit" value="2">' .$starfilledshow .'</button>'.
              '<button class="buttonstar" id="star3" name="star3" type="submit" value="3">' .$staremptyshow .'</button>'.
              '<button class="buttonstar" id="star4" name="star4" type="submit" value="4">' .$staremptyshow .'</button>';
    }

    elseif ($ratingavg >= 2.25 and $ratingavg < 2.75)
    {
         echo '<button class="buttonstar" id="star1" name="star1" type="submit" value="1">' .$starfilledshow .'</button>'.
              '<button class="buttonstar" id="star2" name="star2" type="submit" value="2">' .$starfilledshow .'</button>'.
              '<button class="buttonstar" id="star3" name="star3" type="submit" value="3">' .$starhalfshow .'</button>'.
              '<button class="buttonstar" id="star4" name="star4" type="submit" value="4">' .$staremptyshow .'</button>';
    }

    elseif ($ratingavg >= 2.75 and $ratingavg < 3.25)
    {
         echo '<button class="buttonstar" id="star1" name="star1" type="submit" value="1">' .$starfilledshow .'</button>'.
              '<button class="buttonstar" id="star2" name="star2" type="submit" value="2">' .$starfilledshow .'</button>'.
              '<button class="buttonstar" id="star3" name="star3" type="submit" value="3">' .$starfilledshow .'</button>'.
              '<button class="buttonstar" id="star4" name="star4" type="submit" value="4">' .$staremptyshow .'</button>';
	}

    elseif ($ratingavg >= 3.25 and $ratingavg < 3.75)
    {
         echo '<button class="buttonstar" id="star1" name="star1" type="submit" value="1">' .$starfilledshow .'</button>'.
              '<button class="buttonstar" id="star2" name="star2" type="submit" value="2">' .$starfilledshow .'</button>'.
              '<button class="buttonstar" id="star3" name="star3" type="submit" value="3">' .$starfilledshow .'</button>'.
              '<button class="buttonstar" id="star4" name="star4" type="submit" value="4">' .$starhalfshow .'</button>';
	}

    elseif ($ratingavg >= 3.75)
    {
         echo '<button class="buttonstar" id="star1" name="star1" type="submit" value="1">' .$starfilledshow .'</button>'.
              '<button class="buttonstar" id="star2" name="star2" type="submit" value="2">' .$starfilledshow .'</button>'.
              '<button class="buttonstar" id="star3" name="star3" type="submit" value="3">' .$starfilledshow .'</button>'.
              '<button class="buttonstar" id="star4" name="star4" type="submit" value="4">' .$starfilledshow .'</button>';
    }





    wp_nonce_field('submit-postid_' . get_the_ID());

    // postid transmitted so it can be checked against actual postid (used for overview page of the wordpress page)
    echo '<input type="hidden" name="postidcheck" value="' . $postid . '">';

    echo '</form>';

    // check nonce after submitting the form
    if (isset($_POST['star1']) or isset($_POST['star2']) or isset($_POST['star3']) or isset($_POST['star4']))
    {
        check_admin_referer('submit-postid_' . $postidcheck);
    }

    // calculation of the total of the ratings and the number of users that voted
    // setting of values if it's the first time someone votes
    if (is_null($olduserrating) and is_null($oldrating) and $starvalue > 0 and $postid == $postidcheck)
    {
        $ratingnew = $ratinguser;
        $ratingtotal = intval($starvalue);
        $ratingcount = 1;
    }
    // setting of values if it's the first time the current user votes (but other ratings exist)
    elseif (is_null($olduserrating) and !is_null($oldrating) and $starvalue > 0 and $postid == $postidcheck)
    {
        $ratingnew = $oldrating + $ratinguser;
        $ratingtotal = $ratingtotal + intval($starvalue);
        $ratingcount = $ratingcount + 1;
    }
    // setting of values if the current user already voted before
    elseif (!is_null($olduserrating) and $starvalue > 0 and $postid == $postidcheck)
    {
        $ratingnew = array_replace($oldrating, $ratinguser);
        $ratingtotal = intval($ratingtotal) - intval($diff);
    }

    // calculating the average based on the total and the amount of users that voted
    if ($ratingcount > 0 and $postid == $postidcheck)
    {
        $ratingavg = round($ratingtotal / $ratingcount, 1);
    }
    // if no user voted the average is set to 0
    elseif ($ratingcount == 0 and $postid == $postidcheck)
    {
        $ratingavg = 0;
    }

    // writing the calculated values to the database (wp_postmeta)
    if ($starvalue > 0 and $postid == $postidcheck)
    {
        update_post_meta($postid, 'smp_rating_user', $ratingnew);
        update_post_meta($postid, 'smp_rating_total', $ratingtotal);
        update_post_meta($postid, 'smp_rating_count', $ratingcount);
        update_post_meta($postid, 'smp_rating_avg', $ratingavg);
    }

	return ob_get_clean();

}



