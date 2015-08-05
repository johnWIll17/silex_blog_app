<?php

namespace MyApp\Service;

use MyApp\Model\ArticleModel;
use MyApp\Model\CommentModel;

class CommentService {

    protected $comment_model;

    public function __construct(CommentModel $comment_model) {
        $this->comment_model = $comment_model;
    }

    public function getCommentById($id, $columns = '*') {
        $query = $this->comment_model
            ->getConnection()
            ->createQueryBuilder()
            ->select($columns)
            ->from($this->comment_model->getTable())
            ->where('id = ?')
        ;

        $ret = $this->comment_model->getConnection()->executeQuery($query, array($id))->fetchAll();

        if (count($ret) === 1) {
            return $ret[0];
        } else {
            return $ret;
        }
    }

    public function getArticleComments($article_id, $columns = '*') {
        $query = $this->comment_model
            ->getConnection()
            ->createQueryBuilder()
            ->select($columns)
            //->from($this->comment_model->getTable(), 'a')
            ->from('articles', 'a')
            ->innerJoin('a', 'comments', 'c', 'a.id = c.article_id')
            ->where('a.id = ?')
        ;

        return $this->comment_model->getConnection()->executeQuery($query, array($article_id))->fetchAll();
    }

    public function insertToComments($data) {
        $query = $this->comment_model
            ->getConnection()
            ->createQueryBuilder()
            ->insert($this->comment_model->getTable())
            ->values($this->quoteValues($data))
        ;

        $this->comment_model->getConnection()->executeUpdate($query);
    }

    //private
    private function quoteValues(array $options) {
        return array_map(function($val) {
            return $this->comment_model->getConnection()->quote($val);
        }, $options);
    }
}

