<?php
/*
Plugin Name: Headache Killer
Author URI: http://vijohn.nobodycanfindme.com
Description: Let's kill Internet Explorer once and for all.
Version: 1.0
Author: John Boucha
License: GPL2
 
IE Killer is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version. If you paid for this software, well... that's
weird.
 
IE Killer is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
*/


// Block direct requests
if ( !defined('ABSPATH') ) {
	die('-1');
}


/*
*
*	Check user's browser
* 
*/
add_action('init', iekiller_browser_check);

function ieKiller_browser_check() {
    iekiller_check_this_browser(sanitize_text_field($_SERVER['HTTP_USER_AGENT']));
}

function iekiller_check_this_browser($user_agent) {
	
	// order is important
    if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) return;
    elseif (strpos($user_agent, 'Edge')) return;
    elseif (strpos($user_agent, 'Chrome')) return;
    elseif (strpos($user_agent, 'Safari')) return; //iekiller_kill_browser();
    elseif (strpos($user_agent, 'Firefox')) return;
    elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) iekiller_kill_browser();
    
    return;
}


/*
*
*	Redirect user to blue screen of death
* 
*/
function iekiller_kill_browser() {
	header("Location: /browser-fail.html");
	die();
}


/*
*
*	Update rewrite rules for redirect page on activation
* 
*/
add_action( 'init', 'iekiller_create_bluescreen' );
function iekiller_create_bluescreen() {
    global $wp_rewrite;
    $plugin_url = plugins_url( 'browser-fail.html', __FILE__ );
    $plugin_url = substr( $plugin_url, strlen( home_url() ) + 1 );
    $wp_rewrite->add_external_rule( 'browser-fail.html', $plugin_url );
}
