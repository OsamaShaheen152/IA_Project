<?php

namespace App;

use mysqli;

class DB
{
  private string $hostname = "localhost";
  private string $username = "root";
  private string $password = "";
  private string $database = "datebase_section";

  public mysqli $Connection;

  public function __construct()
  {
    $this->Connection =  new mysqli($this->hostname, $this->username, $this->password, $this->database);
  }
}
