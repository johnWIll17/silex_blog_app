<?php

namespace MyApp\Controller\Provider;

use Silex\Application;
use Silex\ControllerProviderInterface;
use MyApp\Controller\ArticleController;

class Article implements ControllerProviderInterface {

    public function connect(Application $app) {
        $article_controller = new ArticleController($app);

        $articles = $app['controllers_factory'];

        $articles->get('/', array($article_controller, 'indexAction'))
            ->bind('articles');

        $articles->get('/new', array($article_controller, 'newAction'))
            ->bind('article_new');

        $articles->match('/', array($article_controller, 'createAction'))
            ->bind('article_create')
            ->method('post');

        $articles->get('/{id}', array($article_controller, 'showAction'))
            ->bind('article_show');

        $articles->get('/{id}/edit', array($article_controller, 'editAction'))
            ->bind('article_edit');

        $articles->match('/{id}', array($article_controller, 'updateAction'))
            ->bind('article_update')
            ->method('post');

        //$articles->match('/{id}/delete', array($article_controller, 'deleteAction'))
        $articles->match('/{id}/delete', array($article_controller, 'deleteAction'))
            ->bind('article_delete')
            ->method('post|delete');


        return $articles;
    }
}
