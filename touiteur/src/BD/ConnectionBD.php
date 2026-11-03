<?php

namespace iutnc\touiteur\BD;

//Cette classe vas permettre la connexion a la base de donnés
class ConnectionBD{
    private \PDO $pdo;
    private static ?ConnectionBD $instance = null;
    private static array $config = [];

    private function __construct(array $conf) {
    $this->pdo = new \PDO($conf['dsn'], $conf['user'], $conf['pass'],
    [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
    }

     public static function getInstance(){
     if (is_null(self::$instance)) {
     self::$instance = new ConnectionBD(self::$config);
     }
     return self::$instance;
     }

     public static function setConfig(string $file) {
     $conf = parse_ini_file($file);
     if ($conf === false) {
     throw new \Exception("Error reading configuration file");
     }

     self::$config = [ 'dsn'=> "$conf[driver]:host=$conf[host];dbname=$conf[database]",
         'user'=> $conf['username'],'pass'=> $conf['password'] ];
     }

     public function __get(string $name){
         if($name === "pdo"){
             return $this -> pdo;
         }else{
             $res = "Attributs inconnue";
             return $res;
         }
     }

}
