<?php

  require_once __DIR__.'/../db/db.php';

  class Setter{
    private $pdo;

    function __construct($pdo){
      $this->pdo = $pdo;
    }

    function user($email, $setCols, $setVals){

    }

    function userRole($email, $roleId){

    }

    function userLastLogin($email){
      $query = 'UPDATE Users SET time_login_last = now() WHERE email = ?';
      $stmt = $this->pdo->prepare($query);
      if ($stmt->execute([$email])){
        return $stmt->rowCount() ? [true, true] : [true, false];
      }
      return [false, 500];
    }
  }

  $Setter = new Setter($pdo);

?>
