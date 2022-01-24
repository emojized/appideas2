<?php
/*
Plugin Name: Weather Widget
Description: Zeigt das Wetter mit Hilfe von MetaWeather auf dem Wordpress-Dashboard an
Version: 1.2
Author: Thomas Schaub
Author URI: na
*/
defined( 'ABSPATH' ) || exit;

function weather_zh_dashboard_widget() {
    global $wp_meta_boxes;
    add_meta_box( 'dashboard_weather_zh_infobox_widget', 'Weather', 'weather_infobox', 'dashboard', 'normal', 'high' );
}
add_action('wp_dashboard_setup', 'weather_zh_dashboard_widget');


function weather_infobox() {

?>

<style>
 .weatherpic {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  background-color: #00BFFF;
  color: yellow;
  min-width: 7em;
  min-height: 7em;
  border-radius: 50%;
  vertical-align: middle;
}

.bgbright {
  background-color: #418A43;
  color: white;
  height: 25px;
  line-height: 25px;
  text-align: center;
}

.bgmiddle {
  background-color: #74A07D;
  color: white;
  height: 25px;
  line-height: 25px;
  text-align: center;
}

.bgdark {
  background-color: #124913;
  color: white;
  height: 25px;
  line-height: 25px;
  text-align: center;
}
</style>

<div>
	<form id="location">
	<input type="text" name="ort" id="ort"><br>
	<input type="submit" value="Go">
	</form>
</div>	

<?php
	
    if(!isset($_GET['ort']))
        {
		    $woeid = get_option( 'weatherwoeid', $default = false );
	    	$locationname = get_option( 'weathername', $default = false );
		}
	else
		{
			$input = $_GET['ort'];
			$urllocation = 'https://www.metaweather.com/api/location/search/?query=' .$input;
			$woeidget = json_decode(wp_remote_get($urllocation)['body'] ,true);
			$woeid = $woeidget[0]['woeid'];
			$locationname = $woeidget[0]['title'];	
		}

    if(is_null(($woeid)) or !isset($woeid) or $woeid == '')
        {
		    echo 'No weather data found.';
		}
	
	echo '<b>' .$locationname .'</b>';	
	
	$urlwoeapi = 'https://www.metaweather.com/api/location/' .$woeid;
	$weathercontent = wp_remote_get($urlwoeapi);
	$weatherbody = json_decode($weathercontent['body'] ,true);

    add_option( 'weatherwoeid' , '' , '');
    update_option( 'weatherwoeid' , $woeid );
	
    add_option( 'weathername' , '' , '');
    update_option( 'weathername' , $locationname );

    $dat2 = date('d.m.Y', strtotime($Date. ' + 2 days'));
    $dat3 = date('d.m.Y', strtotime($Date. ' + 3 days'));
    $dat4 = date('d.m.Y', strtotime($Date. ' + 4 days'));
    $dat5 = date('d.m.Y', strtotime($Date. ' + 5 days'));
	
	$dat0tag = substr(date('l', strtotime($Date. ' + 0 days')),0,3);
	$dat1tag = substr(date('l', strtotime($Date. ' + 1 days')),0,3);
    $dat2tag = substr(date('l', strtotime($Date. ' + 2 days')),0,3);
    $dat3tag = substr(date('l', strtotime($Date. ' + 3 days')),0,3);
    $dat4tag = substr(date('l', strtotime($Date. ' + 4 days')),0,3);
    $dat5tag = substr(date('l', strtotime($Date. ' + 5 days')),0,3);
	

    echo '<table width="100%" > <tr> <td valign="top">';
	
	echo '<center>';
	echo '<p><b>Today (' .$dat0tag .')</b></p>';
	
    echo '<span class="weatherpic">';
	
	If($weatherbody['consolidated_weather'][0]['weather_state_abbr'] == 'hr')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/hr.png">';
		}
	elseif($weatherbody['consolidated_weather'][0]['weather_state_abbr'] == 'sn')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/sn.png">';
		}
	elseif($weatherbody['consolidated_weather'][0]['weather_state_abbr'] == 'sl')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/sl.png">';
		}
	elseif($weatherbody['consolidated_weather'][0]['weather_state_abbr'] == 'h')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/h.png">';
		}
	elseif($weatherbody['consolidated_weather'][0]['weather_state_abbr'] == 't')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/t.png">';
		}
	elseif($weatherbody['consolidated_weather'][0]['weather_state_abbr'] == 'lr')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/lr.png">';
		}
	elseif($weatherbody['consolidated_weather'][0]['weather_state_abbr'] == 's')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/s.png">';
		}
	elseif($weatherbody['consolidated_weather'][0]['weather_state_abbr'] == 'hc')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/hc.png">';
		}
	elseif($weatherbody['consolidated_weather'][0]['weather_state_abbr'] == 'lc')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/lc.png">';
		}
	elseif($weatherbody['consolidated_weather'][0]['weather_state_abbr'] == 'c')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/c.png">';
		}
    else
        {
        echo "";
        }

    echo '</span>';
	
	$visibilitykm0 = intval($weatherbody['consolidated_weather'][0]['visibility'])*1.609344;
	$wind_speedkmh0 = intval($weatherbody['consolidated_weather'][0]['wind_speed'])*1.609344;
	
	echo '<h1>' .round($weatherbody['consolidated_weather'][0]['the_temp'],0) .' &#8451;' .'</h1>';
	
	echo '</center>';
	
    echo '<h5>';
	
	if (round($weatherbody['consolidated_weather'][0]['max_temp'],0) >= 14)
		{
		echo '<div class="bgbright">';
		}
	elseif (round($weatherbody['consolidated_weather'][0]['max_temp'],0) < 14 and round($weatherbody['consolidated_weather'][0]['max_temp'],0) >= 7)
		{
		echo '<div class="bgmiddle">';
		}
	elseif (round($weatherbody['consolidated_weather'][0]['max_temp'],0) < 7)
		{
		echo '<div class="bgdark">';
		}
	else
		{
		echo '<div>';
		}
    echo '' .round($weatherbody['consolidated_weather'][0]['max_temp'],0) .' &#8451;' ."<br>";
	echo '</div>';
	if (round($weatherbody['consolidated_weather'][0]['min_temp'],0) >= 14)
		{
		echo '<div class="bgbright">';
		}
	elseif (round($weatherbody['consolidated_weather'][0]['min_temp'],0) < 14 and round($weatherbody['consolidated_weather'][0]['min_temp'],0) >= 7)
		{
		echo '<div class="bgmiddle">';
		}
	elseif (round($weatherbody['consolidated_weather'][0]['min_temp'],0) < 7)
		{
		echo '<div class="bgdark">';
		}
	else
		{
		echo '<div>';
		}
    echo '' .round($weatherbody['consolidated_weather'][0]['min_temp'],0) .' &#8451;' ."<br>";
	echo '</div>';
/*  echo '' .$weatherbody['consolidated_weather'][0]['weather_state_name'] ."<br>"; */
	echo 'Wind Direction: ' .$weatherbody['consolidated_weather'][0]['wind_direction_compass'] ."<br>";
    echo 'Wind Speed: ' .round($wind_speedkmh0,1) . ' km/h' ."<br>";
/*  echo 'Wind Direction: ' .round($weatherbody['consolidated_weather'][0]['wind_direction'],1) .' degrees' ."<br>"; */
/*  echo 'Air Pressure: ' .round($weatherbody['consolidated_weather'][0]['air_pressure'],0) .' mbar' ."<br>"; */
    echo 'Humidity: ' .$weatherbody['consolidated_weather'][0]['humidity'] .'%' ."<br>";
    echo 'Visibility: ' .round($visibilitykm0,1) .' km' ."<br>";
/*  echo 'Predictability: ' .$weatherbody['consolidated_weather'][0]['predictability'] .'%'; */
	
    echo '</h5>';
    echo '</td>';
	
    echo '<td valign="top">';
	
	echo '<center>';
	echo '<p><b>Tomorrow (' .$dat1tag .')</b></p>';

    echo '<span class="weatherpic">';

	If($weatherbody['consolidated_weather'][1]['weather_state_abbr'] == 'hr')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/hr.png">';
		}
	elseif($weatherbody['consolidated_weather'][1]['weather_state_abbr'] == 'sn')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/sn.png">';
		}
	elseif($weatherbody['consolidated_weather'][1]['weather_state_abbr'] == 'sl')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/sl.png">';
		}
	elseif($weatherbody['consolidated_weather'][1]['weather_state_abbr'] == 'h')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/h.png">';
		}
	elseif($weatherbody['consolidated_weather'][1]['weather_state_abbr'] == 't')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/t.png">';
		}
	elseif($weatherbody['consolidated_weather'][1]['weather_state_abbr'] == 'lr')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/lr.png">';
		}
	elseif($weatherbody['consolidated_weather'][1]['weather_state_abbr'] == 's')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/s.png">';
		}
	elseif($weatherbody['consolidated_weather'][1]['weather_state_abbr'] == 'hc')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/hc.png">';
		}
	elseif($weatherbody['consolidated_weather'][1]['weather_state_abbr'] == 'lc')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/lc.png">';
		}
	elseif($weatherbody['consolidated_weather'][1]['weather_state_abbr'] == 'c')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/c.png">';
		}
    else
        {
        echo "";
        }

    echo '</span>';
	
	$visibilitykm1 = intval($weatherbody['consolidated_weather'][1]['visibility'])*1.609344;
	$wind_speedkmh1 = intval($weatherbody['consolidated_weather'][1]['wind_speed'])*1.609344;
	
	echo '<h1>' .round($weatherbody['consolidated_weather'][1]['the_temp'],0) .' &#8451;' .'</h1>';
	
	echo '</center>';
	
	echo '<h5>';

	if (round($weatherbody['consolidated_weather'][1]['max_temp'],0) >= 14)
		{
		echo '<div class="bgbright">';
		}
	elseif (round($weatherbody['consolidated_weather'][1]['max_temp'],0) < 14 and round($weatherbody['consolidated_weather'][1]['max_temp'],0) >= 7)
		{
		echo '<div class="bgmiddle">';
		}
	elseif (round($weatherbody['consolidated_weather'][1]['max_temp'],0) < 7)
		{
		echo '<div class="bgdark">';
		}
	else
		{
		echo '<div>';
		}
    echo '' .round($weatherbody['consolidated_weather'][1]['max_temp'],0) .' &#8451;' ."<br>";
	echo '</div>';
	if (round($weatherbody['consolidated_weather'][1]['min_temp'],0) >= 14)
		{
		echo '<div class="bgbright">';
		}
	elseif (round($weatherbody['consolidated_weather'][1]['min_temp'],0) < 14 and round($weatherbody['consolidated_weather'][1]['min_temp'],0) >= 7)
		{
		echo '<div class="bgmiddle">';
		}
	elseif (round($weatherbody['consolidated_weather'][1]['min_temp'],0) < 7)
		{
		echo '<div class="bgdark">';
		}
	else
		{
		echo '<div>';
		}
    echo '' .round($weatherbody['consolidated_weather'][1]['min_temp'],0) .' &#8451;' ."<br>";
	echo '</div>';
/*  echo '' .$weatherbody['consolidated_weather'][1]['weather_state_name'] ."<br>"; */
    echo 'Wind Direction: ' .$weatherbody['consolidated_weather'][1]['wind_direction_compass'] ."<br>";
    echo 'Wind Speed: ' .round($wind_speedkmh1,1) . ' km/h' ."<br>";
/*  echo 'Wind Direction: ' .round($weatherbody['consolidated_weather'][1]['wind_direction'],1) .' degrees' ."<br>"; */
/*  echo 'Air Pressure: ' .round($weatherbody['consolidated_weather'][1]['air_pressure'],0) .' mbar' ."<br>"; */
    echo 'Humidity: ' .$weatherbody['consolidated_weather'][1]['humidity'] .'%' ."<br>";
    echo 'Visibility: ' .round($visibilitykm1,1) .' km' ."<br>";
/*  echo 'Predictability: ' .$weatherbody['consolidated_weather'][1]['predictability'] .'%'; */

    echo '</h5>';
    echo '</td>';
	
    echo '<td valign="top">';
	echo '<center>';
		
	echo '<p><b>' .$dat2 .' (' .$dat2tag .')</b></p>';
	
    echo '<span class="weatherpic">';

	If($weatherbody['consolidated_weather'][2]['weather_state_abbr'] == 'hr')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/hr.png">';
		}
	elseif($weatherbody['consolidated_weather'][2]['weather_state_abbr'] == 'sn')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/sn.png">';
		}
	elseif($weatherbody['consolidated_weather'][2]['weather_state_abbr'] == 'sl')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/sl.png">';
		}
	elseif($weatherbody['consolidated_weather'][2]['weather_state_abbr'] == 'h')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/h.png">';
		}
	elseif($weatherbody['consolidated_weather'][2]['weather_state_abbr'] == 't')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/t.png">';
		}
	elseif($weatherbody['consolidated_weather'][2]['weather_state_abbr'] == 'lr')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/lr.png">';
		}
	elseif($weatherbody['consolidated_weather'][2]['weather_state_abbr'] == 's')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/s.png">';
		}
	elseif($weatherbody['consolidated_weather'][2]['weather_state_abbr'] == 'hc')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/hc.png">';
		}
	elseif($weatherbody['consolidated_weather'][2]['weather_state_abbr'] == 'lc')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/lc.png">';
		}
	elseif($weatherbody['consolidated_weather'][2]['weather_state_abbr'] == 'c')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/c.png">';
		}
    else
        {
        echo "";
        }
	
	echo '</span>';
	
	$visibilitykm2 = intval($weatherbody['consolidated_weather'][2]['visibility'])*1.609344;
	$wind_speedkmh2 = intval($weatherbody['consolidated_weather'][2]['wind_speed'])*1.609344;
	
	echo '<h1>' .round($weatherbody['consolidated_weather'][2]['the_temp'],0) .' &#8451;' .'</h1>';

	echo '</center>';	

	echo '<h5>';
	
	if (round($weatherbody['consolidated_weather'][2]['max_temp'],0) >= 14)
		{
		echo '<div class="bgbright">';
		}
	elseif (round($weatherbody['consolidated_weather'][2]['max_temp'],0) < 14 and round($weatherbody['consolidated_weather'][2]['max_temp'],0) >= 7)
		{
		echo '<div class="bgmiddle">';
		}
	elseif (round($weatherbody['consolidated_weather'][2]['max_temp'],0) < 7)
		{
		echo '<div class="bgdark">';
		}
	else
		{
		echo '<div>';
		}
    echo '' .round($weatherbody['consolidated_weather'][2]['max_temp'],0) .' &#8451;' ."<br>";
	echo '</div>';
	if (round($weatherbody['consolidated_weather'][2]['min_temp'],0) >= 14)
		{
		echo '<div class="bgbright">';
		}
	elseif (round($weatherbody['consolidated_weather'][2]['min_temp'],0) < 14 and round($weatherbody['consolidated_weather'][2]['min_temp'],0) >= 7)
		{
		echo '<div class="bgmiddle">';
		}
	elseif (round($weatherbody['consolidated_weather'][2]['min_temp'],0) < 7)
		{
		echo '<div class="bgdark">';
		}
	else
		{
		echo '<div>';
		}
    echo '' .round($weatherbody['consolidated_weather'][2]['min_temp'],0) .' &#8451;' ."<br>";
	echo '</div>';
/*  echo '' .$weatherbody['consolidated_weather'][2]['weather_state_name'] ."<br>"; */
    echo 'Wind Direction: ' .$weatherbody['consolidated_weather'][2]['wind_direction_compass'] ."<br>";
    echo 'Wind Speed: ' .round($wind_speedkmh2,1) . ' km/h' ."<br>";
/*  echo 'Wind Direction: ' .round($weatherbody['consolidated_weather'][2]['wind_direction'],1) .' degrees' ."<br>"; */
/*  echo 'Air Pressure: ' .round($weatherbody['consolidated_weather'][2]['air_pressure'],0) .' mbar' ."<br>"; */
    echo 'Humidity: ' .$weatherbody['consolidated_weather'][2]['humidity'] .'%' ."<br>";
    echo 'Visibility: ' .round($visibilitykm2,1) .' km' ."<br>";
/*  echo 'Predictability: ' .$weatherbody['consolidated_weather'][2]['predictability'] .'%'; */

    echo '</h5>';
    echo '</td>';
    echo '</tr> </table>';

    echo '<table width="100%" > <tr> <td valign="top">';
	echo '<center>';
	
	echo '<p><b>' .$dat3 .' (' .$dat3tag .')</b></p>';

    echo '<span class="weatherpic">';

	If($weatherbody['consolidated_weather'][3]['weather_state_abbr'] == 'hr')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/hr.png">';
		}
	elseif($weatherbody['consolidated_weather'][3]['weather_state_abbr'] == 'sn')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/sn.png">';
		}
	elseif($weatherbody['consolidated_weather'][3]['weather_state_abbr'] == 'sl')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/sl.png">';
		}
	elseif($weatherbody['consolidated_weather'][3]['weather_state_abbr'] == 'h')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/h.png">';
		}
	elseif($weatherbody['consolidated_weather'][3]['weather_state_abbr'] == 't')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/t.png">';
		}
	elseif($weatherbody['consolidated_weather'][3]['weather_state_abbr'] == 'lr')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/lr.png">';
		}
	elseif($weatherbody['consolidated_weather'][3]['weather_state_abbr'] == 's')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/s.png">';
		}
	elseif($weatherbody['consolidated_weather'][3]['weather_state_abbr'] == 'hc')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/hc.png">';
		}
	elseif($weatherbody['consolidated_weather'][3]['weather_state_abbr'] == 'lc')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/lc.png">';
		}
	elseif($weatherbody['consolidated_weather'][3]['weather_state_abbr'] == 'c')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/c.png">';
		}
    else
        {
        echo "";
        }
	
	echo '</span>';
	
	$visibilitykm3 = intval($weatherbody['consolidated_weather'][3]['visibility'])*1.609344;
	$wind_speedkmh3 = intval($weatherbody['consolidated_weather'][3]['wind_speed'])*1.609344;
	
	echo '<h1>' .round($weatherbody['consolidated_weather'][3]['the_temp'],0) .' &#8451;' .'</h1>';
	
	echo '</center>';
	
	echo '<h5>';
	
	if (round($weatherbody['consolidated_weather'][3]['max_temp'],0) >= 14)
		{
		echo '<div class="bgbright">';
		}
	elseif (round($weatherbody['consolidated_weather'][3]['max_temp'],0) < 14 and round($weatherbody['consolidated_weather'][3]['max_temp'],0) >= 7)
		{
		echo '<div class="bgmiddle">';
		}
	elseif (round($weatherbody['consolidated_weather'][3]['max_temp'],0) < 7)
		{
		echo '<div class="bgdark">';
		}
	else
		{
		echo '<div>';
		}
    echo '' .round($weatherbody['consolidated_weather'][3]['max_temp'],0) .' &#8451;' ."<br>";
	echo '</div>';
	if (round($weatherbody['consolidated_weather'][3]['min_temp'],0) >= 14)
		{
		echo '<div class="bgbright">';
		}
	elseif (round($weatherbody['consolidated_weather'][3]['min_temp'],0) < 14 and round($weatherbody['consolidated_weather'][3]['min_temp'],0) >= 7)
		{
		echo '<div class="bgmiddle">';
		}
	elseif (round($weatherbody['consolidated_weather'][3]['min_temp'],0) < 7)
		{
		echo '<div class="bgdark">';
		}
	else
		{
		echo '<div>';
		}
    echo '' .round($weatherbody['consolidated_weather'][3]['min_temp'],0) .' &#8451;' ."<br>";
	echo '</div>';
/*  echo '' .$weatherbody['consolidated_weather'][3]['weather_state_name'] ."<br>"; */
    echo 'Wind Direction: ' .$weatherbody['consolidated_weather'][3]['wind_direction_compass'] ."<br>";
    echo 'Wind Speed: ' .round($wind_speedkmh3,1) . ' km/h' ."<br>";
/*  echo 'Wind Direction: ' .round($weatherbody['consolidated_weather'][3]['wind_direction'],1) .' degrees' ."<br>"; */
/*  echo 'Air Pressure: ' .round($weatherbody['consolidated_weather'][3]['air_pressure'],0) .' mbar' ."<br>"; */
    echo 'Humidity: ' .$weatherbody['consolidated_weather'][3]['humidity'] .'%' ."<br>";
    echo 'Visibility: ' .round($visibilitykm3,1) .' km' ."<br>";
/*  echo 'Predictability: ' .$weatherbody['consolidated_weather'][3]['predictability'] .'%'; */
	
    echo '</h5>';
    echo '</td>';
	
    echo '<td valign="top">';
	echo '<center>';
	
	echo '<p><b>' .$dat4 .' (' .$dat4tag .')</b></p>';

    echo '<span class="weatherpic">';

	If($weatherbody['consolidated_weather'][4]['weather_state_abbr'] == 'hr')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/hr.png">';
		}
	elseif($weatherbody['consolidated_weather'][4]['weather_state_abbr'] == 'sn')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/sn.png">';
		}
	elseif($weatherbody['consolidated_weather'][4]['weather_state_abbr'] == 'sl')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/sl.png">';
		}
	elseif($weatherbody['consolidated_weather'][4]['weather_state_abbr'] == 'h')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/h.png">';
		}
	elseif($weatherbody['consolidated_weather'][4]['weather_state_abbr'] == 't')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/t.png">';
		}
	elseif($weatherbody['consolidated_weather'][4]['weather_state_abbr'] == 'lr')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/lr.png">';
		}
	elseif($weatherbody['consolidated_weather'][4]['weather_state_abbr'] == 's')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/s.png">';
		}
	elseif($weatherbody['consolidated_weather'][4]['weather_state_abbr'] == 'hc')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/hc.png">';
		}
	elseif($weatherbody['consolidated_weather'][4]['weather_state_abbr'] == 'lc')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/lc.png">';
		}
	elseif($weatherbody['consolidated_weather'][4]['weather_state_abbr'] == 'c')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/c.png">';
		}
    else
        {
        echo "";
        }

    echo '</span>';
	
	$visibilitykm4 = intval($weatherbody['consolidated_weather'][4]['visibility'])*1.609344;
	$wind_speedkmh4 = intval($weatherbody['consolidated_weather'][4]['wind_speed'])*1.609344;
	
	echo '<h1>' .round($weatherbody['consolidated_weather'][4]['the_temp'],0) .' &#8451;' .'</h1>';
	
	echo '</center>';
	
    echo '<h5>';
	
	if (round($weatherbody['consolidated_weather'][4]['max_temp'],0) >= 14)
		{
		echo '<div class="bgbright">';
		}
	elseif (round($weatherbody['consolidated_weather'][4]['max_temp'],0) < 14 and round($weatherbody['consolidated_weather'][4]['max_temp'],0) >= 7)
		{
		echo '<div class="bgmiddle">';
		}
	elseif (round($weatherbody['consolidated_weather'][4]['max_temp'],0) < 7)
		{
		echo '<div class="bgdark">';
		}
	else
		{
		echo '<div>';
		}
    echo '' .round($weatherbody['consolidated_weather'][4]['max_temp'],0) .' &#8451;' ."<br>";
	echo '</div>';
	if (round($weatherbody['consolidated_weather'][4]['min_temp'],0) >= 14)
		{
		echo '<div class="bgbright">';
		}
	elseif (round($weatherbody['consolidated_weather'][4]['min_temp'],0) < 14 and round($weatherbody['consolidated_weather'][4]['min_temp'],0) >= 7)
		{
		echo '<div class="bgmiddle">';
		}
	elseif (round($weatherbody['consolidated_weather'][4]['min_temp'],0) < 7)
		{
		echo '<div class="bgdark">';
		}
	else
		{
		echo '<div>';
		}
    echo '' .round($weatherbody['consolidated_weather'][4]['min_temp'],0) .' &#8451;' ."<br>";
	echo '</div>';
/*  echo '' .$weatherbody['consolidated_weather'][4]['weather_state_name'] ."<br>"; */
    echo 'Wind Direction: ' .$weatherbody['consolidated_weather'][4]['wind_direction_compass'] ."<br>";
    echo 'Wind Speed: ' .round($wind_speedkmh4,1) . ' km/h' ."<br>";
/*  echo 'Wind Direction: ' .round($weatherbody['consolidated_weather'][4]['wind_direction'],1) .' degrees' ."<br>"; */
/*  echo 'Air Pressure: ' .round($weatherbody['consolidated_weather'][4]['air_pressure'],0) .' mbar' ."<br>"; */
    echo 'Humidity: ' .$weatherbody['consolidated_weather'][4]['humidity'] .'%' ."<br>";
    echo 'Visibility: ' .round($visibilitykm4,1) .' km' ."<br>";
/*  echo 'Predictability: ' .$weatherbody['consolidated_weather'][4]['predictability'] .'%'; */

    echo '</h5>';
    echo '</td>';
	
    echo '<td valign="top">';
	
	echo '<center>';
	
	echo '<p><b>' .$dat5 .' (' .$dat5tag .')</b></p>';
	
	echo '<span class="weatherpic">';

	If($weatherbody['consolidated_weather'][5]['weather_state_abbr'] == 'hr')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/hr.png">';
		}
	elseif($weatherbody['consolidated_weather'][5]['weather_state_abbr'] == 'sn')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/sn.png">';
		}
	elseif($weatherbody['consolidated_weather'][5]['weather_state_abbr'] == 'sl')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/sl.png">';
		}
	elseif($weatherbody['consolidated_weather'][5]['weather_state_abbr'] == 'h')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/h.png">';
		}
	elseif($weatherbody['consolidated_weather'][5]['weather_state_abbr'] == 't')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/t.png">';
		}
	elseif($weatherbody['consolidated_weather'][5]['weather_state_abbr'] == 'lr')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/lr.png">';
		}
	elseif($weatherbody['consolidated_weather'][5]['weather_state_abbr'] == 's')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/s.png">';
		}
	elseif($weatherbody['consolidated_weather'][5]['weather_state_abbr'] == 'hc')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/hc.png">';
		}
	elseif($weatherbody['consolidated_weather'][5]['weather_state_abbr'] == 'lc')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/lc.png">';
		}
	elseif($weatherbody['consolidated_weather'][5]['weather_state_abbr'] == 'c')
	    {
	    echo '<img src="https://www.metaweather.com/static/img/weather/png/64/c.png">';
		}
    else
        {
        echo "";
        }
	
	echo '</span>';
	
	$visibilitykm5 = intval($weatherbody['consolidated_weather'][5]['visibility'])*1.609344;
	$wind_speedkmh5 = intval($weatherbody['consolidated_weather'][5]['wind_speed'])*1.609344;
	
	echo '<h1>' .round($weatherbody['consolidated_weather'][5]['the_temp'],0) .' &#8451;' .'</h1>';

	echo '</center>';

	echo '<h5>';

	if (round($weatherbody['consolidated_weather'][5]['max_temp'],0) >= 14)
		{
		echo '<div class="bgbright">';
		}
	elseif (round($weatherbody['consolidated_weather'][5]['max_temp'],0) < 14 and round($weatherbody['consolidated_weather'][5]['max_temp'],0) >= 7)
		{
		echo '<div class="bgmiddle">';
		}
	elseif (round($weatherbody['consolidated_weather'][5]['max_temp'],0) < 7)
		{
		echo '<div class="bgdark">';
		}
	else
		{
		echo '<div>';
		}
    echo '' .round($weatherbody['consolidated_weather'][5]['max_temp'],0) .' &#8451;' ."<br>";
	echo '</div>';
	if (round($weatherbody['consolidated_weather'][5]['min_temp'],0) >= 14)
		{
		echo '<div class="bgbright">';
		}
	elseif (round($weatherbody['consolidated_weather'][5]['min_temp'],0) < 14 and round($weatherbody['consolidated_weather'][5]['min_temp'],0) >= 7)
		{
		echo '<div class="bgmiddle">';
		}
	elseif (round($weatherbody['consolidated_weather'][5]['min_temp'],0) < 7)
		{
		echo '<div class="bgdark">';
		}
	else
		{
		echo '<div>';
		}
    echo '' .round($weatherbody['consolidated_weather'][5]['min_temp'],0) .' &#8451;' ."<br>";
	echo '</div>';
/*  echo '' .$weatherbody['consolidated_weather'][5]['weather_state_name'] ."<br>"; */
    echo 'Wind Direction: ' .$weatherbody['consolidated_weather'][5]['wind_direction_compass'] ."<br>";
    echo 'Wind Speed: ' .round($wind_speedkmh5,1) . ' km/h' ."<br>";
/*  echo 'Wind Direction: ' .round($weatherbody['consolidated_weather'][5]['wind_direction'],1) .' degrees' ."<br>"; */
/*  echo 'Air Pressure: ' .round($weatherbody['consolidated_weather'][5]['air_pressure'],0) .' mbar' ."<br>"; */
    echo 'Humidity: ' .$weatherbody['consolidated_weather'][5]['humidity'] .'%' ."<br>";
    echo 'Visibility: ' .round($visibilitykm5,1) .' km' ."<br>";
/*  echo 'Predictability: ' .$weatherbody['consolidated_weather'][5]['predictability'] .'%'; */
  
    echo '<h5>';
	
    echo '</td>';
    echo '</tr> </table>';
}