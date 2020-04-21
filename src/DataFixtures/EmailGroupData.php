<?php

namespace App\DataFixtures;

use App\Entity\EmailGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EmailGroupData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $emailGroup = new EmailGroup();
        $emailGroup->setName('User');
        $emailGroup->setStatus(1);
        $manager->persist($emailGroup);

        $emailGroup = new EmailGroup();
        $emailGroup->setName('Promotion');
        $emailGroup->setStatus(1);
        $manager->persist($emailGroup);

        $emailGroup = new EmailGroup();
        $emailGroup->setName('Inquery');
        $emailGroup->setStatus(1);
        $manager->persist($emailGroup);

        $emailGroup = new EmailGroup();
        $emailGroup->setName('Report');
        $emailGroup->setStatus(1);
        $manager->persist($emailGroup);

        $manager->flush();
        $manager->clear();
    }
}
