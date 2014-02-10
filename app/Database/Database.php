<?php

namespace sejvlond\wordpress\plugins\urls\database;


/**
 * Description of Database
 *
 * @author Ondra-Turbo
 */
class Database {
    
    /**
     *
     * @var Database
     */
    private static $instance;
    
    /**
     *
     * @var \wpdb
     */
    private $wpdb;
    
    /**
     * Table of urls
     * 
     * @var string 
     */
    public $URLS_TABLE;  
    
    
    private function __construct ( \wpdb $wpdb ) {
        $this -> wpdb = $wpdb;
        
        $this -> URLS_TABLE = $wpdb->prefix . "sejwp_urls";
    }
    
    /**
     * 
     * @global \wpdb $wpdb
     * @return Database
     */
    public static function getInstance ( ) {
        if ( ! isset ( self::$instance ) ) {
            global $wpdb;
            self::$instance = new Database ( $wpdb );
        }
        return self::$instance;
    }
    
    /**
     * Call non existing method on wpdb
     * 
     * @param string $name
     * @param array $arguments
     * @return mxied
     */
    public function __call($name, $arguments) {
        return call_user_func_array ( array ( $this -> wpdb, $name ), $arguments );
    }
}
