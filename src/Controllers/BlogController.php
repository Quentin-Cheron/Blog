<?php

namespace Blog\Controllers;

use Blog\Models\BlogManager;
use Blog\Validator;

/** Class UserController **/
class BlogController
{
    private $manager;
    private $validator;

    public function __construct()
    {
        $this->manager = new BlogManager();
        $this->validator = new Validator();
    }

    public function index()
    {
        require VIEWS . 'Blog/homepage.php';
    }

    public function create()
    {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        require VIEWS . 'Blog/create.php';
    }

    public function createUpdate()
    {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        require VIEWS . 'Blog/update.php';
    }

    public function store()
    {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        $this->validator->validate([
            "name" => ["required", "min:2", "alphaNumDash"]
        ]);
        $_SESSION['old'] = $_POST;

        if (!$this->validator->errors()) {
            $res = $this->manager->find($_POST["name"], $_SESSION["user"]["id"]);
            if (empty($res)) {
                $this->verifFile();
                
                header("Location: /dashboard/");
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

    public function showAll()
    {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        $Blogs = $this->manager->getAll();

        require VIEWS . 'Blog/index.php';
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

    public function verifFile()
    {
        $uid = uniqid();
        $img = $uid . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        $uidAndExtension = $uid . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        if ($_FILES['file']['error']) {
            switch ($_FILES['file']['error']) {
                case 1: // UPLOAD_ERR_INI_SIZE
                    echo "La taille du fichier est plus grande que la limite autorisée par le serveur
(paramètre upload_max_filesize du fichier php.ini).";
                    break;
                case 2: // UPLOAD_ERR_FORM_SIZE
                    echo "La taille du fichier est plus grande que la limite autorisée par le
formulaire (paramètre post_max_size du fichier php.ini).";
                    break;
                case 3: // UPLOAD_ERR_PARTIAL
                    echo "L'envoi du fichier a été interrompu pendant le transfert.";
                    break;
                case 4: // UPLOAD_ERR_NO_FILE
                    echo "La taille du fichier que vous avez envoyé est nulle.";
                    echo "<a href='form.php'>Retour au formulaire</a>";
                    break;
            }
        } else {
            //si il n'ya pas d'erreur alors $_FILES['nom_du_fichier']['error'] vaut 0
            echo "Aucune erreur dans l'upload du fichier.<br />";
            if ((isset($_FILES['file']['name']) && ($_FILES['file']['error'] == UPLOAD_ERR_OK))) {
                $chemin_destination = 'img/';
                //déplacement du fichier du répertoire temporaire (stocké par défaut) dans le répertoire de destination avec la fonction
                $fichier_uploadé = $uidAndExtension;
                move_uploaded_file($fichier_uploadé, $chemin_destination);
                move_uploaded_file($_FILES['file']['tmp_name'], $chemin_destination . $uidAndExtension);
                $this->manager->store($img);
            } else {
                echo "Le fichier n'a pas pu être copié dans le répertoire fichiers.";
            }
        }
    }
}
