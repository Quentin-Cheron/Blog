<?php

namespace Blog\Models;

use Blog\Models\Blog;

/** Class UserManager **/
class CommentManager
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

    public function store()
    {
        $stmt = $this->bdd->prepare("INSERT INTO comment(content, user_id, date, id_article) VALUES (?, ?, ?, ?)");
        $stmt->execute(array(
            htmlentities($_POST["comment"]),
            htmlentities($_POST["user"]),
            date("Y-m-d H:i:s"),
            $_POST["id_article"]
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

    public function getAll($id, $user_id)
    {
        $stmt = $this->bdd->prepare('SELECT * FROM comment WHERE id_article = ?');
        $stmt->execute(array(
            $id
        ));

        return $stmt->fetchAll(\PDO::FETCH_CLASS, "Blog\Models\Blog");
    }
}
