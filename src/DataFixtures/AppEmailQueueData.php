<?php

namespace App\DataFixtures;

use App\Entity\EmailQueue;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppEmailQueueData extends Fixture
{
    public function load(ObjectManager $em)
    {
        $emailQueue = new EmailQueue();
        $emailQueue->setSendAt(158759999);
//        $emailQueue->isSent(0);
        $emailQueue->setContent("test");
        $emailQueue->setMailTo([
            [
                'email' => "ddd@ddd1.com",
                'name' => "ssss"
            ],
            [
                'email' => "ddd@d222.com",
                'name' => "ggggg"
            ]
        ]);
        $emailQueue->setIsSent(9);
        $emailQueue->setContent("gggggggggg");
        $emailQueue->setSendAt(158759999);
        $em->persist($emailQueue);


        $em->flush();

    }
}
