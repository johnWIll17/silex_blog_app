<?php

namespace MyApp\Controller;

use Silex\Application;

class BaseController {

    protected $app;

    public function __construct(\Silex\Application $app) {
        $this->app = $app;
    }
}
