<?php

namespace App\MessageHandler;

use App\Message\MoveToLogMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class MoveToLogMessageHandler implements MessageHandlerInterface
{
    public function __invoke(MoveToLogMessage $message)
    {
        $user = EntityManager()->getReference('App\Entity\EmailQueue', $message->getMailQueueId());
        EntityManager()->remove($user);
        EntityManager()->flush();
//        EntityManager()->remove($message->getMailQueueObj());
//        EntityManager()->flush();
    }
}
