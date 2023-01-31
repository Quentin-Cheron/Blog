<?php

namespace Blog\Models;

use Blog\Models\User;

/** Class UserManager **/
class UserManager
{

    private $bdd;

    public function __construct()
    {
        $this->bdd = new \PDO('mysql:host=' . HOST . ';dbname=' . DATABASE . ';charset=utf8;', USER, PASSWORD);
        $this->bdd->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function getBdd()
    {
        return $this->bdd;
    }

    public function find($username)
    {
        $stmt = $this->bdd->prepare("SELECT * FROM info_user WHERE user_name = ?");
        $stmt->execute(array(
            $username
        ));
        $stmt->setFetchMode(\PDO::FETCH_CLASS, "Blog\Models\User");

        return $stmt->fetch();
    }

    public function all()
    {
        $stmt = $this->bdd->query('SELECT * FROM info_user');

        return $stmt->fetchAll(\PDO::FETCH_CLASS, "Blog\Models\User");
    }

    public function store($password, $user_id)
    {
        $stmt = $this->bdd->prepare("INSERT INTO info_user(user_id, user_name, user_password, user_registration) VALUES (?, ?, ?, ?)");
        $stmt->execute(array(
            $user_id,
            $_POST["username"],
            $password,
            date("Y-m-d H:i:s")
        ));
    }
}
