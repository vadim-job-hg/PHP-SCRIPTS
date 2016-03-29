<?php
//call as php cron.php 'method' <params>
Crons::call($argv);

class Crons
{
    private $_mysqli;

    public static function call($argv)
    {
        $cron = new Crons();
        if (isset($argv[1]) && method_exists($cron, $argv[1]))
            $cron->$argv[1](array_slice($argv, 2));

    }

    protected function db_connect()
    {
        $this->_mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    }

    public function method_name($params_array){
        //action
    }
}