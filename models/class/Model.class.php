<?php

abstract class Model{
    private static $pdo;

    private static function setBdd(){
        self::$pdo = new Pdo("mysql:host=localhost:8889;dbname=blogphp;charset=utf8",'root','root');
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }

    protected function getBdd(){
        if(self::$pdo === null){
         self::setBdd();
        }
        return self::$pdo;
    }
}
