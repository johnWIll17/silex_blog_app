<?php

namespace MyApp\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use MyApp\Controller\BaseController;


class CommentController extends BaseController {

    public function indexAction() {
        return "comments index";
    }
    public function showAction($id) {
        return "comments show";
    }
    public function newAction() {
        return "comments new";
    }
    public function createAction() {
        return "comments create";
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
}

