<?php

	if (session_status() == PHP_SESSION_NONE) session_start();

	if (!isset($_SESSION['gs_user'])){
		// google signin user
		// $home = __DIR__.'/../../public/index.php';
		$home = '../index.php';
    header("Location: $home");
    exit;
  }

?>
