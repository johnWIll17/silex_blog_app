<?php

namespace MyApp\Test\MyApp\Controller;

use Silex\WebTestCase;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

abstract class BaseControllerTest extends WebTestCase {

    protected $app;
    protected $client;

    public function __construct() {
        $this->app = require __DIR__ .'/../../../../../app/app.php';
        $this->client = $this->createClient();
        $this->client->followRedirects();                         //?
    }

    // public function setUp() {
    // }

    public function createApplication() {
        $app = require __DIR__ .'/../../../../../app/app.php';
        $app['debug'] = true;
        unset($app['exception_handler']);
        $app['session.storage'] = new MockArraySessionStorage();  //?
        $app['session.test'] = true;                              //?

        return $app;
    }

    public function simulate_login() {
        $this->app['session']->set('user', array(
            'id' => 3,
            'email' => 'testuser@example.com',
            'password' => '12345678'
        ));
    }
}
