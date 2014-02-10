<?php

namespace sejvlond\wordpress\plugins\urls\database;

use sejvlond\wordpress\plugins\urls\entity\Url;
/**
 * Description of UrlRepository
 *
 * @author Ondra-Turbo
 */
class UrlRepository extends Repository implements IRepository {
    
    /**
     * 
     * @return type
     */
    public function findAll ( ) {
        return $this -> database -> get_results ( "SELECT * FROM " . $this -> database -> URLS_TABLE );
    }

    /**
     * 
     * @param type $id
     * @return type
     * @throws \InvalidArgumentException
     */
    public function findById ( $id ) {
        if ( ! ctype_digit ( $id ) )
            throw new \InvalidArgumentException;
        return $this -> database -> get_row ( "SELECT * FROM `" . $this -> database -> URLS_TABLE . "` WHERE `id` = $id" );
    }
    
    /**
     * 
     * @param \sejvlond\wordpress\plugins\urls\entity\url\Url|int $entity
     * @return 
     * @throws \InvalidArgumentException
     */
    public function remove ( $entity ) {
        if ( $entity instanceof Url )
            return $this -> database -> delete ( $this -> database -> URLS_TABLE, array ( 'id' => $entity -> id ) );
        if ( ctype_digit ( $entity ) ) 
            return $this -> database -> delete ( $this -> database -> URLS_TABLE, array ( 'id' => $entity ) );
        throw new \InvalidArgumentException;
    }

    /**
     * 
     * @param \sejvlond\wordpress\plugins\urls\entity\url\Url $entity
     * @return type
     * @throws \InvalidArgumentException
     */
    public function save ( $entity ) {
        if ( ! $entity instanceof Url )
            throw new \InvalidArgumentException;
        
        if ( $entity -> id ) 
            return $this -> database->update( $this -> database -> URLS_TABLE, $this->getEntityData ( $entity ), array ( "id" => $entity -> id ) ); 
        else 
            return $this -> database->insert( $this -> database -> URLS_TABLE, $this->getEntityData ( $entity ) );
    }

    /**
     * Get entity data
     * 
     * @param \sejvlond\wordpress\plugins\urls\entity\url\Url $entity
     * @return array
     */
    protected function getEntityData ( Url $entity ) {
        return array ( 
            "url" => $entity -> url,
        );
    }

}
