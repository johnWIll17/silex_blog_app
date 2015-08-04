<?php

namespace MyApp\Model;

use Doctrine\DBAL\Connection;

class BaseModel {

    protected $table;
    protected $con;

    public function __construct(Connection $con, $table) {
        $this->con = $con;
        $this->table = $table;
    }

    public function getConnection() {
        return $this->con;
    }

    public function getTable() {
        return $this->table;
    }
}
