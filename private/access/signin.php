<?php

  session_start();

  require_once '../../vendor/autoload.php';
  require_once '../toolkits/checker.php';
  require_once '../toolkits/setter.php';
  require_once '../toolkits/getter.php';

  // if (isset($_SERVER['HTTP_ORIGIN'])) header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
  if (
    $_SERVER['REQUEST_METHOD'] !== 'POST' ||
    !isset($_SERVER['HTTP_X_REQUESTED_WITH']) ||
    $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest'
  ){
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    die(header('Location: http://deerfieldscroll.com'));
  }
  // else {
  //   header('Content-type: application/json', true);
  //   // $endres = new stdClass();
  //   // $endres->{'status'} = 0;
  //   // $endres->{'error'} = 'unexpected_error';
  //   //
  //   // function report(Integer $status, String $text){
  //   //   $endres->{'status'} = $status;
  //   //   if ($status) $endres->{'res'} = $text;
  //   //   else $endres->{'error'} = $text;
  //   // }
  // }

  // Get $id_token via HTTPS POST.

  $inputData = file_get_contents("php://input");

  if (!isset($inputData)){
    echo json_encode(['error' => 'unfound-payload']);
    exit;
  }

  $inputData = json_decode($inputData, true);

  if (!isset($inputData['id_token'])){
    echo json_encode(['error' => 'unfound-id-token']);
    exit;
  }

  $id_token = $inputData['id_token'];

  // verify token (jwt)

  $CLIENT_ID = '434350852164-csop4346dc50mrirrjmpnv8ui0pof4rb.apps.googleusercontent.com';
  $client = new Google_Client(['client_id' => $CLIENT_ID]);  // Specify the CLIENT_ID of the app that accesses the backend
  $payload = $client->verifyIdToken($id_token);
  if ($payload){
    $userid = $payload['sub'];
    $domain = $payload['hd'];
    $email = explode('@', $payload['email'])[0];
    $authRes = $Checker->signin($email);
    if ($authRes[0]){
      // valid sign in
      $Setter->userLastLogin($email);
      $roleId = $authRes[1]['role'];
      $roleData = $Getter->role($roleId);
      $roleName = key($roleData);
      $userData = [
        'email' => $authRes[1]['email'],
        'name' => [
          'first' => $authRes[1]['name_first'],
          'middle' => $authRes[1]['name_middle'],
          'last' => $authRes[1]['name_last'],
          'display' => $authRes[1]['name_display'],
        ],
        'role' => [
          'id' => $roleId,
          'name' => $roleName,
          'job' => $roleData[$roleName],
        ],
        'exp' => strtotime("+2 weeks"), // force session expire in 2 weeks
      ];
      $json = ['result' => 'valid-user', 'payload' => $userData];
      $_SESSION['gs_user'] = $userData;
    } else {
      // 500 or invalid
      if ($authRes[1] === 500) $json = ['error' => 'internal-error'];
      else $json = ['result' => 'invalid-user'];
    }
  } else {
    // Invalid ID token
    $json = ['error' => 'invalid-id-token'];
  }

  echo json_encode($json);
  exit;

?>
