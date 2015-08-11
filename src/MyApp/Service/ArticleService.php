<?php

namespace MyApp\Service;

use MyApp\Model\ArticleModel;

class ArticleService {

    const PER_PAGE = 5;

    protected $article_model;

    public function __construct(ArticleModel $article_model) {
        $this->article_model = $article_model;
    }

    public function getAll($user_id, $columns = '*') {
        $query = $this->article_model
            ->getConnection()
            ->createQueryBuilder()
            ->select($columns)
            ->from('users', 'u')
            ->innerJoin('u', 'articles', 'a', 'u.id = a.user_id')
            ->where('u.id = ?')
            //->from($this->article_model->getTable())
        ;

        return $this->article_model->getConnection()->executeQuery($query, array($user_id))->fetchAll();
    }

    public function getById($id, $columns = '*') {
        $query = $this->article_model
            ->getConnection()
            ->createQueryBuilder()
            ->select($columns)
            ->from($this->article_model->getTable())
            ->where('id = ?')
        ;

        //return $this->article_model->getConnection()->executeQuery($query, array($id))->fetchAll()[0];
        $ret = $this->article_model->getConnection()->executeQuery($query, array($id))->fetchAll();

        if (count($ret) === 1) {
            return $ret[0];
        } else {
            return $ret;
        }
    }

    public function deleteById($id) {
        $query = $this->article_model
            ->getConnection()
            ->createQueryBuilder()
            ->delete($this->article_model->getTable())
            ->where('id = ' . $id)
        ;

        return $this->article_model->getConnection()->executeUpdate($query);
        //return true/false
    }

    public function insertToArticle($options) {
        $query = $this->article_model
            ->getConnection()
            ->createQueryBuilder()
            ->insert($this->article_model->getTable())
            ->values($this->quoteValues($options))
        ;

        return $this->article_model->getConnection()->executeUpdate($query);
    }

    public function updateToArticle($id, $data = '') {
        return $this->article_model
            ->getConnection()
            ->update($this->article_model->getTable(), $data, array("id" => $id))
        ;
        // $this->article_model->getConnection()->executeUpdate($query);
    }


    public function paginate($user_id, $page = 1, $columns = '*') {
        $start_offset = ($page - 1) * self::PER_PAGE;

        $query = $this->article_model
            ->getConnection()
            ->createQueryBuilder()
            ->select($columns)
            // ->from($this->article_model->getTable())
            // ->setFirstResult($start_offset)
            // ->setMaxResults(self::PER_PAGE)
            ->from('users', 'u')
            ->innerJoin('u', 'articles', 'a', 'u.id = a.user_id')
            ->where('u.id = ?')
            ->setFirstResult($start_offset)
            ->setMaxResults(self::PER_PAGE)

        ;

        return $this->article_model->getConnection()->executeQuery($query, array($user_id))->fetchAll();
    }

    public function totalPageArticle($user_id) {
        $total_articles = count($this->getAll($user_id));

        return ceil($total_articles / self::PER_PAGE);
    }

    //private
    private function quoteValues(array $options) {
        return array_map(function($val) {
            return $this->article_model->getConnection()->quote($val);
        }, $options);
    }
}
