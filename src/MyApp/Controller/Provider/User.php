<?php

namespace MyApp\Controller\Provider;

use Silex\Application;
use Silex\ControllerProviderInterface;
use MyApp\Controller\UserController;

class User implements ControllerProviderInterface {

    public function connect(Application $app) {
        $user_controller = new UserController($app);

        $users = $app['controllers_factory'];

        $users->get('')

        $users->get('/', array($user_controller, 'indexAction'))
            ->bind('users');

        $users->get('/new', array($user_controller, 'newAction'))
            ->bind('article_new');

        $users->match('/', array($user_controller, 'createAction'))
            ->bind('article_create')
            ->method('post');

        $users->get('/{id}', array($user_controller, 'showAction'))
            ->bind('article_show');

        $users->get('/{id}/edit', array($user_controller, 'editAction'))
            ->bind('article_edit');

        $users->match('/{id}', array($user_controller, 'updateAction'))
            ->bind('article_update')
            ->method('post');

        //$users->match('/{id}/delete', array($user_controller, 'deleteAction'))
        $users->match('/{id}/delete', array($user_controller, 'deleteAction'))
            ->bind('article_delete')
            ->method('post|delete');


        return $users;
    }
}
