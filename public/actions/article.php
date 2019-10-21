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

  if ($idReq == 'new_article'){
    $required = ['title', 'dAuthor', 'section', 'pubtime', 'summary', 'content', 'cover'];
    $payload = $inputData['payload'];
    if (!isset($payload)) $response = ['error' => 'missing-general-payload'];
    else if (count(array_intersect(array_keys($payload), $required)) !== count(array_keys($required))) $response = ['error' => 'missing-specific-payload'];
    else {
      $articleData = [
        'title' => $payload['title'],
        'author' => $_SESSION['gs_user']['email'],
        'author_display' => $payload['dAuthor'],
        'section' => $payload['section'],
        'pubtime' => $payload['pubtime'],
        'summary' => $payload['summary'],
        'content' => $payload['content'],
        'cover_image' => $payload['cover']['image'],
        'cover_video' => $payload['cover']['video'],
        'cover_image_caption' => $payload['cover']['image_caption'],
        'cover_video_caption' => $payload['cover']['video_caption'],
      ];
      $response = $Verifier->grant_wrap(
        ['article_access'],
        function($self, $articleData){
          return $self->Adder->article($articleData);
        },
        [$articleData]
      );
    }
  }

  echo json_encode($response);
  exit;

?>
