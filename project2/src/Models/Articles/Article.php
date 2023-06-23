<?php
namespace Models\Articles;

use Models\Users\User;
use Models\ActiveRecordEntity;

class Article extends ActiveRecordEntity
{
    protected $authorId;
    protected $name;
    protected $text;
    protected $createdAt;

    public function getText()
    {
        return $this->text;
    }
    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setText(string $text)
    {
        $this->text = $text;
    }

    public function setAuthorId(User $author)
    {
        $this->authorId = $author->getId();
    }

    public function getAuthorId(): User
    {
        return User::getById($this->authorId);
    }

    protected static function getTableName(): string
    {
        return 'articles';
    }
}