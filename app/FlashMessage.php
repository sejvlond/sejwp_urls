<?php

namespace sejvlond\wordpress\plugins\urls;


/**
 * 
 *
 * @author Ondra-Turbo
 */
class FlashMessage {
    
    /**
     *
     * @var FlashMessage
     */
    private static $instance;
    
    /**
     * Messages in session
     * 
     * @var array 
     */
    private $messages;
    
    /**
     * 
     * @param type $session
     */
    private function __construct ( &$session ) {
        $this -> messages = &$session;
    }
    
    /**
     * 
     * @return FlashMessage
     */
    public static function getInstance ( ) {
        if ( ! isset ( self::$instance ) ) {
            if ( !is_array( $_SESSION [ 'sejwp_urls_flashmessages' ] ) )
                $_SESSION [ 'sejwp_urls_flashmessages' ] = array();
            self::$instance = new FlashMessage ( $_SESSION [ 'sejwp_urls_flashmessages' ] );
        }
        return self::$instance;
    }
    
    /**
     * 
     * @param string $message
     * @param string|int|NULL $id
     * @return \sejvlond\wordpress\plugins\urls\FlashMessage
     */
    public function add ( $message, $id = NULL ) {
        if ( $id )
            $this -> messages [ $id ] = __ ( $message );
        else 
            $this -> messages [ ] = __ ( $message );
        return $this;
    }
    
    /**
     * 
     * @param int|NULL $id
     * @return string|array
     */
    public function getAll ( $id = NULL, $delete = true ) {
        if ( $id )
            return $this -> messages [ $id ];
        return $this -> messages;
    }
    
    /**
     * 
     * @param type $id
     */
    public function delete ( $id = NULL ) {
        if ( $id )
            unset ( $this -> messages [ $id ] );
        else 
            $this -> messages = array ();
    }
    
}
