<?php

namespace sejvlond\wordpress\plugins\urls\install;

use sejvlond\wordpress\plugins\urls\database\Database;

function install ( ) {
    
    require_once ( ABSPATH . 'wp-admin/includes/upgrade.php' );

    $sql = "
        CREATE TABLE `". Database::getInstance()->URLS_TABLE ."` (
            `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `url` varchar(200) NOT NULL
        ) COMMENT=''; 
        
    ";

    dbDelta ( $sql );
    
    Database::getInstance()->query ( "
        ALTER TABLE `". Database::getInstance()->URLS_TABLE ."` ADD UNIQUE (
        `url`
        );
    " );
}