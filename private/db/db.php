<?php

  require_once '../../vendor/autoload.php';

  use Symfony\Component\Dotenv\Dotenv;

  $dotenv = new Dotenv();
  $dotenv->load(__DIR__.'/../../.env');

  $db_host = $_ENV['DAS_DB_HOST'];
  $db_name = $_ENV['DAS_DB_NAME'];
  $db_user = $_ENV['DAS_DB_USER'];
  $db_pass = $_ENV['DAS_DB_PASS'];
  // $db_host = 'localhost';
  // $db_name = 'TheScroll';
  // $db_user = 'root';
  // $db_pass = ''; // for local dev
  $PDO_dsn = "mysql:host={$db_host};port=3306;dbname={$db_name};charset=utf8";
  // $PDO_dsn = "mysql:host=127.0.0.1;dbname=ACSCheck;charset=utf8";
  $PDO_opt = [
    // throw Exceptions for every error
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
  ];
  $pdo = new PDO($PDO_dsn,$db_user,$db_pass,$PDO_opt);

?>
