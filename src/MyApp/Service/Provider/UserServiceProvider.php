<?php

namespace MyApp\Service\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use MyApp\Model\UserModel;
use MyApp\Service\UserService;

class UserServiceProvider implements ServiceProviderInterface {

    public function register(Application $app) {
        $app['user.service'] = $app->share(function($app) {
            $user_model = new UserModel($app['db']);

            return new UserService($user_model);
        });
    }

    public function boot(Application $app) {}
}
