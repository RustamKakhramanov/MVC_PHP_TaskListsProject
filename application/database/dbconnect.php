<?php
  $host = 'localhost';
  $dbname = 'rustamnw_1';
  $user = 'rustamnw_1';
  $pass = '14uzusan';

   try {
    $dsn = "mysql:host=$host;dbname=$dbname";
    $opt = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    ];
  } catch (PDOException $e) {
    echo $e->getMessage();
  }


?>
