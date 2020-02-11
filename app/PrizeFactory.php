<?php
/**
 * Created by PhpStorm.
 * User: Vit
 * Date: 05.07.2019
 * Time: 22:39
 */

namespace App;


class PrizeFactory
{
    function __construct($namespace = 'App')
    {
        $this->namespace = $namespace;
    }

    public function make($source)
    {
        $name = $this->namespace . '\\Prize' . ucfirst($source);

        if(class_exists($name)) {
            return new $name();
        }
    }
}