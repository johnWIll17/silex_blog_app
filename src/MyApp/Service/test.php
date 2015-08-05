<?php

namespace Resources\Service;

use Resources\Model\UserModel;

class UserService {

    const PER_PAGE = 5;

    protected $user_model;

    public function __construct(UserModel $user_model) {
        $this->user_model = $user_model;
    }

    public function getAll($columns = '*') {
        $query = $this->user_model
            ->getConnection()
            ->createQueryBuilder()
            ->select($columns)
            ->from($this->user_model->getTable())
        ;
        return $this->user_model->getConnection()->executeQuery($query)->fetchAll();
    }

    public function getById($id, $columns = '*') {
        $query = $this->user_model
            ->getConnection()
            ->createQueryBuilder()
            ->select($columns)
            ->from($this->user_model->getTable())
            ->where('id = ?')
        ;
        return $this->user_model->getConnection()->executeQuery($query, array($id))->fetchAll();
    }

    public function deleteById($id) {
        $query = $this->article_model
            ->getConnection()
            ->createQueryBuilder()
            ->delete($this->user_model->getTable())
            ->where('id = ?')
        ;
    }

    public function paginate() {
        $total_articles = count($this->getAll());

        return ceil($total_articles / self::PER_PAGE);
    }

    public function pageNum($page = 1, $columns = '*') {
        $start_offset = ($page - 1) * self::PER_PAGE;

        $query = $this->user_model
            ->getConnection()
            ->createQueryBuilder()
            ->select($columns)
            ->from($this->user_model->getTable())
            //->setFirstResult( $start_offset ? $start_offset + 1 : $start_offset )
            ->setFirstResult( $start_offset )
            ->setMaxResults(self::PER_PAGE)
        ;
        return $this->user_model->getConnection()->executeQuery($query)->fetchAll();
    }

    //deleteById
    //insert
    //updateById
    //getSpecificCondition
    //getByColumns
    //deleteByColumns
    //deleteAllData
    //quotes
}

