<?php

/*
 * This file is part of the fa bundle.
 *
 * @copyright Copyright (c) 2017, Fiare Oy
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DataFixtures;

use App\Entity\EmailGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\EmailTemplate;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;

class LoadEmailGroupData extends Fixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * Container.
     *
     * @var ContainerInterface
     */
    private $container;

    /**
     * Sets the Container.
     *
     * @param null|ContainerInterface $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Load data fixtures with the passed entity manager.
     *
     * @param ObjectManager $em
     */
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
        $em->clear();
    }

    /**
     * Get the order of this fixture
     *
     * @return int
     */
    public function getOrder()
    {
        1000;
    }
}
