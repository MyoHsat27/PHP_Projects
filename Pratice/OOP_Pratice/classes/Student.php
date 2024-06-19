<?php
class Student {
  public string $name, $gender, $namePrefix;
  public int $birthYear, $age;

  public function __construct($name, $gender, $birthYear) {
    $this->name = $name;
    $this->gender = $gender;
    $this->birthYear = $birthYear;

    $this->namePrefix = $this->gender === "male" ? "Mr. " : "Ms. ";
    $this->age = date("Y") - $this->birthYear;
  }

  public function showFullName() : string {
    return $this->namePrefix . $this->name;
  }

}
