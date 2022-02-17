<?php
/*
Plugin Name: Twitter job bot
Description: Durchsucht Twitter-Einträge nach passenden Job-Angeboten, postet sie in Wordpress und sendet sie an einen Telegram-Bot.
Version: 1.0
Author: Thomas Schaub
Author URI: na
*/
defined( 'ABSPATH' ) || exit;

    require "vendor/autoload.php";
    use Abraham\TwitterOAuth\TwitterOAuth;
	
	// first we need an action we can call
    add_action('twitterbot_run', 'twitterbot');


function twitterbot() {

    // define keys needed to access twitter
    define('CONSUMER_KEY', 'DeJWNG38eAkN4VK5ErYxwiwR4');
    define('CONSUMER_SECRET', 'wZfjFi9boyOJkbtYxdI5wDpFHGnKRsbkgvm3mlRkWC2dMdBF8b');
    define('ACCESS_TOKEN', '1483425632428216322-N1u6eklUgayZWYGNHXmy7z3g0XzGJF');
    define('ACCESS_TOKEN_SECRET', 'adqDCRYu3lP9ofCjPF1h7FByucc8AJ4YXVyaHdqaOSBS6');
 
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);


    // retrieve highest tweet id from database (set it to 0 if it does not yet exist)
	$highest_tweetid = get_option('highest_tweetid', 0);

	// parameters used to customize twitter search
    $query = array(
    	"q" => "(job AND sap) OR (jobs AND sap)",
	    "count" => 100,
	    "result_type"=> "mixed",
	    "geocode" => "47.373127,8.534922,8000km",
		"since_id" => $highest_tweetid
    );
	
	// Retrieve tweets that match the criterias
    $tweets = $connection->get('search/tweets', $query);
	
	// ID of telegram bot and ChatID of user
	$telegram_botid = '5230449798:AAF7jlAYQUj_8kGh5jytITTxeEh2XI73CLY';
	$telegram_chatid = '841411814';
	
	
	// Process each tweet that was found
	foreach ($tweets->statuses as $tweet) {
	
	
	    // echo '<li>'.$tweet->id .' ' .$tweet->text.'<br>Posted on: <a href="https://twitter.com/'.$tweet->user->screen_name.'/status/'.$tweet->id.'" target="_blank">'.date('Y-m-d H:i:s', strtotime($tweet->created_at)).'</a>' .'</li>';
	
        // Title of post for wordpress
	    $posttitle = substr($tweet->text, 0, 50) .'...';
		
		// Content of post for wordpress
	    $postcontent = $tweet->text .'<br><a href="https://twitter.com/' .$tweet->user->screen_name.'/status/' .$tweet->id .'" target="_blank">' .$tweet->id .'</a>';
		
		// Content of post for telegram
	    $postcontent_telegram = rawurlencode($tweet->text) .'%0Ahttps://twitter.com/' .$tweet->user->screen_name .'/status/' .$tweet->id;
		
		// Date of post for wordpress
		$postdate = date('Y-m-d H:i:s', strtotime($tweet->created_at));
		
	    // Defining complete post for wordpress
        $my_post = array(
          'post_title'    => wp_strip_all_tags($posttitle),
          'post_content'  => $postcontent,
          'post_status'   => 'publish',
		  'post_author'   => 1,  // post as admin
	      'post_date'     => $postdate
                        );

        // post tweet in wordpress
	    wp_insert_post( $my_post );
		
		
		// Send to Telegram Bot 
		// https://api.telegram.org/bot[BOT_API_KEY]/sendMessage?chat_id=[MY_CHANNEL_NAME]&text=[MY_MESSAGE_TEXT]
		
		$telegram_url = 'https://api.telegram.org/bot' .$telegram_botid .'/sendMessage?chat_id=' .$telegram_chatid .'&text=' .$postcontent_telegram;
		
		// Call URL to post in telegram
		wp_remote_post( $telegram_url);
		
		
		// Set highest tweetid if new tweetid is higher
		if ($tweet->id>$highest_tweetid)
		{
			$highest_tweetid = $tweet->id;
		}
		
		
	}
	
	// update highest tweetid in database
	update_option( 'highest_tweetid', $highest_tweetid, false );
	
	
}


register_activation_hook( __FILE__ ,  'my_activation' );

// Do this every minute. Cron event "twitterbot_run"
function my_activation() {
    if ( !wp_next_scheduled( 'twitterbot_run' ) ) {
        wp_schedule_event( current_time( 'timestamp' ), 'minute', 'twitterbot_run');
    }
}
