<?php


namespace App\Tests\Controller;


use App\Entity\Conference;
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
        $client->request('GET','/conference/amsterdam-2020');
        $client->submitForm('Submit',[
            'comment_form[author]' => 'Jose',
            'comment_form[text]' => 'Prueba unitaria de creación de comentario',
            'comment_form[email]' => 'jose@gmail.com',
            'comment_form[photo]' => dirname(__DIR__, 2).'/public/images/under-construction.gif',
        ]);
        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertSelectorExists('div:contains("There are 2 comments")');


    }

}