<?php

function dd ($data,$showType = false) : void {
    echo "<pre style='background-color: #1d1d1d; color: #cdcdcd; padding: 20px; margin: 10px; border-radius: 10px; line-height: 1.2rem'>";
    if ($showType) {
        var_dump($data);
    } else {
        print_r($data);
    }
    echo "</pre>";
    die();
}

function url (string $path = null) : string {
    $url = isset($_SERVER['HTTPS']) ? "https" : "http";
    $url .= "://" . $_SERVER['HTTP_HOST'];
    if (isset($path)) {
        $url .= "/" . $path;
    }
    return $url;
}

function alert(string $message, string $color = "success") : string {
    return "<div class='alert alert-$color'>$message</div>";
}

function sanitize (string $str, bool $strip = false) : string {
  if ($strip) {
    $str = strip_tags($str);
  } else {
    $str = trim($str);
    $str = htmlentities($str, ENT_QUOTES);
    $str = stripslashes($str);
  }
  return $str;
}


function paginator (array $lists) : string {
  $links = "";
  foreach ($lists as $link) {
    $links .= "<li class='page-item ".$link['isActive']."'><a href='".$link['url']."' class='page-link'>".$link['page_num']."</a></li>";
  };
  return "<div class='d-flex mt-3 justify-content-end align-items-center'>
    <nav aria-label='Page navigation example'>
      <ul class='pagination'>
           ".$links."
      </ul>
    </nav>
  </div>";
}

function showDateTime (string $sqlTimeStamp, string $format = 'j-M-Y | h :i:s') :string {
    return date($format, strtotime($sqlTimeStamp));
}

function view (string $viewName, array $data = null) : void {
    if (!empty($data)) {
        foreach ($data as $key => $value) {
            ${$key} = $value;
        }
    }
    require_once ViewDir."/$viewName.view.php";
}

function controller (string $controllerName) : void {
    $controllerNameArray = explode("@", $controllerName);
    require_once ControllerDir."/$controllerNameArray[0].controller.php";
    call_user_func($controllerNameArray[1]);
}
  
function route (string $path = null, array $quries = null) : string {
    $url = url($path);
    if (!is_null($quries)) {
        $url .= "?" . http_build_query($quries);
    }
    return $url;
}

function redirect (string $url = null, string $message = null, string $key = "message") : void{
  if (!is_null($message)) {
    setSession($message, $key);
  }
    header("Location:".$url);
}

function redirectBack (string $message = null) : void {
  redirect($_SERVER["HTTP_REFERER"], $message);
}

function getTotal (array $lists) : int {
    $total = 0;
    foreach ($lists as $list) {
        $total += $list['money'];
    }
    return $total;
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

function paginate (string $sql, int $limit) : array {
  $total = first(str_replace("*", "COUNT(id) AS total", $sql), false)['total'];

  $totalPage = ceil($total / $limit);
  $currentPage = $_GET['page'] ?? 1;
  $offset = ($currentPage - 1) * $limit;
  $sql .= " LIMIT $offset,$limit";

  $links = [];
  for ($i = 1; $i <= $totalPage; $i++) {
    $queries = $_GET;
    $queries["page"] = $i;
    $url = url().$GLOBALS['path']."?".http_build_query($queries);
    $links[] = [
      "url" => $url,
      "isActive" => $i == $currentPage ? "active" : "",
      "page_num" => $i
    ];
  }

  return [
    "total" => $total,
    "limit" => $limit,
    "total_page" => $totalPage,
    "current_page" => $currentPage,
    "data" => all($sql),
    "links" => $links
  ];
}

// More Color : https://i.stack.imgur.com/HFSl1.png
function logger (string $meesage,int $colorCode = 32) : void {
  echo " \e[39m[LOG]" . " \e[{$colorCode}m" . $meesage . " \n";
}

// HTTP Response Code : https://devsheet.com/code-snippet/http-response-codes/
function responseJson (mixed $data, int $status = 200) : string {
  header("Content-type:Application/json");
  http_response_code($status);
  if (is_array($data)) {
    return print(json_encode($data));
  }
  return print(json_encode(["message" => $data]));
}

// validation functions start
function setError (string $key, string $message) : void {
  $_SESSION["error"][$key] = $message;
}

function hasError (string $key) : bool {
  if (!empty($_SESSION["error"][$key])) return true;
  return false;
}

function getError (string $key) : string {
  $message = $_SESSION["error"][$key];
  unset($_SESSION["error"][$key]);
  return $message;
}

function old (string $key) : string|null {
  if (isset($_SESSION['old'])) {
    $data = $_SESSION['old'][$key];
    unset($_SESSION['old'][$key]);
    return $data;
  }
  return null;
}

function validationStart () : void {
  unset($_SESSION['old']);
  unset($_SESSION['error']);
  $_SESSION["old"] = $_POST;
}

function validationEnd (bool $isApi = false) : void {
  if (hasSession("error")) {
    if ($isApi) {
      responseJson([
        "status" => false,
        "errors" => getSession('error')
      ],400);
    } else {
      redirectBack();
    }
    die();
  } else {
    unset($_SESSION['old']);
  }
}
// validation functions end

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
//session function end

//Database Function Start
function run (string $sql, bool $closeConnection = false) : object|bool {
  try {
    $query = mysqli_query($GLOBALS['conn'], $sql);
    if ($closeConnection) mysqli_close($GLOBALS['conn']);
    return $query;
  } catch (Exception $e) {
    dd($e);
  }
}

function all (string $sql, bool $closeConnection = false) : array {
  $query = run($sql);
  $lists = [];
  while ($row = mysqli_fetch_assoc($query)) {
    $lists[] = $row;
  }
  if ($closeConnection) mysqli_close($GLOBALS['conn']);
  return $lists;
}

function first (string $sql, bool $closeConnection = false): array|null {
  $query = $closeConnection ? run($sql) : run($sql, false);
  return mysqli_fetch_assoc($query);
}

function dropAllTable (string $dbname) : void {
  $query = run("SELECT CONCAT('DROP TABLE IF EXISTS ', TABLE_NAME, ';') AS drop_table FROM information_schema.TABLES WHERE TABLE_SCHEMA='{$dbname}';");

  for ($i = 1; $i <= $query->num_rows; $i++) {
    $drop_sql = mysqli_fetch_assoc($query)['drop_table'];
    run($drop_sql);
  }

  logger("All tables are dropped", 93);
}

function createTable (string $name, ...$columns) : void {
  $sql = "DROP TABLE IF EXISTS $name";
  logger($name . " table Drop Successfully",93);

  $sql = "CREATE TABLE $name (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    ".join(',', $columns).",
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;";
  run($sql);
  logger($name . " table Created Successfully.");

}

//Database Function End
