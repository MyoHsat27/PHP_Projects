<?php

class Bird extends Animal {
    public function __construct($test){
        parent::__construct($test);
    }
    public function running() : void {
        echo "Bird is run";
    }
}
