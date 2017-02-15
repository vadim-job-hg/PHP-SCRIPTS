<?php
namespace App\Library;
class Logger {
    static protected $_logStatus = false;
    static protected $_fileName = '';
    static public function setLogDataStatus($status = false){self::$_logStatus = $status;}
    static public function setFileName($fileName){if(is_string($fileName)) self::$_fileName = $fileName;}
    static public function log($string){
        if(self::$_logStatus&&self::$_fileName!=''&&is_string($string))
            @file_put_contents(APP_PATH . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . self::$_fileName, $string, FILE_APPEND);
    }
    private final function __construct() {}
    private final function __clone() {}
    public final function import() {}
    public final function get() {}
}