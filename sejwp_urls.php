<?php
/*
Plugin Name: Register url
Plugin URI: http://www.ondrej-sejvl.cz
Description: 
Version: 1.0
Author: Ondřej Šejvl
Author URI: http://www.ondrej-sejvl.cz
License: GPL2
*/

/*  Copyright 2015 Ondrej Sejvl  (email : info@ondrej-sejvl.cz)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

namespace sejvlond\wordpress\plugins\urls;

/**
 * start sessions
 */
function register_session ( ) {
    error_reporting(0);
    if( ! session_id() ) {
        //session_save_path( dirname ( __FILE__ ) . "/sessions");
        session_start();
    }
}
add_action ( 'init', __NAMESPACE__.'\\register_session' );

// ob
function add_ob_start(){
     ob_start();
 }

 function flush_ob_end(){
     ob_end_flush();
 }

 add_action('init', __NAMESPACE__.'\\add_ob_start');
 add_action('wp_footer', __NAMESPACE__.'\\flush_ob_end');


/**
 * Load all php files from dir recoursively
 * 
 * @param string $path
 */
function loadDir ( $path ) {
    foreach ( scandir( $path ) as $file ) {
        if ( $file == '.' || $file == '..' )
            continue;
        if ( is_dir ( $path.'/'.$file ) ) {
            loadDir ( $path.'/'.$file );
        }
        if ( substr ( $file, -4 ) == '.php' ) {
            include $path.'/'.$file;
        }
    }
}

/**
 * Auto load all files from app folder
 */
function autoLoad ( ) {
    loadDir ( __DIR__ . "/app" );
}

/**
 * APP DIR OF PLUGIN
 */
define ( APP_DIR, __DIR__.'/app' );

/**
 *  TEMPLATE DIR OF PLUGIN
 */
define ( TEMPLATES_DIR, APP_DIR.'/templates' );

/**
 * ABSOLUTE URL OF PLUGIN
 */
define ( PLUGIN_URL, plugins_url( '' , __FILE__ ) );

/**
 * Redirect to homepage of plugin
 */
function redirectHome ( ) {
    wp_redirect( menu_page_url ( 'sejwp_urls_list', false ) );
    exit;
}

// ************************************************************************************

autoLoad();

load_plugin_textdomain('sejwp_urls', false, basename( dirname( __FILE__ ) ) . '/languages' );


register_activation_hook( __FILE__, __NAMESPACE__ . '\\install\\install' );


