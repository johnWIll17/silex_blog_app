<?php

namespace MyApp\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenUserListener {


    public function testAuthenListener(GetResponseEvent $event) {
        dump($event->getRequest());
        die;
    }
}
