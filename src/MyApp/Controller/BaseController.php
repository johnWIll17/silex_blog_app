<?php

namespace MyApp\Controller;

use Silex\Application;

class BaseController {

    protected $app;
    protected $current_user;

    public function __construct(\Silex\Application $app) {
        $this->app = $app;
        $this->current_user = $app['session']->get('user')['email'];
    }

    protected function userIdArr() {
        $user_id_arr = [];
        $user_id_arr['user_id'] = $this->app['session']->get('user')['id'];

        return $user_id_arr;
    }

    protected function userInfo() {
        return $this->app['session']->get('user');
    }
}
