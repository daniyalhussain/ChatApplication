<?php

namespace API\Core;

use API\Config\Database;
use API\Models\Chat;
use ReflectionClass;
use PDO;

abstract class Model {
  private $tableName;

  /**
   * @param mixed $tableName
   */
  public function setTableName($tableName)
  {
    $this->tableName = $tableName;
  }

  public function get($id) {
    $database = new Database();

    $stmt = $database->makeConnection()->prepare('SELECT * FROM '.$this->tableName.' WHERE id = ?');
    $stmt->bindParam(PDO::PARAM_INT, $id);
    $stmt->execute();

    $result = $stmt->fetch();

    return $this->buildObject($result);
  }

  public function getAll()
  {
    $database = new Database();
    $query = $database->makeConnection()->query("SELECT * FROM ".$this->tableName);
    $data = $query->fetchAll();

    return $data;
  }

  public function where($property, $value) {
    $database = new Database();

    $valueType = is_numeric($value) ? PDO::PARAM_INT : PDO::PARAM_STR;

    $stmt = $database->makeConnection()->prepare('SELECT * FROM '.$this->tableName.' WHERE '.$property.' = :value');
    $stmt->bindValue(':value', $value, $valueType);
    $stmt->execute();

    $result = $stmt->fetchAll();

    return $this->buildObjects($result);
  }

  public function query($query) {
    $query->execute();
    $result = $query->fetchAll();

    return $this->buildObjects($result);
  }

  public function save() {
    $database = new Database();

    $class = new \ReflectionClass($this);
    $classProperties = $class->getProperties(\ReflectionProperty::IS_PUBLIC);

    $propertiesAndValues = [];
    $properties = [];
    $values = [];

    foreach ($classProperties as $property) {
      $propertyName = $property->getName();

      if($propertyName != "id" AND $propertyName != "created_at") {
        if (isset($this->id)) {
          $propertiesAndValues[] = '`'.$propertyName.'` = "'.$this->{$propertyName}.'"';
        } else {
          array_push($properties, $propertyName);
          array_push($values, (string)$this->{$propertyName});
        }
      }
    }
    $query = '';

    if (isset($this->id)) {
      $query = 'UPDATE `'.$this->tableName.'` SET '.implode(',', $propertiesAndValues).' WHERE id = '.$this->id;
    } else {
      $query = 'INSERT INTO '.$this->tableName.'('.implode(",", $properties).') VALUES ("'. implode('","', $values) .'")';
    }

    echo $query."<br/>";

    $sm = $database->makeConnection();
    $sm->exec($query) or die(print_r($sm->errorInfo(), true));

    return true;
  }

  private function buildObjects($array) {
    $entities = [];

    foreach ($array as $object) {
      array_push($entities, $this->buildObject($object));
    }

    return $entities;
  }

  private function buildObject($data) {
    try {
      $class = new \ReflectionClass(get_called_class());
      $entity = $class->newInstance();

      $classProperties = $class->getProperties(\ReflectionProperty::IS_PUBLIC);

      foreach($classProperties as $property) {
        if (isset($data[$property->getName()])) {
          $property->setValue($entity, $data[$property->getName()]);
        }
      }

      return $entity;

    } catch (\ReflectionException $e) {
      echo "failed to build:".$e;
    }

  }
}