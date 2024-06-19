<?php
// monitoring function start
function dd ($data, bool $showType = false) : void {
  echo "<pre style='background-color: #1d1d1d; color: #cdcdcd; padding: 20px; margin: 10px; border-radius: 10px; line-height: 1.2rem'>";
  if ($showType) {
    var_dump($data);
  } else {
    print_r($data);
  }
  echo "</pre>";
  die();
}
function logger (string $meesage,int $colorCode = 32) : void {
    echo " \e[39m[LOG]" . " \e[{$colorCode}m" . $meesage . " \n";
}
// monitoring function end

function url (string $path = null) : string {
  $url = isset($_SERVER["HTTPS"]) ? "https" : "http";
  $url .= "://" . $_SERVER['HTTP_HOST'];
  if (isset($path)) {
    $url .= "/" . $path;
  }
  return $url;
}

// route function start
function route (string $path = null,array $query = null) : string {
    $url = url($path);
    if (!is_null($query)) {
        $url .= "?" . http_build_query($query);
    }
    return $url;
}
function redirect (string $url = null, string $message = null, string $key = "message") : void{
    if (!is_null($message)) {
        setSession($message, $key);
    }
    header("Location:".$url);
}
function redirectBack (string $message = null, string $key = null) : void {
    if (!is_null($message)) {
        redirect($_SERVER["HTTP_REFERER"], $message, $key);
    }
    redirect($_SERVER["HTTP_REFERER"]);
}
// route function end

//session function start
function setSession (string $message, string $key = 'message') : void {
    $_SESSION[$key] = $message;
}

function getSession(string $key="message") : string|array {
    $message = $_SESSION[$key];
    unset($_SESSION[$key]);
    return $message;
}

function hasSession (string $key='message') : bool {
    if (!empty($_SESSION[$key])) return true;
    return false;
}
function checkLogin () : bool {
    if (isset($_SESSION['login']) && $_SESSION['login']) {
        return true;
    }
    return false;
}
function checkCustomerLogin () : bool {
    if (checkLogin() && $_SESSION['role'] === "customer") {
        return true;
    }
    return false;
}
function checkAdminLogin () : bool {
    if (checkLogin() && $_SESSION['role'] === "admin") {
        return true;
    }
    return false;
}
//session function end

function controller (string $controllerFormat) : void {
    $controllerNameArr = explode("@", $controllerFormat);
    $controllerName = $controllerNameArr[0];
    $functionName = $controllerNameArr[1];

    require_once ControllerDir."/$controllerName.php";
    $controller = new $controllerName();
    $controller->$functionName();
}

function view (string $fileName, array $data = null) : void {
    if (!empty($data)) {
        foreach ($data as $key => $value) {
            ${$key} = $value;
        }
    }
  require_once ViewDir."/$fileName.php";
}

function checkRequestMethod (string $methodName) {
    $methodName = strtoupper($methodName);
    if ($methodName === "POST" && $_SERVER["REQUEST_METHOD"] === "POST") {
        return true;
    } elseif ($methodName === "PUT" && ( $_SERVER["REQUEST_METHOD"] === "PUT" || ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["_method"]) && strtoupper($_POST['_method']) === "PUT"))) {
        return true;
    } elseif ($methodName === "DELETE" && ( $_SERVER["REQUEST_METHOD"] === "DELETE" || ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["_method"]) && strtoupper($_POST['_method']) === "DELETE"))) {
        return true;
    }
}