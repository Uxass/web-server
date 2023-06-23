
<?php 
    include __DIR__.'/../header.php';

    foreach($articles as $article){
        echo '<h2><a href="article/show/'.$article->getId().'">'.$article->getName().'</a></h2>';
        echo '<a href="article/delete/'.$article->getId().'">Delete</a>';
        echo '<p>'.$article->getText().'</p><hr>';
    }
    include __DIR__.'/../footer.html';
?>
    <a href="http://"></a>
            