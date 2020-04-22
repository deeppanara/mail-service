<?php

namespace App\DataFixtures;

use App\Entity\EmailTag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppEmailTagData extends Fixture
{
    public function load(ObjectManager $em)
    {
        $emailTag = new EmailTag();
        $emailTag->setCode("activation_date");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("item_id");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("item_link");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("complete_your_profile_link");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("edit_item_link");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("email");
        $emailTag->setDefaultValue("dom@dom.com");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("end_date");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("expiration_date");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("item_list_link");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("name");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("password");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("place_ads_link");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("receiver_company_name");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("sender_company_name");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("sender_email");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("sender_first_name");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("sender_last_name");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("service");
        $emailTag->setDefaultValue("DomMailer");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("site_url");
        $emailTag->setDefaultValue("dommailer.com");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("start_date");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("start_time");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("subscription_name");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("subscriptions_page");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("subTotalAmount");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("subTotalLabel");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("support_email");
        $emailTag->setDefaultValue("dommail@ddd.com");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("support_form_link");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("support_phone_number");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("text_message");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("type");
        $emailTag->setDefaultValue("for sell");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("upsell_link_with_ID_token");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("url_password_reset");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("user_name");
        $emailTag->setDefaultValue("userDom");
        $em->persist($emailTag);

        $emailTag = new EmailTag();
        $emailTag->setCode("create_date");
        $em->persist($emailTag);

        $em->flush();

    }
}
