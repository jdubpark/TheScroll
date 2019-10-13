<?php

  session_start();

  require_once '../../vendor/autoload.php';
  require_once '../toolkits/checker.php';

  // if (isset($_SERVER['HTTP_ORIGIN'])) header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
  // if (
  //   $_SERVER["REQUEST_METHOD"] !== "POST" ||
  //   !isset($_SERVER['HTTP_X_REQUESTED_WITH']) ||
  //   $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest'
  // ){
  //   header('Location: http://deerfieldscroll.com');
  //   exit;
  // } else {
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

  $POST_DATA = file_get_contents("php://input");

  if (!isset($POST_DATA)){
    echo json_encode(['error' => 'unfound-payload']);
    exit;
  }

  $POST_DATA = json_decode($POST_DATA, true);

  if (!isset($POST_DATA['id_token'])){
    echo json_encode(['error' => 'unfound-id-token']);
    exit;
  }

  $id_token = $POST_DATA['id_token'];

  // verify token (jwt)

  $CLIENT_ID = '434350852164-csop4346dc50mrirrjmpnv8ui0pof4rb.apps.googleusercontent.com';
  $client = new Google_Client(['client_id' => $CLIENT_ID]);  // Specify the CLIENT_ID of the app that accesses the backend
  $payload = $client->verifyIdToken($id_token);
  if ($payload){
    $userid = $payload['sub'];
    $domain = $payload['hd'];
    $email = explode('@', $payload['email'])[0];
    $authRes = $Checker::signin($email);
    if ($authRes[0]){
      // valid sign in
      $payload =
      $json = ['result' => 'valid-user', 'payload' => $authRes[1]];
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
