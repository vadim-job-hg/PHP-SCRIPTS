<?php
namespace Multiple\Library;

class IOSApi
{

    public static function get($type, $version)
    {
        $class = '\\Multiple\Library\\IOSApi\\v'.$version.'\\Module';
        if(class_exists($class))
            return (new $class)->get($type);
        else
            throw new \ErrorException('Such Method Does Not Exist', 404);
    }
}


