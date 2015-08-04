<?php

namespace MyApp\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use MyApp\Controller\BaseController;
use MyApp\Form\ArticleType;

class ArticleController extends BaseController {

    public function indexAction() {
        $article_full = $this->app['article.service']->getAll();
        return $this->app['twig']->render('articles/index.html.twig', array(
            'article_full' => $article_full
        ));
    }
    public function newAction() {
        $options = array(
            'form_action' => $this->app['url_generator']->generate('article_create'),
            'form_method' => 'POST',
            'submit_label' => 'Create Article'
        );
        $form = $this->createArticleForm($options);

        return $this->app['twig']->render('articles/new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function createAction(Request $request) {
        $options = array(
            'form_action' => $this->app['url_generator']->generate('article_create'),
            'form_method' => 'POST',
            'submit_label' => 'Create Article'
        );
        $form = $this->createArticleForm($options);

        $form->handleRequest($request);
        dump($form);
        die;

        if ($form->isValid()) {

            $this->app['article.service']->insertToArticle($form->getData());

            $this->app['session']->getFlashBag()->add('message', array(
                'type' => 'success',
                'content' => "You have created an article successfully!"
            ));

            return $this->app->redirect($this->app['url_generator']->generate('articles'));

        } else {
            return $this->app['twig']->render('articles/new.html.twig', array(
                'form' => $form->createView()
            ));
        }
    }

    public function showAction($id) {
        $article = $this->app['article.service']->getById($id);

        return $this->app['twig']->render('articles/show.html.twig', array(
            'article' => $article
        ));
    }

    //working
    public function editAction(Request $request, $id) {
        $options = array(
            'form_action' => $this->app['url_generator']->generate('article_update', array('id' => $id)),
            'form_method' => 'PUT',
            'submit_label' => 'Update Article'
        );
        $article = $this->app['article.service']->getById($id);

        $form = $this->createArticleForm($options, $article);

        return $this->app['twig']->render('articles/edit.html.twig', array(
            'form' => $form->createView()
        ));

    }
    //
    public function updateAction(Request $request, $id) {
        $options = array(
            'form_action' => $this->app['url_generator']->generate('article_update', array('id' => $id)),
            'form_method' => 'PUT',
            'submit_label' => 'Update Article'
        );

        $article = $this->app['article.service']->getById($id);

        $form = $this->createArticleForm($options, $article);

        $form->handleRequest($request);
        dump($form->getData());
        die;

        ////////////////////////////////
        $options = array(
            'form_action' => $this->app['url_generator']->generate('article_create'),
            'form_method' => 'POST',
            'submit_label' => 'Create Article'
        );
        $form = $this->createArticleForm($options);

        $form->handleRequest($request);
        dump($form);
        die;
        ///////////////////////////////



        if ($form->isValid()) {
            return "ok";
        } else {
            return "not ok";
        }

        if ($form->isValid()) {
            $this->app['article.service']->updateToArticle($id);

            return $this->app->redirect($this->app['url_generator']->generate('article_show', array('id' => $id)));
        } else {
            return "something wrong when updating article";
        }

    }
    public function deleteAction() {}

    //private function
    private function createArticleForm($options, $data = null) {
        return $this->app['form.factory']
            ->createBuilder(new ArticleType(), $data, array(
                //'action' => $this->app['url_generator']->generate('article_create'),
                //'action' => $this->app['url_generator']->generate($options['form_action']),
                'action' => $options['form_action'],
                'method' => $options['form_method']
            ))
            //->add('submit', 'submit', array('label' => 'Create Article'))
            ->add('submit', 'submit', array('label' => $options['submit_label']))
            ->getForm()
        ;
    }

    private function allowFields($arr, $allow_fields) {
        return array_filter($arr, function($k) use ($allow_fields) {
            if ( in_array($k, $allow_fields) ) {
                return true;
            }
        }, ARRAY_FILTER_USE_KEY);
    }
}
