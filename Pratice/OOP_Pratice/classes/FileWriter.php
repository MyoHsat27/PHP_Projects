<?php

class FileWriter {
  public string $fileName;
  public $file;

  public function __construct($fileName){
    $this->fileName = $fileName;
    $this->file = fopen($this->fileName, "w");
  }

  public function write(string $text) : void {
    fwrite($this->file, $text);
  }

  public function read() :string {
    return file_get_contents($this->fileName);
  }

  public function __destruct(){
    fclose($this->file);
  }
}
