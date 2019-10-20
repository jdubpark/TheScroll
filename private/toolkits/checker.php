<?php

  require_once __DIR__.'/../db/db.php';
  require_once __DIR__.'/getter.php';

  class Checker{
    private $pdo;

    function __construct($pdo){
      $this->pdo = $pdo;
    }

    function signin($email){
      $query = 'SELECT * FROM Users WHERE email = ?';
      $stmt = $this->pdo->prepare($query);
      if ($stmt->execute([$email])){
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return [false, []];
        else return [true, $row];
        exit;
      }
      return [false, 500];
    }
  }

  $Checker = new Checker($pdo);

  // $end = $Checker->signin('test@deerfield.edu');
  // var_export($end);

?>
