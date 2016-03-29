<?php
//cron for wordpress //call as php wp-cron.php 'method' <params>
if ( !defined('ABSPATH') ) {
    /** Set up WordPress environment */
    require_once( dirname( __FILE__ ) . '/wp-load.php' );
}
Crons::call($argv);

class Crons
{
    public static function call($argv)
    {
        $cron = new Crons();
        if (isset($argv[1]) && method_exists($cron, $argv[1]))
            $cron->$argv[1](array_slice($argv, 2));

    }

    public function method_name($params_array){
        //action
    }
}