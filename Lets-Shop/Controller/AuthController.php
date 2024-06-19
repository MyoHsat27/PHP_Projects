<?php
require_once ModelDir."/Auth.php";

class AuthController {
    private object $auth;

    public function __construct() {
        $this->auth = new Auth();
    }

    // View Function
    public function loginView(): void {
        view("login");
    }

    // Operation Functions
    public function login(): void {
        $email = $_POST['loginEmail'];
        $password = $_POST['loginPass'];
        $isEmail = $this->isEmail($email);

        if ($isEmail) {
            $result = $this->auth->loginEmail($email, $password);
        } else {
            $result = $this->auth->loginUsername($email, $password);
        }
        if ($result) {
            $roleName = $isEmail ? $this->auth->getRoleIdEmail($email)->role_name : $this->auth->getRoleIdName($email)->role_name;
            setSession(true, "login");
            setSession($isEmail ? $this->auth->getRoleIdEmail($email)->id : $this->auth->getRoleIdName($email)->id, "user_id");
            setSession($roleName, "role");
            if ($roleName === "admin") {
                redirect(route("admin/product"));
            } else {
                redirect(route("shop"));
            }
        } else {
            redirectBack("Form Invalid", "formInvalid");
        }
    }

    public function isEmail(string $email): bool {
        $isEmail = true;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $isEmail = false;
        }
        return $isEmail;
    }

    public function logout(): void {
        session_unset();
        redirectBack();
    }

    public function logoutAdmin(): void {
        session_unset();
        redirect(route("login"));
    }

    // Common Functions

    public function signUp(): void {
        $email = $_POST['signEmail'];
        $password = $_POST['signPass'];
        $username = $_POST['signUser'];

        if ($this->formValidation($email, $password, $username)) {
            $hashPassword = password_hash($password, PASSWORD_BCRYPT);
            $result = $this->auth->signUp($email, $hashPassword, $password, $username);
            if ($result) {
                setSession(true, "login");
                setSession("customer", "role");
                setSession($this->auth->getRoleIdEmail($email)->id, "user_id");
                redirect(url("shop"));
            } else {
                redirectBack("Form Invalid", "formInvalid");
            }
        } else {
            setSession($email, "signEmail");
            setSession($password, "signPass");
            setSession($username, "signUser");
            redirectBack("Form Invalid", "formInvalid");
        }
    }

    public function formValidation(string $email, string $password, string $username = null): bool {
        $isValid = true;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            setSession("Email is invalid", "emailInvalid");
            $isValid = false;
        }
        if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $password)) {
            setSession("Password is invalid", "passInvalid");
            $isValid = false;
        }
        if (!preg_match("/^(?=.{3,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._\s]+(?<![_.])$/", $username)) {
            setSession("Username is invalid", "userInvalid");
            $isValid = false;
        }
        return $isValid;
    }
}