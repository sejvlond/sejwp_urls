<?php

namespace sejvlond\wordpress\plugins\urls\entity;

/**
 * @author Ondrej Sejvl
 */
class Entity {
    
    public function __get ( $name ) {
        return $this -> $name;
    }
    
}