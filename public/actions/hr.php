<?php

  session_start();

  require_once __DIR__.'/../../private/toolkits/verifier.php';
  require_once __DIR__.'/../../private/toolkits/getter.php';

  $reqMethod = $_SERVER['REQUEST_METHOD'];
  if (
    !in_array($reqMethod, ['POST', 'GET']) ||
    !isset($_SERVER['HTTP_X_REQUESTED_WITH']) ||
    $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest'
  ){
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    die(header('Location: http://deerfieldscroll.com'));
  }

  $inputData = $reqMethod == 'POST' ? file_get_contents('php://input') : $_GET;
  if ($reqMethod == 'POST' && !empty($inputData)) $inputData = json_decode($inputData, true);

  if (!isset($inputData) || isset($inputData) && !isset($inputData['req'])){
    echo json_encode(['error' => 'unfound-payload']);
    exit;
  }

  $idReq = $inputData['req'];
  $response = ['error' => 'unknown-payload'];

  if ($idReq == 'data'){
    $response = $Verifier->grant_wrap(
      ['role_access', 'hr_access'],
      function($self){
        $roles = $self->Getter->roles();
        $users = $self->Getter->users();
        return ['roles' => $roles, 'users' => $users];
      }
    );
  } else if ($idReq == 'add_role'){
    if (!isset($inputData['name'], $inputData['jobs'])) $response = ['error' => 'missing-general-payload'];
    else {
      $abbrs = [
        'is_super' => 'iss',
        'article_access' => 'ara',
        'article_access_nonself' => 'ara_ns',
        'article_delete' => 'ard',
        'article_delete_nonself' => 'ard_ns',
        'stat_access' => 'sta',
        'stat_access_nonself' => 'sta_ns',
        'role_access' => 'roa',
        'role_status' => 'ros',
        'hr_access' => 'hra',
        'hr_super' => 'hrs',
        'setting_access' => 'sea',
        'setting_access_nonself' => 'sea_ns',
      ];
      $jobsData = $inputData['jobs'];
      $abbrsKeys = array_keys($abbrs);
      if (count(array_intersect($abbrsKeys, array_keys($jobsData))) !== count($abbrsKeys)){
        $response = ['error' => 'missing-specific-payload'];
      } else {
        $roleData = ['name' => $inputData['name']];
        foreach ($abbrs as $full => $abbr) $roleData[$abbr] = $jobsData[$full];
        $response = $Verifier->grant_wrap(
          ['role_access'],
          function($self, $roleData){
            $status = $self->Adder->role($roleData);
            return $status;
          },
          [$roleData]
        );
      }
    }
  }

  echo json_encode($response);
  exit;

?>
