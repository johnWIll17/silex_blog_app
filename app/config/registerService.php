<?php

use Silex\Provider\FormServiceProvider;

//form
$app->register(new FormServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());

$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'translator.messages' => array(),
));
//

//twig template
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../../resources/views'
));
//


$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());


//Doctrine
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options'   => array(
        'dbname'   => 'silex_blog',
        'user'     => 'root',
        'password' => '',
        'host'     => 'localhost',
        'driver'   => 'pdo_mysql'
    )
));

$app->register(new MyApp\Service\Provider\ArticleServiceProvider());
$app->register(new MyApp\Service\Provider\CommentServiceProvider());
$app->register(new MyApp\Service\Provider\UserServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());


//register user_controller
$app['user.controller'] = $app->share(function() use ($app) {
    return new MyApp\Controller\UserController($app);
});
