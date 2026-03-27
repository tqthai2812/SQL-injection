<?php

namespace App\Models;

use PDO;

class PDOFactory
{
  public function create(array $config): PDO
  {
    [
      'dbhost' => $dbhost,
      'dbname' => $dbname,
      'dbuser' => $dbuser,
      'dbpass' => $dbpass
    ] = $config;

    $dsn = "mysql:host={$dbhost};dbname={$dbname};charset=utf8mb4";
    return new PDO($dsn, $dbuser, $dbpass);
  }
}
