<?php


namespace MyApp\Test\MyApp\Controller;

use Silex\WebTestCase;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class ArticleControllerTest extends BaseControllerTest {

    protected $article_service;
    protected $comment_service;


    public function __construct() {
        parent::__construct();
        $this->simulate_login();
        $this->article_service = $this->app['article.service'];
        $this->comment_service = $this->app['comment.service'];
    }

    public function setUp() {

        $article = $this->article_service->getById(100);
        if (! count($article) ) {
            $this->article_service->insertToArticle(array(
                'id' => '100',
                'user_id' => '3',
                'title' => 'test article 100',
                'description' => 'test description 100'
            ));
        }

        $comments = $this->comment_service->getArticleComments(100);
        if (! count($comments) ) {
            $this->comment_service->insertToComments(array(
                'id' => '100',
                'user_id' => '3',
                'article_id' => '100',
                'comment' => 'test comment 1'
            ));
            $this->comment_service->insertToComments(array(
                'id' => '101',
                'user_id' => '3',
                'article_id' => '100',
                'comment' => 'test comment 2'
            ));
            $this->comment_service->insertToComments(array(
                'id' => '102',
                'user_id' => '3',
                'article_id' => '100',
                'comment' => 'test comment 3'
            ));
        }
    }

    //article index page
    public function testArticleIndexStatus() {
        $crawler = $this->client->request('GET', '/articles');

        $this->assertTrue(
            $this->client->getResponse()->isOk(),
            'INDEX: Request to homepage is NOT SUCCESS'
        );
    }

    public function testArticleIndexText() {
        $crawler = $this->client->request('GET', '/articles');

        $this->assertCount(
            1,
            $crawler->filter("a:contains('New Article')"),
            'INDEX: Not having new article button'
        );
    }

    public function testArticleIndexHasArticle() {
        $crawler = $this->client->request('GET', '/articles');

        $this->assertCount(
            1,
            $crawler->filter('a:contains("test article 100")'),
            'INDEX: Not having article was created'
        );
    }

    //new page
    public function testArticleNew() {
        $crawler = $this->client->request('GET', '/articles/new');

        $this->assertEquals(
            'Create An Article',
            $crawler->filter('.page-header > p')->text()
        );
    }

    public function testCreateValidArticle() {
        $crawler = $this->client->request('GET', '/articles/new');

        $form = $crawler->selectButton('blog_article_submit')->form();
        $form['blog_article[title]'] = 'test create article';
        $form['blog_article[description]'] = 'test description article';

        $crawler = $this->client->submit($form);

        $this->assertContains(
            "You have created an article successfully!",
            $this->client->getResponse()->getContent()
        );
    }

    public function testCreateInvalidArticle() {
        $crawler = $this->client->request('GET', '/articles/new');

        $form = $crawler->selectButton('blog_article_submit')->form();
        $form['blog_article[title]'] = '';
        $form['blog_article[description]'] = '';

        $crawler = $this->client->submit($form);

        $this->assertContains(
            "This value should not be blank",
            $this->client->getResponse()->getContent()
        );
        $this->assertCount(
            2,
            $crawler->filter('span:contains("This value should not be blank")')
        );
    }

    //edit
    public function testEditArticleStatus() {
        $crawler = $this->client->request('GET', '/articles/100/edit');

        $this->assertTrue(
            $this->client->getResponse()->isOk()
        );
    }

    public function testEditArticleContent() {
        $crawler = $this->client->request('GET', '/articles/100/edit');

        $this->assertEquals(
            'Edit',
            $crawler->filter('.page-header > p')->text()
        );
    }



    //article show page
    public function testArticleShowStatus() {
        $crawler = $this->client->request('GET', '/articles/100');

        $this->assertTrue(
            $this->client->getResponse()->isOk(),
            'SHOW: Request to article show page fails'
        );
    }

    public function testArticleShowText() {
        $crawler = $this->client->request('GET', '/articles/100');

        $this->assertCount(
            1,
            $crawler->filter('a:contains("Edit Article")'),
            'SHOW: Not having edit article link'
        );
    }

    public function testArticleShowDeleteButton() {
        $crawler = $this->client->request('GET', '/articles/100');

        $this->assertCount(
            1,
            $crawler->filter('button:contains("Delete Article")'),
            'SHOW: Not having delete article button'
        );
    }

    public function testArticleShowCommentForm() {
        $crawler = $this->client->request('GET', '/articles/100');

        $this->assertCount(
            1,
            $crawler->filter('form[name="blog_comment"]'),
            'SHOW: Not having blog commnt form'
        );
    }

    public function testArticleShowAddComment() {
        $crawler = $this->client->request('GET', '/articles/100');

        $this->assertCount(
            1,
            $crawler->filter('button:contains("Add Comment")'),
            'SHOW: Not having add comment button'
        );
    }

    // public function testArticleShowCommentsCount() {
    //     $crawler = $this->client->request('GET', '/articles/100');
    //
    //     $this->assertCount(
    //         3,
    //         $crawler->filter('blockquote > p'),
    //         'SHOW: Not having full comments of an article'
    //     );
    // }

    public function testArticleShowComment1() {
        $crawler = $this->client->request('GET', '/articles/100');

        $this->assertEquals(
            'test comment 1',
            $crawler->filter('blockquote > p')->first()->text(),
            'SHOW: Not having right comment 1'
        );
    }

    public function testCreateComment() {
        $crawler = $this->client->request('GET', '/articles/100');
        $comment_form = $crawler->selectButton('blog_comment_submit')->form();
        $comment_form['blog_comment[comment]'] = 'testing comment';
        $crawler = $this->client->submit($comment_form);

        $this->assertEquals(
            'testing comment',
            $crawler->filter('blockquote > p')->last()->text(),
            'SHOW: Create comment fails'
        );
    }

}
