<?php

namespace Blog\Controllers;

use Blog\Models\UserManager;
use Blog\Validator;

/** Class UserController **/
class UserController
{
    private $manager;
    private $validator;

    public function __construct()
    {
        $this->manager = new UserManager();
        $this->validator = new Validator();
    }

    public function showLogin()
    {
        require VIEWS . 'Auth/login.php';
    }

    public function showRegister()
    {
        require VIEWS . 'Auth/register.php';
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /login/');
    }

    public function register()
    {
        $this->validator->validate([
            "username" => ["required", "min:3", "alphaNum"],
            "password" => ["required", "min:6", "alphaNum", "confirm"],
            "passwordConfirm" => ["required", "min:6", "alphaNum"]
        ]);
        $_SESSION['old'] = $_POST;

        if (!$this->validator->errors()) {
            $res = $this->manager->find($_POST["username"]);

            if (empty($res)) {
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

                $_SESSION["user"] = [
                    "id" => uniqid(),
                    "username" => $_POST["username"]
                ];
                $this->manager->store($password, $_SESSION["user"]["id"]);
                header("Location: /");
            } else {
                $_SESSION["error"]['username'] = "Le username choisi est déjà utilisé !";
                header("Location: /register");
            }
        } else {
            header("Location: /register");
        }
    }

    public function login()
    {
        $this->validator->validate([
            "username" => ["required", "min:3", "max:9", "alphaNum"],
            "password" => ["required", "min:6", "alphaNum"]
        ]);

        $_SESSION['old'] = $_POST;

        if (!$this->validator->errors()) {
            $res = $this->manager->find($_POST["username"]);

            if ($res && password_verify($_POST['password'], $res->getUser_password())) {
                $_SESSION["user"] = [
                    "id" => $res->getUser_Id(),
                    "username" => $res->getUser_name()
                ];
                header("Location: /");
            } else {
                $_SESSION["error"]['message'] = "Une erreur sur les identifiants";
                header("Location: /login");
            }
        } else {
            header("Location: /login");
        }
    }
}
