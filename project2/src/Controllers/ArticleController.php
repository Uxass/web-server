<?php
namespace Controllers;

use View\View;
use Models\Articles\Article;
use Models\Users\User;
use Models\Comments\Comment;

class ArticleController
{
    private $view;

    public function __construct()
    {
        $this->view = new View("__DIR__.'/../../templates");
    }

    public function store()
    {
        $article = new Article();
        $author = User::getById(1);
        $article->setAuthorId($author);
        $article->setName('new title');
        $article->setText('new text');
        $article->save();
    }

    public function show(int $id)
    {
        $result = Article::getById($id);
        $comments = Comment::findAll();

        if (empty($result)) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }
        $this->view->renderHtml('articles/show.php', ['article' => $result, 'comments' => $comments]);
    }

    public function edit(int $id)
    {
        $article = Article::getById($id);
        $this->view->renderHtml('articles/edit/php', ['article' => $article]);
    }

    public function update($id)
    {
        $article = Article::getById($id);
        $article->setName($_POST['name']);
        $article->setText($_POST['text']);
        $article->save();
    }

    public function add()
    {
        $this->view->renderHtml('articles/add.php');
    }

    public function delete(int $id)
    {
        $article = Article::getById($id);
        $article->destroy();

    }
}