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


//register event dispatcher
// use MyApp\EventListener\AuthenUserListener;
// use Symfony\Component\EventDispatcher\EventDispatcher;
// use Symfony\Component\EventDispatcher\Event;
// use Symfony\Component\HttpKernel\KernelEvents;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Response;

$dispatcher = $app['dispatcher'];
// $listener = new AuthenUserListener();
// $dispatcher->addListener('kernel.request', array($listener, 'testAuthenListener'), 100);
// $dispatcher->dispatch(KernelEvents::REQUEST, $listener);
//

// $dispatcher->addListener(KernelEvents::REQUEST, function (GetResponseEvent $event) use ($app) {
//     $controller = $app['request']->get('_controller');
//
//     if ($controller[1] === "indexAction") {
//         $response = new Response($app->redirect($app['url_generator']->generate('article_new')));
//
//         $event->setResponse($response);
//     }
// });

use MyApp\Controller\UserController;
$user_c = new UserController($app);
$dispatcher->addListener(KernelEvents::REQUEST, array($user_c, 'testAuth'));




