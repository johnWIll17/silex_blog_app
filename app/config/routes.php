<?php

use MyApp\Controller\Provider\Article;
use MyApp\Controller\Provider\Comment;

//homepage
$app->get('/', function() {
    return "home page";
});

$app->mount('/articles', new MyApp\Controller\Provider\Article());
$app->mount('/comments', new MyApp\Controller\Provider\Comment());

