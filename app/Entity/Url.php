<?php

namespace sejvlond\wordpress\plugins\urls\entity;

/**
 * @author Ondrej Sejvl
 */
class Url extends Entity {
    
    /**
     *
     * @var int
     */
    protected $id;
    
    /**
     *
     * @var string
     */
    protected $url;
    
    /**
     * 
     * @param int $id   int when creating existing entity, NULL otherwise
     */
    public function __construct ( $id = NULL ) {
        $this -> id = $id;
    }
    
    /**
     * 
     * @param string $url
     * @return \sejvlond\wordpress\plugins\urls\entity\url\Url
     */
    public function setUrl ( $url ) {
        $this -> url = $url;
        return $this;
    }
    
    
}