<?php

class API {

    public static function get($type){
        return new $type();
    }
}
