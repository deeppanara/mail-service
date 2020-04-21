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

use App\Repository\EmailGroupRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\EmailTemplate;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;

class LoadEmailTemplateData extends Fixture implements ContainerAwareInterface, DependentFixtureInterface
{
    /**
     * Container.
     *
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var EmailGroupRepository
     */
    private $emailGroupRepository;

    public function __construct(EmailGroupRepository $emailGroupRepository)
    {
        $this->emailGroupRepository = $emailGroupRepository;
    }

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
        $metadata = $em->getClassMetaData('App\Entity\EmailTemplate');
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

        $emilGroups = $this->emailGroupRepository->findAll();

        $bodyHtml = <<<EOD
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Title</title>
        
    </head>

    <body>
        {{ email_body|raw }}
    </body>
</html>
EOD;

        $slugger = new AsciiSlugger();
        $slug = $slugger->slug('Email Template Layout');

        $emailtemplate = new EmailTemplate();
        $emailtemplate->setIdentifier($slug);
//        $emailtemplate->setEmailGroup($emilGroups[array_rand($emilGroups)]);
        $emailtemplate->setName('Email Template Layout');
        $emailtemplate->setSubject('Email Template Layout');
        $emailtemplate->setBodyHtml($bodyHtml);
        $emailtemplate->setBodyText('{{ email_body }}');
        $emailtemplate->setSenderEmail("test@test.com");
        $emailtemplate->setSenderName("test");
        $emailtemplate->setStatus(1);

        $em->persist($emailtemplate);
        $em->flush();
        $em->clear();


        $bodyHtml = <<<EOD
<div>
    registration mail
</div>
EOD;

        // set email template
        $slugger = new AsciiSlugger();
        $slug = $slugger->slug('Email Registration');

        $emailtemplate = new EmailTemplate();
        $emailtemplate->setIdentifier($slug);
//        $emailtemplate->setEmailGroup($emilGroups[array_rand($emilGroups)]);
        $emailtemplate->setName('registration email');
        $emailtemplate->setSubject('registration');
        $emailtemplate->setBodyHtml($bodyHtml);
        $emailtemplate->setSenderEmail("test@test.com");
        $emailtemplate->setSenderName("test");
        $emailtemplate->setStatus(1);

        $em->persist($emailtemplate);
        $em->flush();
        $em->clear();

        $bodyHtml = <<<EOD
<div>
    reset your password here
</div>
EOD;

        // set email template
        $slugger = new AsciiSlugger();
        $slug = $slugger->slug('Email reset password');

        $emailtemplate = new EmailTemplate();
        $emailtemplate->setIdentifier($slug);
//        $emailtemplate->setEmailGroup($emilGroups[array_rand($emilGroups)]);
        $emailtemplate->setName('Email reset password');
        $emailtemplate->setSubject('reset your password here');
        $emailtemplate->setBodyHtml($bodyHtml);
        $emailtemplate->setSenderEmail("test@test.com");
        $emailtemplate->setSenderName("test");
        $emailtemplate->setStatus(1);

        $em->persist($emailtemplate);
        $em->flush();
        $em->clear();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [
            EmailGroupData::class
        ];
    }
}
