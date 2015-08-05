<?php

namespace MyApp\Controller\Provider;

use Silex\Application;
use Silex\ControllerProviderInterface;
use MyApp\Controller\CommentController;

class Comment implements ControllerProviderInterface {

    public function connect(Application $app) {
        $comment_controller = new CommentController($app);

        $comments = $app['controllers_factory'];

        $comments->get('/', array($comment_controller, 'indexAction'))
            ->bind('comment');

        $comments->get('/new', array($comment_controller, 'newAction'))
            ->bind('comment_new');

        $comments->match('/', array($comment_controller, 'createAction'))
            ->bind('comment_create')
            ->method('post');

        $comments->get('/{id}', array($comment_controller, 'showAction'))
            ->bind('comment_show')
            ->assert('id', '\d+');

        $comments->get('/{id}/edit', array($comment_controller, 'editAction'))
            ->bind('comment_edit');

        $comments->match('/{id}', array($comment_controller, 'updateAction'))
            ->bind('comment_update')
            ->method('post|put');

        $comments->match('/{id}/delete', array($comment_controller, 'deleteAction'))
            ->bind('comment_delete')
            ->method('post|delete');

        return $comments;
    }
}
