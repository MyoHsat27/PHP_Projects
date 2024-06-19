<?php
function home () : void {
    view("home");
}

function about () : void {
    view("about");
}

function showSession () : void {
//  session_unset();
  dd($_SESSION);
}
