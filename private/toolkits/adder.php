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
      $params = ['name', 'iss', 'ara', 'ara_ns', 'ard', 'ard_ns', 'sta', 'sta_ns', 'roa', 'ros', 'hra', 'hrs', 'sea', 'sea_ns'];
      $bindVals = [];
      foreach ($params as $param){$bindVals[":$param"] = $data[$param];}
      $param = null;
      $query = 'INSERT INTO Roles (
        name, is_super,
        article_access, article_access_nonself, article_delete, article_delete_nonself,
        stat_access, stat_access_nonself,
        role_access, role_status,
        hr_access, hr_super,
        setting_access, setting_access_nonself
      ) VALUES (
        :name, :iss,
        :ara, :ara_ns, :ard, :ard_ns,
        :sta, :sta_ns,
        :roa, :ros,
        :hra, :hrs,
        :sea, :sea_ns
      )';
      $stmt = $this->pdo->prepare($query);
      if ($stmt->execute($bindVals)){
        return 'success';
      } else {
        return 'fail';
      }
    }

    function user($data){

    }
  }

  $Adder = new Adder($pdo);

?>
