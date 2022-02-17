<?php
/*
Plugin Name: Fahrplan
Description: Zeigt den Fahrplan mit Hlfe von opendata.ch an.
Version: 1.1
Author: Thomas Schaub
Author URI: na
*/
defined( 'ABSPATH' ) || exit;

    function fahrplan_infobox() {
?>

<head>
    <meta http-equiv="refresh" content="120">
	
</head>

    <script type="text/javascript">
        var clock = new StationClock("clock");
        clock.body = StationClock.RoundBody;
        clock.dial = StationClock.SwissStrokeDial;
        clock.hourHand = StationClock.SwissHourHand;
        clock.minuteHand = StationClock.SwissMinuteHand;
        clock.secondHand = StationClock.SwissSecondHand;
        clock.boss = StationClock.NoBoss;
        clock.minuteHandBehavoir = StationClock.BouncingMinuteHand;
        clock.secondHandBehavoir = StationClock.OverhastySecondHand;

        animate();

        function animate() {
            clock.draw();
            window.setTimeout("animate()", 50);
      }
    </script>

    <style>
        table {
			background-color: #2D327D;
            border-collapse: collapse;
			color: white;
            width: 100%;
        }

        th    {
            padding: 8px;
            line-height: 18px;
            vertical-align: center;
        }

        td    {
            padding: 8px;
            line-height: 18px;
            vertical-align: center;
            border-bottom: 1px solid #DDD;
        }
    </style>

<?php
    $location = 'Leutschenbach';
    $urlfp = 'http://transport.opendata.ch/v1/stationboard?station=' .$location .'&limit=15';
    $fpdaten = wp_remote_get($urlfp);
    $fpbody = json_decode($fpdaten['body'] ,true);

    echo '<br>';
    echo '<table>';
        echo '<tr>';
            echo '<th>';
                echo '<div style="text-align: left">';
                    echo '<canvas id="clock" width="75" height="75">';
                    echo '</canvas>';
                echo '</div>';
            echo '</th>';
			
            echo '<th>';
            echo '</th>';
			
            echo '<th style="font-size: x-large">';
                echo $fpbody['station']['name'];
            echo '</th>';
			
            echo '<th>';
            echo '</th>';
			
            echo '<th>';
            echo '</th>';
			
            echo '<th>';
            echo '</th>';
        echo '</tr>';

        echo '<tr>';
            echo '<th style="border-bottom: 1px solid #DDD">';
            echo '</th>';

            echo '<th style="border-bottom: 1px solid #DDD">';
                echo 'Linie';
            echo '</th>';
			
            echo '<th style="border-bottom: 1px solid #DDD">';
                echo 'Ziel';
            echo '</th>';
			
            echo '<th style="border-bottom: 1px solid #DDD; text-align:right">';
                echo 'Kante / Perron';
            echo '</th>';
			
            echo '<th style="border-bottom: 1px solid #DDD; text-align:center">';
                echo 'Abfahrt';
            echo '</th>';

            echo '<th style="border-bottom: 1px solid #DDD; text-align:center">';
                echo 'Hinweis';
            echo '</th>';
        echo '</tr>';

    for ($count = 0; $count < 15; $count+=1)
	    {
        echo '<tr>';
            echo '<td>';
	    		if ($fpbody['stationboard'][$count]['category']=='IC' or $fpbody['stationboard'][$count]['category']=='IR' or $fpbody['stationboard'][$count]['category']=='S' or $fpbody['stationboard'][$count]['category']=='EC' or $fpbody['stationboard'][$count]['category']=='TGV' or $fpbody['stationboard'][$count]['category']=='RE')
		    	    {
                        echo '<img src="' .get_bloginfo('url') .'/wp-content/plugins/fahrplan/images/Zug_r.svg" width="40" height="40">';
		    	    }
		    	elseif ($fpbody['stationboard'][$count]['category']=='B')
		    	    {
                        echo '<img src="' .get_bloginfo('url') .'/wp-content/plugins/fahrplan/images/Bus_r.svg" width="40" height="40">';
		    		}
		    	elseif ($fpbody['stationboard'][$count]['category']=='T')
		    	    {
                        echo '<img src="' .get_bloginfo('url') .'/wp-content/plugins/fahrplan/images/Tram_r.svg" width="40" height="40">';
		    		}
            echo '</td>';
			
            echo '<td>';
                echo $fpbody['stationboard'][$count]['category'] .$fpbody['stationboard'][$count]['number'];
            echo '</td>';

            echo '<td>';
                echo $fpbody['stationboard'][$count]['to'];
            echo '</td>';

            echo '<td style="text-align:right">';
                echo $fpbody['stationboard'][$count]['stop']['platform'];
            echo '</td>';

            echo '<td style="text-align:center">';
	            echo substr($fpbody['stationboard'][$count]['stop']['departure'],11,5);
            echo '</td>';
			
            echo '<td style="text-align:center">';
	            echo $fpbody['stationboard'][$count]['stop']['delay'];
            echo '</td>';
        echo '</tr>';
        }
    echo '</table>';	
}

function my_plugin_assets() {
    wp_enqueue_script( 'sbbclock', plugins_url( '/station-clock.js' , __FILE__ ), '','', false);
}

add_shortcode('fahrplan', 'fahrplan_infobox');
add_action( 'wp_enqueue_scripts', 'my_plugin_assets');