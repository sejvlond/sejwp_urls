<?php

namespace sejvlond\wordpress\plugins\urls\front;

use sejvlond\wordpress\plugins\urls;
use sejvlond\wordpress\plugins\urls\FlashMessage;
use sejvlond\wordpress\plugins\urls\entity\Url;
use sejvlond\wordpress\plugins\urls\database\Database;
use sejvlond\wordpress\plugins\urls\database\UrlRepository;


add_filter('the_content', __NAMESPACE__ . '\\shortcode');

/**
 * Change page text with shortcode
 * 
 * @param type $content
 * @return type
 */
function shortcode ( $content ) {
    if ( preg_match('/\[register_url\]/', $content ) ) {
        $output = generate_form ( );
        $content = preg_replace('/\[register_url\]/',$output,$content);
    }
    return $content;
}


/**
 * Generate form to register url
 * 
 * @return string
 */
function generate_form ( ) {
    $time = time();
    $uid = uniqid();
    $_SESSION['sejwp_register_form_code'] [ $time ] = $uid;
    $flashMessages = "";
    
    foreach ( FlashMessage::getInstance()->getAll() as $msg ) {
        $flashMessages .= "<div id=\"message\" class=\"updated below-h2\">".$msg."</div>";
    }
    FlashMessage::getInstance()->delete();
    
    return $flashMessages . "
        <form method='post' action=''>
            <input type='hidden' name='time' value='$time'>
            <input type='hidden' name='uid' value='$uid'>
            <input name='url' type='url' placeholder='".__("Put your url")."'>
            <input type='submit' name='sejwp_register_url' class='btn btn-primary button-primary' value='".__("Register")."'>
        </form>
    ";
}



add_action( 'get_header', __NAMESPACE__.'\\processForm' );

/**
 * Process registered form
 */
function processForm ( ) {

    if ( $_POST [ 'sejwp_register_url' ] ) {

        if ( $_SESSION [ 'sejwp_register_form_code' ] [ $_POST ['time' ] ] != $_POST [ 'uid' ]  ) {
            unset ( $_SESSION [ 'sejwp_register_form_code' ] [ $_POST ['time' ] ] );
            FlashMessage::getInstance()->add( "Invalid token! Try again" );
            wp_redirect( get_permalink() );
            exit;
        }

        unset ( $_SESSION [ 'sejwp_register_form_code' ] [ $_POST ['time' ] ] );
        
        $url = new Url ( );
        $url -> setUrl( $_POST ['url'] );

        $repos = new UrlRepository( Database::getInstance() );
        if ( $repos ->save( $url ) !== false ) {
            $_SESSION [ 'sejwp_hidden_page_allow' ] = true;
            wp_redirect( get_permalink ( get_option('sejwp_urls_secret_page') ) );
            exit;
        } else {
            FlashMessage::getInstance()->add( "Url could not be saved! Try again" );
            wp_redirect( get_permalink() );
            exit;
        }

    }

}

add_action( 'get_header', __NAMESPACE__.'\\checkHiddenPage' );

function checkHiddenPage ( ) {
    if ( is_page ( get_option('sejwp_urls_secret_page') ) ) {    
        if ( ! $_SESSION [ 'sejwp_hidden_page_allow' ] ) {
            wp_redirect (  home_url() );
            exit;
        }
    }
}

add_action( 'pre_get_posts', __NAMESPACE__.'\\checkHiddenPageQuery' );

function checkHiddenPageQuery ( & $query ) {
    if ( ! $_SESSION [ 'sejwp_hidden_page_allow' ] ) {
        $query->set('post__not_in', array ( get_option('sejwp_urls_secret_page') ) );    
    }
}