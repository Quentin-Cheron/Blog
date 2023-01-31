<?php

namespace Blog\Controllers;

use Blog\Models\CommentManager;
use Blog\Validator;

/** Class UserController **/
class CommentController
{
    private $manager;
    private $validator;

    public function __construct()
    {
        $this->manager = new CommentManager();
        $this->validator = new Validator();
    }

    public function index()
    {
        require VIEWS . 'Blog/homepage.php';
    }

    public function store()
    {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        $_SESSION['old'] = $_POST;
        if (!$this->validator->errors()) {
            if (empty($res)) {
                $this->manager->store();
                header("Location: /dashboard/" . $_POST["name"]);
            } else {
                $_SESSION["error"]['name'] = "Le nom du blog est déjà utilisé !";
                header("Location: /dashboard/nouveau");
            }
        } else {
            header("Location: /dashboard/nouveau");
        }
    }

    public function update($slug)
    {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        $_SESSION['old'] = $_POST;

        if (!$this->validator->errors()) {
            $res = $this->manager->find($slug, $_SESSION["user"]["id"]);

            if (empty($res) || $res->getTitle() == $slug) {
                $this->manager->update($slug);
                header("Location: /dashboard/" . $_POST["title"]);
            } else {
                $_SESSION["error"]['title'] = "Le nom de la liste est déjà utilisé !";
                header("Location: /dashboard/" . $slug);
            }
        } else {
            header("Location: /dashboard/" . $slug);
        }
    }

    public function delete($slug)
    {
        $res = $this->manager->find($slug, $_SESSION["user"]["id"]);
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        $this->manager->delete($slug, $res->getId());
    }

    public function show($slug)
    {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        $Blog = $this->manager->find($slug, $_SESSION["user"]["id"]);
        if (!$Blog) {
            header("Location: /error");
        }
        require VIEWS . 'Blog/show.php';
    }
}
