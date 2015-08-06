<?php

use MyApp\Controller\Provider\Article;
use MyApp\Controller\Provider\Comment;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;


$app->before(function(Request $request, Application $app) {
    $route_name = $request->get('_route');

    if ($route_name !== 'log_in') {
        if ($route_name === 'authen_user') {
            return;
        }
        if (! $app['session']->get('user') ) {
            return $app->redirect($app['url_generator']->generate('log_in'));
        }
    }
});


//homepage
$app->get('/', function() {
    return "home page";
});

$app->mount('/articles', new MyApp\Controller\Provider\Article());
$app->mount('/comments', new MyApp\Controller\Provider\Comment());


//login/logout
$app->get('/login', 'user.controller:loginAction')
    ->bind('log_in');

$app->match('/logout', 'user.controller:logoutAction')
    ->bind('log_out')
    //->method('post|delete');
    ->method('get');

$app->match('/authen_user', 'user.controller:authenUserAction')
    ->bind('authen_user')
    ->method('post');

