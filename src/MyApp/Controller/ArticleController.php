<?php

namespace MyApp\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use MyApp\Controller\BaseController;
use MyApp\Form\ArticleType;

class ArticleController extends BaseController {

    public function indexAction(Request $request) {
        //$article_full = $this->app['article.service']->paginate();
        //$article_full = $this->app['article.service']->getAll();

        $page = $request->get('page') ? $request->get('page') : 1;
        $article_full = $this->app['article.service']->paginate($page);

        return $this->app['twig']->render('articles/index.html.twig', array(
            'article_full' => $article_full,
            'page_total' => $this->app['article.service']->totalPageArticle()
        ));
    }
    public function newAction() {
        $form = $this->createArticleForm();

        return $this->app['twig']->render('articles/new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function createAction(Request $request) {
        $form = $this->createArticleForm();

        $form->handleRequest($request);

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

        $delete_form = $this->deleteArticleForm($id);

        return $this->app['twig']->render('articles/show.html.twig', array(
            'article' => $article,
            'delete_form' => $delete_form->createView()
        ));
    }


    public function editAction($id) {
        $article = $this->app['article.service']->getById($id);

        $form = $this->updateArticleForm($article, $id);

        return $this->app['twig']->render('articles/edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function updateAction($id, Request $request) {
        $article = $this->app['article.service']->getById($id);

        $form = $this->updateArticleForm($article, $id);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $ret = $this->app['article.service']->updateToArticle($id, $form->getData());

            if ($ret === 1) {
                $this->app['session']->getFlashBag()->add('message', array(
                    'type' => 'success',
                    'content' => 'You have updated article successfully!'
                ));

                return $this->app->redirect($this->app['url_generator']->generate('article_show', array('id' => $id)));
            }

        } else {

            return $this->app['twig']->render('articles/edit.html.twig', array(
                'form' => $form->createView()
            ));
        }

    }
    public function deleteAction($id) {
        $delete_form = $this->deleteArticleForm($id);

        $this->app['article.service']->deleteById($id);
        $this->app['session']->getFlashBag()->add('message', array(
            'type' => 'success',
            'content' => 'You have deleted an article successfully!'
        ));

        return $this->app->redirect($this->app['url_generator']->generate('articles'));
    }

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

    private function updateArticleForm($data, $id) {
        return $this->app['form.factory']
            ->createBuilder(new ArticleType(), $data, array(
                'action' => $this->app['url_generator']->generate('article_update', array('id' => $id)),
                'method' => 'POST'
            ))
            ->add('submit', 'submit', array('label' => 'Update Article'))
            ->getForm()
        ;
    }

    private function deleteArticleForm($id) {
        return $this->app['form.factory']
            ->createBuilder('form', null, array(
                'action' => $this->app['url_generator']->generate('article_delete', array('id' => $id)),
                'method' => 'DELETE'
            ))
            ->add('submit', 'submit', array('label' => 'Delete Article'))
            ->getForm()
        ;
    }

    // private function allowFields($arr, $allow_fields) {
    //     return array_filter($arr, function($k) use ($allow_fields) {
    //         if ( in_array($k, $allow_fields) ) {
    //             return true;
    //         }
    //     }, ARRAY_FILTER_USE_KEY);
    // }
}
