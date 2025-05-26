<?php

class Conexao {
    private static $instance;

    public static function getConn(){
        if(!isset(self::$instance)){
            self::$instance = new \PDO ('mysql:host=localhost;dbname=cashhive_system','root','');
        }
        return self::$instance;
    }
}