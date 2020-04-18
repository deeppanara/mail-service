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

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\EmailTemplate;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;

class LoadEmailTemplateData extends Fixture implements ContainerAwareInterface
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
     * @param Doctrine\Common\Persistence\ObjectManager $em
     */
    public function load(ObjectManager $em)
    {
//        $senderEmailS = $this->container->getParameter('mailer_sender_email');
//        $senderNameS = $this->container->getParameter('mailer_sender_name');


        // Set class meta data
        $metadata = $em->getClassMetaData('App\Entity\EmailTemplate');
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

        $id = 1;

        // Load enabled locale
//        $localeEnabled = $this->container->getParameter('locale_enabled');
//        $defaultLocale = $this->container->getParameter('locale');

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

        // set email template
        $variableArray = ['{{ site_url }}', '{{ service }}', '{{ email_body|raw }}'];
        $slugger = new AsciiSlugger();
        $slug = $slugger->slug('Email Template Layout');

        $emailtemplate = new EmailTemplate();
        $emailtemplate->setIdentifier($slug);
        $emailtemplate->setName('Email Template Layout');
        $emailtemplate->setSubject('Email Template Layout');
        $emailtemplate->setBodyHtml($bodyHtml);
        $emailtemplate->setBodyText('{{ email_body }}');
        $emailtemplate->setVariable(serialize($variableArray));
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
        $variableArray = ['{{ site_url }}', '{{ service }}', '{{ email_body|raw }}'];
        $slugger = new AsciiSlugger();
        $slug = $slugger->slug('Email Registration');

        $emailtemplate = new EmailTemplate();
        $emailtemplate->setIdentifier($slug);
        $emailtemplate->setName('registration email');
        $emailtemplate->setSubject('registration');
        $emailtemplate->setBodyHtml($bodyHtml);
        $emailtemplate->setVariable(serialize($variableArray));
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
        $variableArray = ['{{ site_url }}', '{{ service }}', '{{ email_body|raw }}'];
        $slugger = new AsciiSlugger();
        $slug = $slugger->slug('Email reset password');

        $emailtemplate = new EmailTemplate();
        $emailtemplate->setIdentifier($slug);
        $emailtemplate->setName('Email reset password');
        $emailtemplate->setSubject('reset your password here');
        $emailtemplate->setBodyHtml($bodyHtml);
        $emailtemplate->setVariable(serialize($variableArray));
        $emailtemplate->setSenderEmail("test@test.com");
        $emailtemplate->setSenderName("test");
        $emailtemplate->setStatus(1);

        $em->persist($emailtemplate);
        $em->flush();
        $em->clear();
//        // check whether file is present
//        $path = UF::get('Fads', $this->container)::getFixtureFile('src\\DataFixtures\\EmailTemplate\\', 'emailTemplate.csv', __DIR__, 'EmailTemplate');
//
//        if (false !== ($reader = new \EasyCSV\Reader($path))) {
//            $reader->setDelimiter(';');
//            while ($row = $reader->getRow()) {
//                $variableArray = isset($row['variables']) ? explode(',', $row['variables']) : [];
//                $slugger = new AsciiSlugger();
//                $slug = $slugger->slug($row['subject']);
//
//
//                $emailtemplate = new EmailTemplate();
//                $emailtemplate->setIdentifier($slug);
//                $emailtemplate->setName($row['name']);
//                $emailtemplate->setSubject($row['subject']);
//                $emailtemplate->setVariable(serialize($variableArray));
//                $htmlFilePathDefault = UF::get('Fads', $this->container)::getFixtureFile('src\\DataFixtures\\EmailTemplate\\', 'en/html/'.$row['html_file_name'], __DIR__, 'EmailTemplate');
//                $emailtemplate->setBodyHtml(file_get_contents($htmlFilePathDefault));
//                $textFilePathDefault = UF::get('Fads', $this->container)::getFixtureFile('src\\DataFixtures\\EmailTemplate\\', 'en/text/'.$row['text_file_name'], __DIR__, 'EmailTemplate');
//                $emailtemplate->setBodyText(file_get_contents($textFilePathDefault));
//                $emailtemplate->setSenderEmail('test@test.com');
//                $emailtemplate->setSenderName('test');
//
//                $emailtemplate->setStatus(1);
//
//                $em->persist($emailtemplate);
//                $em->flush();
//                $em->clear();
//                ++$id;
//            }
//        }
    }
}
