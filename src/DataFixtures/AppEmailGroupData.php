<?php

namespace App\DataFixtures;

use App\Entity\EmailGroup;
use App\Entity\EmailQueue;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppEmailGroupData extends Fixture
{
    public function load(ObjectManager $em)
    {
        // Set class meta data
        $metadata = $em->getClassMetaData('App\Entity\EmailGroup');
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

        $emailGroup = new EmailGroup();
        $emailGroup->setName('User');
        $emailGroup->setStatus(1);
        $em->persist($emailGroup);

        $emailGroup = new EmailGroup();
        $emailGroup->setName('Promotion');
        $emailGroup->setStatus(1);
        $em->persist($emailGroup);

        $emailGroup = new EmailGroup();
        $emailGroup->setName('Inquery');
        $emailGroup->setStatus(1);
        $em->persist($emailGroup);

        $emailGroup = new EmailGroup();
        $emailGroup->setName('Report');
        $emailGroup->setStatus(1);
        $em->persist($emailGroup);

        $em->flush();

    }
}
