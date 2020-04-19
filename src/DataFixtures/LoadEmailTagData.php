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
use App\Entity\EmailTag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\EmailTemplate;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;

class LoadEmailTagData extends Fixture implements ContainerAwareInterface, OrderedFixtureInterface
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

        $emailTag = new EmailTag();
        $emailTag->setCode("{{ activation_date }}");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("{{ item_id }}");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("{{ item_link }}");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("{{ complete_your_profile_link }}");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("{{ edit_item_link }}");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("{{ email }}");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("{{ end_date }}");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("{{ expiration_date }}");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("{{ item_list_link }}");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("{{ name }}");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("{{ password }}");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("{{ place_ads_link }}");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("{{ receiver_company_name }}");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("{{ sender_company_name }}");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("{{ sender_email }}");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("{{ sender_first_name }}");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("{{ sender_last_name }}");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("{{ service }}");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("{{ site_url }}");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("{{ start_date }}");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("{{ start_time }}");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("{{ subscription_name }}");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("{{ subscriptions_page }}");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("{{ subTotalAmount }}");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("{{ subTotalLabel }}");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("{{ support_email }}");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("{{ support_form_link }}");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("{{ support_phone_number }}");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("{{ text_message }}");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("{{ type }}");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("{{ upsell_link_with_ID_token }}");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("{{ url_password_reset }}");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("{{ user_name }}");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("{{ create_date }}");
        $em->persist($emailTag);

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
        2000;
    }
}
