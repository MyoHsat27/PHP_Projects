<?php
class One {
  public function a () : One {
    print("This is a \n");
    return $this;
  }
  public function b () : One {
    print("This is b \n");
    return $this;
  }
  public function c () : One {
    print("This is c \n");
    return $this;
  }
  public function d () : void {
    print("This is d");
  }
}
