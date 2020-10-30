<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Comment;
use App\Entity\Conference;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class AppFixtures extends Fixture
{
    private $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory )
    {
        $this->encoderFactory = $encoderFactory;
    }

    public function load(ObjectManager $manager)
    {
        $amsterdam = new Conference();
        $amsterdam->setCity('Amsterdam');
        $amsterdam->setYear('2019');
        $amsterdam->setIsInternational(true);
        $manager->persist($amsterdam);

        $this->generateComments($amsterdam, $manager);


        $paris = new Conference();
        $paris->setCity('Paris');
        $paris->setYear('2020');
        $paris->setIsInternational(true);
        $manager->persist($paris);

        $this->generateComments($paris, $manager);


        $admin = new Admin();
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setUsername('admin');
        $admin->setPassword($this->encoderFactory->getEncoder(Admin::class)->encodePassword('admin', null));
        $manager->persist($admin);

        $manager->flush();
    }

    /**
     * @param Conference $amsterdam
     * @param ObjectManager $manager
     */
    private function generateComments(Conference $amsterdam, ObjectManager $manager): void
    {
        $comment1 = new Comment();
        $comment1->setConference($amsterdam);
        $comment1->setAuthor('Marcos');
        $comment1->setEmail('marcos@gmail.com');
        $comment1->setText('Comentario de Marcos.');
        $comment1->setState('published');
        $manager->persist($comment1);

        $comment1 = new Comment();
        $comment1->setConference($amsterdam);
        $comment1->setAuthor('Javier');
        $comment1->setEmail('javier@gmail.com');
        $comment1->setText('Comentario de Javier.');
        $comment1->setState('published');
        $manager->persist($comment1);

        $comment1 = new Comment();
        $comment1->setConference($amsterdam);
        $comment1->setAuthor('Ana');
        $comment1->setEmail('ana@gmail.com');
        $comment1->setText('Comentario de Ana.');
        $comment1->setState('published');
        $manager->persist($comment1);

        $comment1 = new Comment();
        $comment1->setConference($amsterdam);
        $comment1->setAuthor('Maria');
        $comment1->setEmail('maria@gmail.com');
        $comment1->setText('Comentario de Maria.');
        $comment1->setState('published');
        $manager->persist($comment1);
    }
}
