<?php

/*
 * This file is part of the fa bundle.
 *
 * @copyright Copyright (c) 2017, Fiare Oy
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * EmailTemplate.
 *
 * @author Deep Panara
 *
 * @ORM\Entity(repositoryClass="App\Repository\EmailQueueRepository")
 * @ORM\Table(
 *     name="email_queue",
 * )
 * @ORM\HasLifecycleCallbacks
 */
class EmailQueue
{
     use TimestampableTrait;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="template_id", type="string", nullable=true)
     */
    private $template_id;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", nullable=true)
     */
    private $subject;

    /**
     * @var integer
     *
     * @ORM\Column(name="send_at", type="integer", length=10)
     */
    private $send_at;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_sent", type="boolean")
     */
    private $is_sent;

    /**
     * @var array
     *
     * @ORM\Column(name="mail_to", type="json")
     */
    private $mailTo;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var array
     *
     * @ORM\Column(name="cc", type="json", nullable=true)
     */
    private $cc;

    /**
     * @var array
     *
     * @ORM\Column(name="bcc", type="json", nullable=true)
     */
    private $bcc;

    /**
     * @var array
     *
     * @ORM\Column(name="mail_from", type="json", nullable=true)
     */
    private $mail_from;

    /**
     * @var array
     *
     * @ORM\Column(name="reply_to", type="json", nullable=true)
     */
    private $reply_to;

    /**
     * @var array
     *
     * @ORM\Column(name="custom_tags", type="json", nullable=true)
     */
    private $custom_tags;

    /**
     * @var array
     *
     * @ORM\Column(name="attachments", type="json", nullable=true)
     */
    private $attachments;

    /**
     * @var array
     *
     * @ORM\Column(name="headers", type="json", nullable=true)
     */
    private $headers;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return EmailQueue
     */
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return array
     */
    public function getMailTo()
    {
        return $this->mailTo;
    }

    /**
     * @param array $mailTo
     * @return EmailQueue
     */
    public function setMailTo($mailTo)
    {
        $this->mailTo = $mailTo;

        return $this;
    }

    /**
     * @return integer
     */
    public function getSendAt()
    {
        return $this->send_at;
    }

    /**
     * @param integer $send_at
     *
     * @return EmailQueue
     *
     */
    public function setSendAt($send_at)
    {
        $this->send_at = $send_at ?? time();

        return $this;
    }

    /**
     * Set created at value.
     *
     * @ORM\PrePersist()
     */
    public function setSendAtValue()
    {
        if (null == $this->send_at){
            $this->send_at = time();
        }
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     * @return EmailQueue
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return array
     */
    public function getCc()
    {
        return $this->cc;
    }

    /**
     * @param array $cc
     * @return EmailQueue
     */
    public function setCc($cc)
    {
        $this->cc = $cc;

        return $this;
    }

    /**
     * @return array
     */
    public function getBcc()
    {
        return $this->bcc;
    }

    /**
     * @param array $bcc
     * @return EmailQueue
     */
    public function setBcc($bcc)
    {
        $this->bcc = $bcc;

        return $this;
    }

    /**
     * @return array
     */
    public function getMailFrom()
    {
        return $this->mail_from;
    }

    /**
     * @param array $from
     * @return EmailQueue
     */
    public function setMailFrom($from)
    {
        $this->mail_from = $from;

        return $this;
    }

    /**
     * @return array
     */
    public function getReplyTo()
    {
        return $this->reply_to;
    }

    /**
     * @param array $reply_to
     * @return EmailQueue
     */
    public function setReplyTo($reply_to)
    {
        $this->reply_to = $reply_to;

        return $this;
    }

    /**
     * @return array
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * @param array $attachments
     * @return EmailQueue
     */
    public function setAttachments($attachments)
    {
        $this->attachments = $attachments;

        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     * @return EmailQueue
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @return array
     */
    public function getCustomTags()
    {
        return $this->custom_tags;
    }

    /**
     * @param array $custom_tags
     * @return EmailQueue
     */
    public function setCustomTags($custom_tags)
    {
        $this->custom_tags = $custom_tags;

        return $this;
    }

    /**
     * @return string
     */
    public function getTemplateId()
    {
        return $this->template_id;
    }

    /**
     * @param string $template_id
     * @return EmailQueue
     */
    public function setTemplateId($template_id)
    {
        $this->template_id = $template_id;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSent()
    {
        return $this->is_sent;
    }

    /**
     * @param bool $is_sent
     * @return EmailQueue
     */
    public function setIsSent($is_sent)
    {
        $this->is_sent = $is_sent;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return EmailQueue
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }



}
