<?php

namespace MyApp\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use MyApp\Controller\BaseController;
use MyApp\Form\LoginType;

class UserController extends BaseController {

    public function loginAction() {
        $form = $this->createLoginForm();

        return $this->app['twig']->render('users/login.html.twig', array(
            'login_form' => $form->createView()
        ));
    }

    public function logoutAction() {
        $this->app['session']->remove('user');

        return $this->app->redirect('login');
    }

    public function authenUserAction(Request $request) {
        $form = $this->createLoginForm();
        $form->handleRequest($request);

        if ($form->isValid()) {

            $data = $form->getData();
            $user = $this->app['user.service']->findUser($data);

            if (empty($user)) {
                $this->app['session']->getFlashBag()->add('message', array(
                    'type' => 'danger',
                    'message' => 'Your info is invalid!'
                ));

                return $this->app['twig']->render('users/login.html.twig', array(
                    // 'invalid_user' => 'Your info is invalid!',
                    'login_form' => $form->createView()
                ));
            } else {
                $this->app['session']->set('user', array(
                    'email' => $data['email'],
                    'password' => $data['password'],
                    'id' => $user[0]['id']
                ));

                $this->app['session']->getFlashBag()->add('message', array(
                    'type' => 'success',
                    'message' => "Logging Successfully!"
                ));
                return $this->app->redirect($this->app['url_generator']->generate('articles'));
            }

        } else {
            return $this->app['twig']->render('users/login.html.twig', array(
                'login_form' => $form->createView()
            ));
        }
    }

    //private
    private function createLoginForm() {
        return $this->app['form.factory']
            ->createBuilder(new LoginType(), null, array(
                'action' => $this->app['url_generator']->generate('authen_user'),
                'method' => 'POST'
            ))
            ->getForm()
        ;
    }


    // public function indexAction() {}
    // public function indexAction() {}
    // public function indexAction() {}
    // public function indexAction() {}
    // public function indexAction() {}
    // public function indexAction() {}
}
