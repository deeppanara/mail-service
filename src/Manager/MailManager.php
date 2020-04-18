<?php

namespace App\Manager;

use Symfony\Component\DependencyInjection\ContainerInterface;


class MailManager
{
    /**
     * Mailer service class object.
     *
     * @var object
     */
    protected $mailer;

    /**
     * Entity Manager class object.
     *
     * @var object
     */
    protected $em;

    /**
     * Swift_Message class object.
     *
     * @var object
     */
    protected $message;

    /**
     * Container service class object.
     *
     * @var object
     */
    protected $container;

    /**
     * History entity manager.
     *
     * @var object
     */
    protected $historyEntityManager;

    /**
     * Constructor.
     *
     * @param object $mailer
     * @param object $em
     * @param object $container
     */
    public function __construct(\Swift_Mailer $mailer, ContainerInterface $container)
    {
        $this->mailer = $mailer;
        $this->container = $container;
        $this->em = $this->container->get('doctrine')->getManager();

        //$this->historyEntityManager = $this->container->get('doctrine')->getManager('history');
    }

    /**
     * Send mail.
     *
     * @throws Exception
     */
    public function init()
    {
        $this->message  = (new \Swift_Message('Hello Email'))
            ->setFrom('send@example.com');
    }

    /**
     * Send mail.
     *
     * @throws Exception
     */
    public function send()
    {
        $this->getMailer()->send($this->getMessage());
    }

    /**
     * Set to.
     *
     * @param string $addresses
     * @param string $name
     */
    public function setTo($addresses, $name = null)
    {
        $this->getMessage()->setTo($addresses, $name);
    }

    /**
     * Set from.
     *
     * @param string $addresses
     * @param string $name
     */
    public function setFrom($addresses, $name = null)
    {
        $this->getMessage()->setFrom($addresses, $name);
    }

    /**
     * Set cc.
     *
     * @param unknown $addresses
     * @param string  $name
     */
    public function setCc($addresses, $name = null)
    {
        $this->getMessage()->setCc($addresses, $name);
    }

    /**
     * Set bcc.
     *
     * @param string $addresses
     * @param string $name
     */
    public function setBcc($addresses, $name = null)
    {
        $this->getMessage()->setBcc($addresses, $name);
    }

    /**
     * Set sender.
     *
     * @param string $address
     * @param string $name
     */
    public function setSender($address, $name = null)
    {
        $this->getMessage()->setSender($address, $name);
    }

    /**
     * Set reply to.
     *
     * @param string $addresses
     * @param string $name
     */
    public function setReplyTo($addresses, $name = null)
    {
        $this->getMessage()->setReplyTo($addresses);
    }

    /**
     * Set priority.
     *
     * @param string $priority
     */
    public function setPriority($priority)
    {
        $this->getMessage()->setPriority($priority);
    }

    /**
     * Get mailer.
     *
     * @return object
     */
    public function getMailer()
    {
        return $this->mailer;
    }

    /**
     * Get message.
     *
     * @return object
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set attachment.
     *
     * @param string $attachment
     */
    public function setAttachment($attachment)
    {
        if (count($attachment)) {
            foreach ($attachment as $filename => $filepath) {
                $attachment = \Swift_Attachment::fromPath($filepath);

                if ($filename && !is_numeric($filename) && false !== strpos($filename, '.')) {
                    $attachment->setFilename($filename);
                }

                $this->getMessage()->attach($attachment);
            }
        }
    }

    /**
     * Set body.
     *
     * @param string $body
     */
    public function setBody($body)
    {
        $this->getMessage()->setBody($body, 'text/html');
    }

    /**
     * Set alternate body.
     *
     * @param string $alternateBody
     */
    public function setAlternateBody($alternateBody = null)
    {
        $this->getMessage()->addPart($alternateBody, 'text/plain');
    }

    /**
     * Set subject.
     *
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->getMessage()->setSubject($subject);
    }

    /**
     * Render mail.
     *
     * @param string $emailIdentifier
     * @param string $mailVars
     * @param string $locale
     * @param string $to
     *
     * @throws Exception
     */
    public function renderMail($emailIdentifier, $mailVars, $locale, $to)
    {
        try {
            //set layout parameters
            $mailVars['service'] = $this->container->getParameter('fa.service_name');
            $mailVars['admin_site_url'] = $this->container->getParameter('fa.base_url');
            $mailVars['site_title'] = $this->container->getParameter('fa.service_name');
            $mailVars['pub_id'] = $this->container->getParameter('fa.add_this.pubid');
            $mailVars['site_url'] = $this->container->getParameter('fa.front.base_url');
            $mailVars['url_post_ad'] = $this->container->get('router')->generate('item_new_without_login', [], true);
            $mailVars['url_browse_ads'] = $this->container->get('router')->generate('item_search_front', [], true);
            $mailVars['url_modal_login'] = $mailVars['site_url'].'/?ref=login_link';
            $mailVars['url_user_unsubscribe'] = $this->container->get('router')->generate('user_unsubscribe_api_front', [], true);
            $mailVars['url_account_dashboard'] = $this->container->get('router')->generate('user_dashboard_api_front', [], true);
            $mailVars['url_messages'] = $this->container->get('router')->generate('message_list_api_front', ['type' => 'inbox'], true);
            $mailVars['url_notifications'] = $this->container->get('router')->generate('notification_api_front', [], true);
            $mailVars['support_phone_number'] = $this->container->getParameter('fa.support.phone_number'); //support phone number.
            $mailVars['support_email'] = $this->container->getParameter('fa.support.email'); //support phone number.
            $mailVars['date_timestamp'] = date('d/m/Y').'T'.date('H:i:s'); //For email banner
            $mailVars['user_email'] = $to; //For email banner
            $mailVars['template_identifier'] = $emailIdentifier; //For email banner
            $cmsService = UF::get('Fads', $this->container)::getService('cms', $this->container);
            $quickLinkGroupService = UF::get('Fads', $this->container)::getService('quick_link_group', $this->container);
            $quickLinkService = UF::get('Fads', $this->container)::getService('quick_link', $this->container);

            $mailVars['static_pages'] = $cmsService->getStaticPageFooterLinks();

            $quickLinkGroupId = $quickLinkGroupService->getPageId($quickLinkService->getConstant('HOME_PAGE'), $quickLinkService->getConstant('QUICK_LINK'), $locale);
            if ($quickLinkGroupId && isset($quickLinkGroupId[0])) {
                $mailVars['quick_links'] = $quickLinkService->get($quickLinkGroupId[0]['id'], $locale, 1);
            }

            $emailTemplateLayoutHtml = '';
            $emailTemplateLayoutText = '';

            //get layout
            $emailTemplateLayout = $this->getEmailTemplate('IDE436BAA1', $locale);

            if ($emailTemplateLayout) {
                $emailTemplateLayoutHtml = $emailTemplateLayout->getBodyHtml();
                $emailTemplateLayoutText = $emailTemplateLayout->getBodyText();
            }

            $uploadToAws = $this->container->getParameter('fa.single.image.email_template_email_template_image.upload_to_aws');
            $isOriginalUpload = $this->container->getParameter('fa.single.image.email_template_email_template_image.is_original_upload');

            $emailTemplate = $this->getEmailTemplate($emailIdentifier, $locale);
            $mailVars['hero_image'] = (!empty($emailTemplate->getImage()) ? UF::get('Fads', $this->container)::getEntityImageUrl($this->container, 'single', 'email_template_email_template_image', $emailTemplate->getId(), $emailTemplate->getImage(), null, null, $uploadToAws, $isOriginalUpload, false) : null);
            $mailVars['email_body'] = $this->renderTwig($emailTemplate->getBodyHtml(), $mailVars);

            if (!$this->getMessage()->getFrom()) {
                $this->setFrom($emailTemplate->getSenderEmail(), $emailTemplate->getSenderName());
            }

            $subject = $this->renderTwig($emailTemplate->getSubject(), $mailVars);
            $body = $this->renderTwig($emailTemplateLayoutHtml, $mailVars);

            $this->setSubject($subject);
            $this->setBody("asdasdadsadas");

//            $mailVars['email_body'] = $this->renderTwig($emailTemplate->getBodyText(), $mailVars);
//            $alternateBody = $this->renderTwig($emailTemplateLayoutText, $mailVars);
//            $this->setAlternateBody($alternateBody);
        } catch (\Exception $e) {
//            UF::get('Fads', $this->container)::sendErrorMail($this->container, 'Error: Mail manager render', $e->getMessage(), $e->getTraceAsString());
        }
    }

    /**
     * Get entity manager.
     *
     * @return object
     */
    public function getEntityManager()
    {
        return $this->em;
    }

    /**
     * Get email template.
     *
     * @param string $emailIdentifier
     * @param string $locale
     *
     * @throws \Exception
     * @throws Exception
     *
     * @return string
     */
    public function getEmailTemplate($emailIdentifier, $locale = '')
    {
//        if(empty($locale))
//            $locale = $this->container->getParameter('locale');
//
//        try {
//            //$emailTemplate = $this->getEntityManager()->getRepository('App\Entity\EmailTemplate')->findOneByIdentifierAndLocale($emailIdentifier, $locale);
//            $emailTemplate = UF::get('Fads', $this->container)::getService('email_template', $this->container)->findOneByIdentifierAndLocale($emailIdentifier, $locale);
//
//            if (!$emailTemplate) {
//                throw new \Exception('Email template not found');
//            }
//
//            return $emailTemplate;
//        } catch (\Exception $e) {
//            throw $e;
//        }
    }

    /**
     * Render twig.
     *
     * @param string $text
     * @param string $vars
     *
     * @return string
     */
    public function renderTwig($text, $vars)
    {
        $loader = new \Twig_Loader_Array(['index.html' => $text]);
        $twig = new \Twig_Environment($loader);
        $twig->addExtension($this->container->get('fa.core.twig.core_extension'));

        return $twig->render('index.html', $vars);

        /*
        $loader = new \Twig_Loader_String();
        $twig   = new \Twig_Environment($loader);

        $twig->addExtension($this->container->get('fa.core.twig.core_extension'));


        $template = $twig->loadTemplate($text);

        return $template->render($vars);*/
    }
}