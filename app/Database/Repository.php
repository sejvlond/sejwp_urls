<?php

namespace sejvlond\wordpress\plugins\urls\database;
/**
 * Description of Repository
 *
 * @author Ondra-Turbo
 */
abstract class Repository implements IRepository {
    
    /**
     *
     * @var Database
     */
    protected $database;
    
    public function __construct ( Database $database ) {
        $this -> database = $database;
    }
    

}
