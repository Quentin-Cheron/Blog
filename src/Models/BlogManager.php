<?php

namespace Blog\Models;

use Blog\Models\Blog;

/** Class UserManager **/
class BlogManager
{

    private $bdd;

    public function __construct()
    {
        $this->bdd = new \PDO('mysql:host=' . HOST . ';dbname=' . DATABASE . ';charset=utf8;', USER, PASSWORD);
        $this->bdd->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function find($name, $userId)
    {
        $stmt = $this->bdd->prepare("SELECT * FROM List WHERE title = ? AND user_id = ?");
        $stmt->execute(array(
            $name,
            $userId
        ));
        $stmt->setFetchMode(\PDO::FETCH_CLASS, "Blog\Models\Blog");

        return $stmt->fetch();
    }

    public function store($img)
    {
        $stmt = $this->bdd->prepare("INSERT INTO List(title, content, user_id, date, file) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute(array(
            htmlentities($_POST["name"]),
            htmlentities($_POST["area"]),
            $_SESSION["user"]["id"],
            date("Y-m-d H:i:s"),
            $img
        ));
    }

    public function update($slug)
    {
        $stmt = $this->bdd->prepare("UPDATE List SET title = ?, content = ? WHERE title = ? AND user_id = ?");
        $stmt->execute(array(
            htmlentities($_POST["title"]),
            htmlentities($_POST["content"]),
            $slug,
            $_SESSION["user"]["id"]
        ));
    }

    public function delete($slug, $id)
    {

        $stmt = $this->bdd->prepare("DELETE FROM List WHERE id = ? AND user_id = ?");
        $stmt->execute(array(
            $id,
            $_SESSION["user"]["id"]
        ));
        header("Location: /dashboard");
    }

    public function getAll()
    {
        $stmt = $this->bdd->prepare('SELECT * FROM List');
        $stmt->execute(array());

        return $stmt->fetchAll(\PDO::FETCH_CLASS, "Blog\Models\Blog");
    }
}
