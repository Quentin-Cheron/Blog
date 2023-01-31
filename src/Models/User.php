<?php
namespace Blog\Models;

/** Class User **/
class User {

    private $user_name;
    private $user_password;
    private $user_id;

    public function getUser_name() {
        return $this->user_name;
    }

    public function getUser_password() {
        return $this->user_password;
    }

    public function getUser_id() {
        return $this->user_id;
    }

    public function setUsername(String $user_name) {
        $this->user_name = $user_name;
    }

    public function setUser_password(String $user_password) {
        $this->user_password = $user_password;
    }

    public function setUser_Id(Int $user_id) {
        $this->user_id = $user_id;
    }
}
