<?php
namespace API\Models;

use API\Core\Model;

class User extends Model
{
  public $id;
  public $name;

  function __construct()
  {
    $this->setTableName("users");
  }

  public function __toString()
  {
    return (string)$this->name;
  }
}