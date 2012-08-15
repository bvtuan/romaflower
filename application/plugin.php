<?php

abstract class plugin {
    
    protected $registry;
    
    public function __construct($registry) {
        $this->registry= $registry;
    }
    
    abstract  function start();
}
