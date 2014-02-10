<?php

namespace sejvlond\wordpress\plugins\urls\admin;

use sejvlond\wordpress\plugins\urls;
use sejvlond\wordpress\plugins\urls\templates\admin\ListUrls;
use sejvlond\wordpress\plugins\urls\templates\admin\AddNewUrl;
use sejvlond\wordpress\plugins\urls\templates\admin\EditUrl;
use sejvlond\wordpress\plugins\urls\templates\admin\Settings;
use sejvlond\wordpress\plugins\urls\entity\Url;
use sejvlond\wordpress\plugins\urls\database\Database;
use sejvlond\wordpress\plugins\urls\database\UrlRepository;
use sejvlond\wordpress\plugins\urls\FlashMessage;

// init
add_action( 'admin_init', __NAMESPACE__.'\\init' );

function init ( ) {
    add_option('sejwp_urls_secret_page');
}

// Admin menu
add_action ( 'admin_menu', __NAMESPACE__.'\\menu');

/**
 * Create admin menu
 */
function menu () {
    add_menu_page( __ ( 'Registered urls', 'sejwp_urls' ), __ ( 'Registered urls', 'sejwp_urls' ), 'manage_options', 'sejwp_urls_list', __NAMESPACE__.'\\listUrls' ); 
        add_submenu_page( 'sejwp_urls_list', __ ( 'Add new', 'sejwp_urls' ), __ ( 'Add new', 'sejwp_urls' ), 'manage_options', 'sejwp_urls_new', __NAMESPACE__.'\\addNewUrl');          
        add_submenu_page( 'sejwp_urls_list', __ ( 'Settings', 'sejwp_urls' ), __ ( 'Settings', 'sejwp_urls' ), 'manage_options', 'sejwp_urls_settings', __NAMESPACE__.'\\settings');  
        
        add_submenu_page( NULL, __ ( 'Edit url', 'sejwp_urls' ), __ ( 'Edit url', 'sejwp_urls' ), 'manage_options', 'sejwp_urls_edit', __NAMESPACE__.'\\editUrl');  
        add_submenu_page( NULL, __ ( 'Delete url', 'sejwp_urls' ), __ ( 'Delete url', 'sejwp_urls' ), 'manage_options', 'sejwp_urls_delete', __NAMESPACE__.'\\deleteUrl');  
}

/**
 * List registered urls
 */
function listUrls () {
    $repos = new UrlRepository( Database::getInstance() );
    $urls = array ();
    foreach ( $repos ->findAll() as $url ) {
        $newUrl = new Url ( $url -> id );
        $newUrl -> setUrl ( $url -> url );
        $urls [] = $newUrl;
    }
    ListUrls::render ( array ( "urls" => $urls ) );
}

/**
 * Add new url
 */
function addNewUrl () {
    if ( $_POST ) {
        $url = new Url ( );
        $url -> setUrl( $_POST ['url'] );
        
        $repos = new UrlRepository( Database::getInstance() );
        if ( $repos ->save( $url ) !== false ) {
            FlashMessage::getInstance()->add( "Url was sucesfully saved" );
            urls\redirectHome();
        } else {
            FlashMessage::getInstance()->add( "Url could not be saved, try again" );
            AddNewUrl::render();
        }
        
    }
    else {
        AddNewUrl::render();
    }
}

/**
 * Edit url
 */
function editUrl ( ) {
    $id = $_GET [ 'id' ];
    if ( ! ctype_digit ( $id ) )
        throw new \InvalidArgumentException;
    
    $repos = new UrlRepository( Database::getInstance() );
    
    if ( $_POST ) {
        $url = new Url ( $id );
        $url -> setUrl( $_POST ['url'] );
        
        if ( $repos ->save( $url ) !== false ) {
            FlashMessage::getInstance()->add( "Url was sucesfully saved" );
            return urls\redirectHome();
        } 
        
        FlashMessage::getInstance()->add( "Url could not be saved, try again" );        
    }
    
    $entity = $repos ->findById ( $id );
    if ( ! $entity )
        throw new \InvalidArgumentException;
    
    EditUrl::render( array ( "entity" => $entity  ) );
    
}

/**
 * Delete url
 */
function deleteUrl ( ) {
    $id = $_GET [ 'id' ];
    if ( ! ctype_digit ( $id ) )
        throw new \InvalidArgumentException;
    $repos = new UrlRepository( Database::getInstance() );
    if ( $repos ->remove( $id ) !== false ) {
        FlashMessage::getInstance()->add( "Url was sucesfully deleted" );
    } else {
        FlashMessage::getInstance()->add( "Url could not be deleted, try again" );
    }
    urls\redirectHome();
}

/**
 * Settings
 */
function settings ( ) {
    if ( $_POST ) {
        update_option( 'sejwp_urls_secret_page', $_POST['page']);
        FlashMessage::getInstance()->add( "Settings save succesfully" );
    }
    
    $args = array(
            'sort_order' => 'ASC',
            'sort_column' => 'post_title',
            'hierarchical' => 1,
            'post_type' => 'page',
    ); 
    $pages = get_pages($args); 

    Settings::render( 
            array ( 
                    'pages' => $pages,
                    'selected' => get_option('sejwp_urls_secret_page'),
            )
    );
}
