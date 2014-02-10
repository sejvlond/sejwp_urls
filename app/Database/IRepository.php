<?php

namespace sejvlond\wordpress\plugins\urls\database;

/**
 *
 * @author Ondra-Turbo
 */
interface IRepository {
    
    /**
      * Finds all entities 
      * 
      * @return Array of objects
      */
    public function findAll ( );
    
    /**
      * Finds entities by id.
      *
      * @param int $id
      * 
      * @return object
      */
     public function findById( $id );
     
     
     /**
       * Save an entity to DB
       *  
       * @param object 
       * @return bool
       */
     public function save ( $entity );
     
     /**
       * Remove an entity from DB
       *  
       * @param object 
       * @return bool
       */
     public function remove ( $entity );
    
}
