<?php include __DIR__ . '/../header.php'; ?>
<h1>
    <?= $article->getName()?>
</h1>
<p>
    <?= $article->getText() ?>
</p>
<?php
$pattern = '~(\d+)comments~';
preg_match($pattern, $_GET['route'], $matches);
$i = 1;
?>
<?php foreach ($comments as $comment): ?>
    <?php if ($comment->getArticleId() == $matches[1]): ?>
        <p>
            Комментарий:
            <?= $comment->getText() ?>
        <form action="/project/www/<?= $comment->getId(); ?>/comments/edit" method="post">
            <label><input type="text" name="text"></label>

            <br><br>

            <input type="submit" value="Редактировать">
        </form>
        </p>
    <?php endif; ?>
    <?php $i++ ?>
<?php endforeach; ?>
<?php include __DIR__ . '/../footer.html'; ?>