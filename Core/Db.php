<?php

namespace App\Core;

use PDO;
use PDOException;

class Db extends PDO
{
    // instance unique de la classe
    private static $instance;
    
    // info de connexion
    private const DBHOST ='localhost';
    private const DBUSER = 'root';
    private const DBNAME = 'demo_poo';
    private const DBPASS = '';

    private function __construct()
    {
        // dsn de connexion
        $_dsn = 'mysql:dbname='.self::DBNAME.';host='.self::DBHOST;
        
        // on appelle le constructeur de pdo
        try{
            parent::__construct($_dsn,self::DBUSER, self::DBPASS);
            
            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }

    public static function getInstance():self
    {
        if(self::$instance === null ){
            self::$instance = new self;
        }

        return self::$instance;
    }
} 