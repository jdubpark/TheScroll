<?php

  require_once __DIR__.'/../db/db.php';

  class Adder{
    private $pdo;

    function __construct($pdo){
      $this->pdo = $pdo;
    }

    private function do_exec($stmt){

    }

    function role($data){
      $params = ['name', 'aa', 'aa_ns', 'ad', 'ad_ns', 'sa', 'sa_ns', 'ra', 'rs', 'sa', 'sa_ns'];
      $bindVals = [];
      foreach ($params as $param){$bindVals[":$param"] = $data[$param];}
      $param = null;
      $query = 'INSERT INTO Roles (
        name,
        article_access, article_access_nonself, article_delete, article_delete_nonself,
        stat_access, stat_access_nonself,
        role_access, role_status,
        setting_access, setting_access_nonself
      ) VALUES (:name, :aa, :aa_ns, :ad, :ad_ns, :sa, :sa_ns, :ra, :rs, :sa, :sa_ns)';
      $stmt = $pdo->prepare($query);
      if ($stmt->exec($bindVals)){
        // success
      } else {
        // error
      }
    }

    function user($data){

    }
  }

  $Adder = new Adder($pdo);

?>
