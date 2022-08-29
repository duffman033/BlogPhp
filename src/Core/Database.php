<?php

namespace App\Core;

use \PDO;
use \Dotenv;
use PDOStatement;

class Database
{
    /**
     * @var
     */
    protected $database;

    /**
     * @return PDO
     */
    protected function dbConnect()
    {
        $dotenv = Dotenv\Dotenv::createUnsafeImmutable(realpath(dirname(__FILE__) . '/../../'));
        $dotenv->load();
        if ($this->database === null) {
            return new PDO(
                'mysql:host=' . getenv('MYSQL_HOST') . ';dbname=' . getenv('MYSQL_DB') . ';charset=utf8',
                getenv('MYSQL_USER'),
                getenv('MYSQL_PASSWORD'),
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );
        }
        return $this->database;
    }

    /**
     * @param $sql
     * @param null $parameters
     * @return bool|false|PDOStatement
     */
    protected function sql($sql, $parameters = null)
    {
        if ($parameters) {
            $result = $this->dbConnect()->prepare($sql);

            $result->execute($parameters);

            return $result;
        }
        $result = $this->dbConnect()->query($sql);

        return $result;
    }
}
