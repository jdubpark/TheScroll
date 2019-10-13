<?php

  require_once '../db/db.php';

  class Setter{
    private $pdo;

    function __construct($pdo){
      $this->pdo = $pdo;
    }

    function user($email, $setCols, $setVals){

    }

    function userRole($email, $roleId){

    }
  }

  $Setter = new Setter($pdo);

?>
