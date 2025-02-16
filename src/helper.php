<?php

require_once "Filters/filters.php";

if(!function_exists('cool')){

    function cool() : \CoolView\CoolEngine{
        return new \CoolView\CoolEngine(
            getcwd() . \Configuration\Config::get('cool-view.ViewPath'),
            getcwd() . \Configuration\Config::get('cool-view.CachePath')
        );
    }

}