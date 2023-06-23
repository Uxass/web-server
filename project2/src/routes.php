<?php
return [
    '~^$~' => [\Controllers\MainController::class, 'main'],
    '~article/show/(\d*)~' => [\Controllers\ArticleController::class, 'show'],
    '~article/edit/(\d*)~' => [\Controllers\ArticleController::class, 'edit'],
    '~article/update/(\d*)~' => [\Controllers\ArticleController::class, 'update'],
    '~article/add~' => [\Controllers\ArticleController::class, 'add'],
    '~article/store~' => [\Controllers\ArticleController::class, 'store'],
    '~article/delete/(\d+)~' => [\Controllers\ArticleController::class, 'delete'],
    '~(\d+)comments~' => [Controllers\CommentsController::class, 'view'],
    '~(\d+)/comments$~' => [Controllers\CommentsController::class, 'add'],
    '~(\d+)/comments/edit$~' => [Controllers\CommentsController::class, 'edit'],
];