<?php

abstract class Animal {
    const HELLO = "test";
    public string $test;
    public function __construct($test)
    {
        $this->test = $test;
    }

    abstract function running();
}