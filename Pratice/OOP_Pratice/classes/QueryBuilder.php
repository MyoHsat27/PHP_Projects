<?php

class QueryBuilder {
  public string $tableName;
  public array $where, $orWhere;

  public function __construct($tableName) {
    $this->tableName = $tableName;
  }

  public function sql () : string {
    $sql = "SELECT * FROM $this->tableName";

    if (!empty($this->where)) {
      $sql .= " WHERE " . join(" AND ", $this->where);
    }

    if (!empty($this->orWhere)) {
      $sql .= " OR " . join(" OR ", $this->orWhere);
    }

    return $sql . ";";
  }

  public function where ($columnName, $operator, $value) : QueryBuilder  {
    $this->where[] = "$columnName $operator '$value'";
    return $this;
  }

  public function orWhere ($columnName, $operator, $value) : QueryBuilder {
    $this->orWhere[] = "$columnName $operator '$value'";
    return $this;
  }
}
