<?php
//base FACTORY method class
class API {

    public static function get($type){
        return new $type();
    }
}


