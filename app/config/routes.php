<?php

use MyApp\Controller\Provider\Article;

//homepage
$app->get('/', function() {
    return "home page";
});

$app->mount('/articles', new MyApp\Controller\Provider\Article());

