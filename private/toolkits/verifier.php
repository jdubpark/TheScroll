<?php

  class Verifier{
    function wrap(onGrantedFn){
      // if role is granted
      onGrantedFn();
      // else
      // return unauthorized payload
    }
  }

?>
