<?php

namespace MyApp\Test\MyApp\Model;

use MyApp\Model\BaseModel;
use MyApp\Model\ArticleModel;
use MyApp\Service\ArticleService;

class ArticleServiceTest extends \PHPUnit_Framework_TestCase {

    protected $article_service;
    protected $app;


    public function testadd() {
        $this->assertEquals(5, 5, 'skhfklsd');
    }

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
        $article = $this->article_service->getById(25);

        $this->assertEquals(
            $article['id'],
            25,
            'error kshdfk'
        );
    }

    public function testInsertToArticle() {
        $data = array(
            'user_id' => '25',
            'title' => 'test title',
            'description' => 'test description'
        );

        $article = $this->article_service->insertToArticle($data);

        $this->assertEquals(
            $article,
            1,
            'No row was addded'
        );

    }

    public function testDeleteById() {
        $this->app['article.service']->insertToArticle(array(
            'id' => '100',
            'user_id' => '25',
            'title' => 'new test insert',
            'description' => 'new description insert'
        ));

        $ret = $this->app['article.service']->deleteById(100);

        $this->assertEquals(
            $ret,
            1,
            'Delete fails'
        );
    }

    public function testUpdateToArticle() {
        $ret = $this->app['article.service']->updateToArticle(100, array(
            'title' => 'new updated title'
        ));

        $this->assertEquals(
            $ret,
            1,
            'update fails'
        );
    }


}
