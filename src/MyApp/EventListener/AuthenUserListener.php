<?php

namespace MyApp\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenUserListener {


    public function testAuthenListener(GetResponseEvent $event) {
        dump($event->getRequest());
        die;


    $route_name = $request->get('_route');

    if ($route_name !== 'log_in') {
        if ($route_name === 'authen_user') {
            return;
        }
        if (! $app['session']->get('user') ) {
            return $app->redirect($app['url_generator']->generate('log_in'));
        }
    }

    }
}
