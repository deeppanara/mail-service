<?php

namespace App\Manager;

use App\Repository\EmailTemplateRepository;
use http\Exception\RuntimeException;
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
     * @var EmailTemplateRepository
     */
    protected $emailTemplateRepository;

    /**
     * Constructor.
     *
     * @param object $mailer
     * @param object $em
     * @param object $container
     */
    public function __construct(\Swift_Mailer $mailer, ContainerInterface $container, EmailTemplateRepository $emailTemplateRepository)
    {
        $this->mailer = $mailer;
        $this->container = $container;
        $this->emailTemplateRepository = $emailTemplateRepository;
        $this->em = $this->container->get('doctrine')->getManager();

        //$this->historyEntityManager = $this->container->get('doctrine')->getManager('history');
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
     * Send mail.
     */
    public function init()
    {
        $this->message  = (new \Swift_Message('Hello Email'))
            ->setFrom('send@example.com');
    }

    /**
     * Send mail.
     */
    public function send()
    {
        if ($this->getMessage()) {
            $this->getMailer()->send($this->getMessage());
            $this->message = null;
        } else {
            throw new \RuntimeException("Swift_Message is set properly Or already used.");
        }

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

//    /**
//     * Render mail.
//     *
//     * @param string $emailIdentifier
//     * @param string $mailVars
//     * @param string $locale
//     * @param string $to
//     *
//     * @throws Exception
//     */
//    public function render($emailIdentifier, $mailVars = [])
//    {
//        $emailTemplateLayoutHtml = '';
//        $emailTemplate = $this->getEmailTemplate($emailIdentifier);
//
//        if (!$this->getMessage()->getFrom()) {
//            $this->setFrom($emailTemplate->getSenderEmail(), $emailTemplate->getSenderName());
//        }
//        $emailTemplateLayoutHtml = $emailTemplate->getBodyHtml();
//
//        $subject = $this->renderTwig($emailTemplate->getSubject(), $mailVars);
//        $body = $this->renderTwig($emailTemplateLayoutHtml, $mailVars);
//
//        $this->setSubject($subject);
//        $this->setBody($body);
//
//    }
//
//
//
//    /**
//     * Get email template.
//     *
//     * @param string $emailIdentifier
//     * @param string $locale
//     *
//     * @throws \Exception
//     * @throws Exception
//     *
//     * @return string
//     */
//    public function getEmailTemplate($emailIdentifier)
//    {
//        $emailTemplate = $this->emailTemplateRepository->findOneByIdentifier($emailIdentifier);
//
//        if (!$emailTemplate) {
//            throw new \Exception('Email template not found');
//        }
//
//        return $emailTemplate;
//
//    }
}