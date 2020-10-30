<?php


namespace App\Tests\Controller;


use App\Entity\Comment;
use App\Entity\Conference;
use App\Repository\CommentRepository;
use App\Repository\ConferenceRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ConferenceControllerTest extends WebTestCase
{

    public function testIndex()
    {

        $client = static::createClient();

        $client->request('GET','/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2','Give me you feedback!');
    }

    public function testCommentSubmission()
    {
        $client = static::createClient();
        $client->request('GET','/conference/amsterdam-2019');
        $client->submitForm('Submit',[
            'comment_form[author]' => 'Jose',
            'comment_form[text]' => 'Prueba unitaria de creación de comentario',
            'comment_form[email]' => $email = 'jose@gmail.com',
            'comment_form[photo]' => dirname(__DIR__, 2).'/public/images/under-construction.gif',
        ]);
        $this->assertResponseRedirects();

        //simule comment validation

        /** @var Comment $comment */
        $comment = self::$container->get(CommentRepository::class)->findOneByEmail($email);
        $comment->setState('published');
        $entityManager = self::$container->get(EntityManagerInterface::class);
        $entityManager->persist($comment);
        $entityManager->flush();

        $client->followRedirect();
        $this->assertSelectorExists('div:contains("There are 5 comments")');

    }

    public function testConferencePage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertCount(2, $crawler->filter('h4'));

        $client->clickLink('View');

        $this->assertPageTitleContains('Amsterdam');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Amsterdam 2019');
        $this->assertSelectorExists('div:contains("There are 4 comments")');
    }

}