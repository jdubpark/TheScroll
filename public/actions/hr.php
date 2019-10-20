<?php

  session_start();

  require_once __DIR__.'/../../private/toolkits/verifier.php';
  require_once __DIR__.'/../../private/toolkits/getter.php';

  $res = $Verifier->grant_wrap(
    ['role_access', 'hr_access'],
    function($self){
      $roles = $self->Getter->roles();
      $users = $self->Getter->users();
      return ['roles' => $roles, 'users' => $users];
    }
  );

  echo json_encode($res);

?>
