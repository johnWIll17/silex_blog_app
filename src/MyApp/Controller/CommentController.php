<?php

namespace MyApp\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use MyApp\Controller\BaseController;
use MyApp\Form\CommentType;


class CommentController extends BaseController {

    // public function indexAction() {
    //     return "comments index";
    // }
    public function showAction($id) {
        // $article_comments = $this->app['comment.service']->getArticleComments('8');
        // dump($article_comments);
        // die;

        $comment = $this->app['comment.service']->getCommentById($id);
        dump($comment);
        die;
        return "comments show";
    }
    // public function newAction() {
    //     return "comments new";
    // }
    public function createAction(Request $request) {
        $article_id = $request->get('article_id');

        $form = $this->createCommentForm($article_id);

        $form->handleRequest($request);
        $data = array(
            "article_id" => $article_id,
            "user_id" => $this->userInfo()['id']
        );

        if ($form->isValid()) {
            $data += $form->getData();

            $this->app['comment.service']->insertToComments($data);

            //(**me**)
            //redirect back: 2 solutions
            //  1. article: saving in session (best solution)
            //  2. store info in GET request
            return $this->app->redirect($this->app['url_generator']->generate('article_show', array(

                'id' => $article_id
            )));
        }
    }

    public function editAction($id) {
        return "comments edit";
    }
    public function updateAction($id) {
        return "comments update";
    }
    public function deleteAction($id) {
        return "comments delete";
    }

    //private
    private function createCommentForm($id) {
        return $this->app['form.factory']
            ->createBuilder(new CommentType(), null, array(
                'action' => $this->app['url_generator']->generate('comment_create', array('article_id' => $id)),
                'method' => 'POST'
            ))
            ->add('submit', 'submit', array('label' => 'Add Comment'))
            ->getForm()
        ;
    }
}

