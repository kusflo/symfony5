<?php


namespace App\MessageHandler;


use App\Message\CommentMessage;
use App\Repository\CommentRepository;
use App\SpamChecker;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CommentMessageHandler implements MessageHandlerInterface
{

    private $entityManager;
    private $commentRespository;
    private $spamChecker;

    public function __construct(EntityManagerInterface $entityManager,
                                CommentRepository $commentRepository,
                                SpamChecker $spamChecker)
    {
        $this->entityManager = $entityManager;
        $this->commentRespository = $commentRepository;
        $this->spamChecker = $spamChecker;
    }


    public function __invoke(CommentMessage $message)
    {
        $comment = $this->commentRespository->find($message->getId());
        if(!$comment){
            return;
        }

        $state = $this->spamChecker->getSpamScore($comment,$message->getContext());

        if(2 == $state || 1 == $state) {
            $comment->setState('spam');
        } else {
            $comment->setState('published');
        }

        $this->entityManager->flush();

    }


}