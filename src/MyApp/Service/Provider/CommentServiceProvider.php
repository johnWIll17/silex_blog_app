<?php

namespace MyApp\Service\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use MyApp\Model\CommentModel;
use MyApp\Service\CommentService;

class CommentServiceProvider implements ServiceProviderInterface {

    public function register(Application $app) {
        $app['comment.service'] = $app->share(function($app) {
            $comment_model = new CommentModel($app['db']);

            return new CommentService($comment_model);
        });
    }

    public function boot(Application $app) {}
}
