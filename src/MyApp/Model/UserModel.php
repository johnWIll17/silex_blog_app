<?php

namespace MyApp\Model;

use Doctrine\DBAL\Connection;
use MyApp\Model\BaseModel;

class UserModel extends BaseModel {

    public function __construct(Connection $con) {
        parent::__construct($con, 'users');
    }
}

