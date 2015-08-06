<?php

namespace MyApp\Service;

use MyApp\Model\UserModel;

class UserService {

    protected $user_model;

    public function __construct(UserModel $user_model) {
        $this->user_model = $user_model;
    }

    public function findUser($data, $columns = '*') {
        $query = $this->user_model
            ->getConnection()
            ->createQueryBuilder()
            ->select($columns)
            ->from($this->user_model->getTable())
            ->where('email = ? AND password = ?')
        ;

        return $this->user_model->getConnection()->executeQuery($query, array(
            $data['email'], $data['password']
        ))->fetchAll();
    }
}
