<?php
require_once ModelDir."/DBConfig.php";

class Auth {
    private mysqli $db_connection;
    private object $dbConfig;

    public function __construct() {
        $this->dbConfig = new DBConfig();
        $this->db_connection = $this->dbConfig->db_connection();
    }

    public function loginUsername(string $username, string $password): bool {
        $stmt = $this->db_connection->prepare("SELECT password from users WHERE name = ?");
        return $this->login($stmt, $username, $password);

    }

    public function loginEmail(string $email, string $password): bool {
        $stmt = $this->db_connection->prepare("SELECT password from users WHERE email = ?");
        return $this->login($stmt, $email, $password);
    }

    private function login(bool|mysqli_stmt $stmt, string $username, string $password): bool {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $data = $stmt->get_result();
        $hashPassword = $data->fetch_object()->password;
        if (isset($hashPassword)) {
            if ($this->checkPassword($hashPassword, $password)) {
                return true;
            } else {
                setSession($username, "loginEmail");
                setSession($password, "loginPass");
                setSession("Incorrect Password", "incorrectPass");
            }
        } else {
            setSession($username, "loginEmail");
            setSession($password, "loginPass");
            setSession("Email or Username doesn't exist", "notExist");
        }
        return false;
    }

    public function signUp(string $email, string $hashPassword, string $password, string $username): mysqli|bool {
        if ($this->checkEmailExist($email)) {
            setSession($email, "signEmail");
            setSession($password, "signPass");
            setSession($username, "signUser");
            setSession("Email already exists", "emailExist");
            return false;
        } elseif ($this->checkUserExist($username)) {
            setSession($email, "signEmail");
            setSession($password, "signPass");
            setSession($username, "signUser");
            setSession("Username already exists", "userExist");
            return false;
        } else {
            $query = "INSERT INTO users (name, email, password, role_id) VALUES ('$username', '$email', '$hashPassword', 2)";
            return $this->dbConfig->run($this->db_connection, $query);
        }
    }

    private function checkPassword(string $hashPassword, string $password): bool {
        if (password_verify($password, $hashPassword)) {
            return true;
        } else {
            return false;
        }
    }

    private function checkEmailExist(string $email): bool {
        $query = "SELECT EXISTS(SELECT 1 FROM users WHERE email = '$email') AS emailExists;";
        $data = $this->dbConfig->run($this->db_connection, $query);
        return mysqli_fetch_object($data)->emailExists;
    }

    private function checkUserExist(string $user): bool {
        $query = "SELECT EXISTS(SELECT 1 FROM users WHERE name='$user') AS userExists;";
        $data = $this->dbConfig->run($this->db_connection, $query);
        return mysqli_fetch_object($data)->userExists;
    }

    public function getRoleIdEmail(string $email): object|bool {
        $stmt = $this->db_connection->prepare("SELECT roles.role_name, users.id FROM users INNER JOIN roles ON users.role_id = roles.id WHERE users.email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $data = $stmt->get_result();
        return $data->fetch_object();
    }

    public function getRoleIdName(string $name): object|bool {
        $stmt = $this->db_connection->prepare("SELECT roles.role_name, users.id FROM users INNER JOIN roles ON users.role_id = roles.id WHERE users.name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $data = $stmt->get_result();
        return $data->fetch_object();
    }

    public function getUserInfo (int $id) : object|bool {
        $stmt = $this->db_connection->prepare("SELECT users.name, users.email, users.profile_img FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $data = $stmt->get_result();
        return $data->fetch_object();
    }




}