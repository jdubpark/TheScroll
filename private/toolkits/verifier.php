<?php

  if (session_status() == PHP_SESSION_NONE) session_start();

  // require these to enable using them inside param function
  require_once __DIR__.'/adder.php';
  require_once __DIR__.'/checker.php';
  require_once __DIR__.'/setter.php';
  require_once __DIR__.'/getter.php';

  class Verifier{
    public $Adder, $Checker, $Setter, $Getter;

    function __construct($Adder, $Checker, $Setter, $Getter){
      $this->Adder = $Adder;
      $this->Checker = $Checker;
      $this->Setter = $Setter;
      $this->Getter = $Getter;
    }

    function get_user_job(){
      $job = ['valid', []];
      if (!isset($_SESSION['gs_user']) || empty($_SESSION['gs_user']['role'])) $job[0] = 'invalid';
      else $job[1] = $_SESSION['gs_user']['role']['job'];
      return $job;
    }

    function grant_wrap($reqJobs, $onGrantedFn, $passedVars=[]){
      $isGranted = false;
      $payload = [
        // 'granted' => false,
        'status' => 'unauthorized',
      ];

      $userJob = $this->get_user_job();
      if (!is_array($reqJobs)) $reqJobs = [$reqJobs];

      if ($userJob[0] == 'invalid') return $payload;
      else $userJob = $userJob[1];

      // only if all req job intersect with user jobs
      if (count(array_intersect($reqJobs, $userJob)) == count($reqJobs)) $isGranted = true;
      else {
        $missingJobs = array_diff($reqJobs, $userJob);
        $payload['missing'] = [];
        foreach ($missingJobs as $job) $payload['missing'][] = $job;
      }

      if ($isGranted){
        // $payload['granted'] = true;
        $payload['status'] = 'authorized';
        $payload['payload'] = $onGrantedFn($this, ...$passedVars);
      }

      return $payload;
    }
  }

  $Verifier = new Verifier($Adder, $Checker, $Setter, $Getter);

?>
