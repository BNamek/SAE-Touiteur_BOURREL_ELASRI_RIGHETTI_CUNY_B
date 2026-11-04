<?php
namespace iutnc\touiteur\Action;

abstract class ActionAbs{
    protected $methode_http;
    protected $nom_hote;

    public function __construct(){
        $this -> methode_http = $_SERVER['REQUEST_METHOD'];
        $this -> nom_hote = $_SERVER['HTTP_HOST'];
    }

    //Une fonction qui éxécutera les actions a réaliser dans les autres classe qui vont extends action et retourner un string
    abstract public function execute() : string;

}
