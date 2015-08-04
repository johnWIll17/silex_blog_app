<?php

namespace MyApp\Service\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use MyApp\Model\ArticleModel;
use MyApp\Service\ArticleService;

class ArticleServiceProvider implements ServiceProviderInterface {

    public function register(Application $app) {
        $app['article.service'] = $app->share(function($app) {
            $article_model = new ArticleModel($app['db']);

            return new ArticleService($article_model);
        });
    }

    public function boot(Application $app) {}
}
