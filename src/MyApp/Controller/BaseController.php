<?php

namespace MyApp\Controller;

use Silex\Application;

class BaseController {

    protected $app;

    public function __construct(\Silex\Application $app) {
        $this->app = $app;
    }

    protected function userIdArr() {
        $user_id_arr = [];
        $user_id_arr['user_id'] = $this->app['session']->get('user')['id'];

        return $user_id_arr;
    }
}
