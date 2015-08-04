<?php

namespace MyApp\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use MyApp\Controller\BaseController;
use MyApp\Form\ArticleType;

class ArticleController extends BaseController {

    public function indexAction() {
        return "index page";
    }
    public function newAction() {
        // $form = $this->app['form.factory']
        //     ->createBuilder(new ArticleType(), null, array(
        //         'action' => $this->app['url_generator']->generate('article_create'),
        //         'method' => 'POST'
        //     ))
        //     ->add('submit', 'submit', array('label' => 'Create Article'))
        //     ->getForm()
        // ;

        $form = $this->createArticleForm();

        return $this->app['twig']->render('articles/new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function createAction(Request $request) {
        $form = $this->createArticleForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            return $this->app->redirect($this->app['url_generator']->generate('articles'));
        } else {
            return "something wrong";
        }
    }

    public function showAction($id) {}
    public function editAction(Request $request, $id) {}
    public function updateAction(Request $request, $id) {}
    public function deleteAction() {}

    //private function
    private function createArticleForm() {
        return $this->app['form.factory']
            ->createBuilder(new ArticleType(), null, array(
                'action' => $this->app['url_generator']->generate('article_create'),
                'method' => 'POST'
            ))
            ->add('submit', 'submit', array('label' => 'Create Article'))
            ->getForm()
        ;
    }
}
