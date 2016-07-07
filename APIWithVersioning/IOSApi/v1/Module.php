<?php
namespace Multiple\Library\IOSApi\v1;
class Module
{
    public function get($type){
        $class =  'Multiple\\Library\\IOSApi\\v1\\'.\Phalcon\Text::camelize($type).'Method';
        if(class_exists($class))
            return new $class;
        else
            throw new \ErrorException('Such Method Does Not Exist', 404);
    }
}
