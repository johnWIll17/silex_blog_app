<?php

namespace MyApp\Controller\Provider;

use Silex\ControllerProviderInterface;
use Silex\Application;
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

        $articles->get('/{id}/edit', array($article_controller, 'indexAction'))
            ->bind('article_edit');

        $articles->match('/{id}', array($article_controller, 'indexAction'))
            ->bind('article_update')
            ->method('post|put');

        $articles->match('/{id}/delete', array($article_controller, 'indexAction'))
            ->bind('article_delete')
            ->method('delete');


        return $articles;
    }
}
