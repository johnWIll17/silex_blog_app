<?php

namespace MyApp\Test\MyApp\Model;

use MyApp\Model\BaseModel;
use MyApp\Model\ArticleModel;
use MyApp\Service\ArticleService;

class ArticleServiceTest extends \PHPUnit_Framework_TestCase {

    protected $article_service;
    protected $app;


    public function __construct() {
        // $config = new \Doctrine\DBAL\Configuration();
        // $conParams = array(
        //     'dbname' => 'silex_blog',
        //     'user' => 'root',
        //     'password' => '',
        //     'host' => 'localhost',
        //     'driver' => 'pdo_mysql'
        // );
        // $this->con = \Doctrine\DBAL\DriverManager::getConnection($conParams, $config);

        $this->app = require __DIR__ . '/../../../../../app/app.php';
        $this->article_service = $this->app['article.service'];
        // var_dump($this->article_service);

    }


    public function testGetById() {
        // var_dump($this->app);
        $article = $this->article_service->getById(107);

        $this->assertEquals(
            $article['id'],
            107,
            'get individual article fails'
        );
    }

    public function testInsertToArticle() {
        $data = array(
            'user_id' => '1',
            'title' => 'test title',
            'description' => 'test description'
        );

        $article = $this->article_service->insertToArticle($data);

        $this->assertEquals(
            $article,
            1,
            'Insert fails'
        );

    }

    public function testDeleteById() {
        $this->app['article.service']->insertToArticle(array(
            'id' => '200',
            'user_id' => '1',
            'title' => 'new test insert',
            'description' => 'new description insert'
        ));

        $ret = $this->app['article.service']->deleteById(200);

        $this->assertEquals(
            $ret,
            1,
            'Delete fails'
        );
    }

    public function testUpdateToArticle() {
        $this->app['article.service']->insertToArticle(array(
            'id' => '150',
            'user_id' => '1',
            'title' => 'test update',
            'description' => 'test update desc'
        ));

        $ret = $this->app['article.service']->updateToArticle(150, array(
            'title' => 'new updated title'
        ));

        $this->assertEquals(
            $ret,
            1,
            'update fails'
        );

        $this->app['article.service']->deleteById(150);
    }


}
