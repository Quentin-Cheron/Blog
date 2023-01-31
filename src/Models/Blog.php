<?php

namespace Blog\Models;

/** Class Blog **/
class Blog
{

    private $id;
    private $title;
    private $user_id;
    private $blogs = [];
    private $content;
    private $file;
    private $date;
    private $user_name;

    public function getFile()
    {
        return $this->file;
    }

    public function getUser_name()
    {
        return $this->user_name;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getUser_id()
    {
        return $this->user_id;
    }

    public function setFile($file)
    {
        $this->file = $file;
    }

    public function setUser_name($user_name)
    {
        $this->user_name = $user_name;
    }

    public function setId(Int $id)
    {
        $this->id = $id;
    }

    public function setTitle(String $title)
    {
        $this->title = $title;
    }

    public function setUser_id(String $user_id)
    {
        $this->user_id = $user_id;
    }

    public function setContent(String $content)
    {
        $this->content = $content;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function blogs()
    {
        $manager = new CommentManager();
        if (!$this->blogs) {
            $this->blogs = $manager->getAll($this->getId(), $this->getUser_id());
        }

        return $this->blogs;
    }
}
