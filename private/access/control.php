<?php

	if (session_status() == PHP_SESSION_NONE) session_start();

	if (!isset($_SESSION['g_user_data'])){
		// $home = __DIR__.'/../../public/index.php';
		$home = './index.php';
    header("Location: $home");
    exit;
  }

?>
