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
 * @ORM\Entity(repositoryClass="App\Repository\EmailTemplateRepository")
 * @ORM\Table(
 *     name="email_template",
 *     indexes={
 *      @ORM\Index(name="fa_email_template_name_index", columns={"name"}),
 *      @ORM\Index(name="fa_email_template_subject_index", columns={"subject"})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks
 */
class EmailTemplate
{
    use TimestampableTrait;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="identifier", type="string", length=255, unique=true, nullable=true))
     */
    private $identifier;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EmailGroup" )
     */
    private $email_group;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=500)
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="body_html", type="text")
     */
    private $body_html;

    /**
     * @var string
     *
     * @ORM\Column(name="body_text", type="text", nullable=true)
     */
    private $body_text;

    /**
     * @var array
     *
     * @ORM\Column(name="custom_tags", type="json", nullable=true)
     */
    private $custom_tags;

    /**
     * @var string
     *
     * @ORM\Column(name="sender_email", type="string", length=255)
     */
    private $sender_email;

    /**
     * @var string
     *
     * @ORM\Column(name="sender_name", type="string", length=50)
     */
    private $sender_name;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="smallint", nullable=true, options={"default" = 1})
     */
    private $status;

    /**
     * @var bool
     *
     * @ORM\Column(name="has_layout", type="boolean", nullable=true)
     */
    private $has_layout;

    /**
     * Construct.
     */
    public function __construct()
    {

    }

    /**
     * Set id.
     *
     * @param int $id
     *
     * @return EmailTemplate
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set identifier value.
     *
     * @ORM\PrePersist()
     */
    public function setIdentifierValue()
    {
        $this->identifier = strtoupper(bin2hex(random_bytes(8)));
    }

    /**
     * Get identifier.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return EmailTemplate
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set subject.
     *
     * @param string $subject
     *
     * @return EmailTemplate
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject.
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set body html.
     *
     * @param string $bodyHtml
     *
     * @return EmailTemplate
     */
    public function setBodyHtml($bodyHtml)
    {
        $this->body_html = $bodyHtml;

        return $this;
    }

    /**
     * Get body html.
     *
     * @return string
     */
    public function getBodyHtml()
    {
        return $this->body_html;
    }

    /**
     * Set body text.
     *
     * @param string $bodyText
     *
     * @return EmailTemplate
     */
    public function setBodyText($bodyText)
    {
        $this->body_text = $bodyText;

        return $this;
    }

    /**
     * Get body text.
     *
     * @return string
     */
    public function getBodyText()
    {
        return $this->body_text;
    }

    /**
     * Set sender email.
     *
     * @param string $senderEmail
     *
     * @return EmailTemplate
     */
    public function setSenderEmail($senderEmail)
    {
        $this->sender_email = $senderEmail;

        return $this;
    }

    /**
     * Get sender email.
     *
     * @return string
     */
    public function getSenderEmail()
    {
        return $this->sender_email;
    }

    /**
     * Set sender name.
     *
     * @param string $senderName
     *
     * @return EmailTemplate
     */
    public function setSenderName($senderName)
    {
        $this->sender_name = $senderName;

        return $this;
    }

    /**
     * Get sender name.
     *
     * @return string
     */
    public function getSenderName()
    {
        return $this->sender_name;
    }

    /**
     * Set status.
     *
     * @param bool $status
     *
     * @return EmailTemplate
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get has layout.
     *
     * @return string
     */
    public function getHasLayout()
    {
        return $this->has_layout;
    }

    /**
     * Sets has layout.
     *
     * @param string $value
     *
     * @return string
     */
    public function setHasLayout($value)
    {
        $this->has_layout = $value;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmailGroup() : ?EmailGroup
    {
        return $this->email_group;
    }

    /**
     * @param mixed $email_group
     */
    public function setEmailGroup(?EmailGroup $email_group)
    {
        $this->email_group = $email_group;
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
     * @return EmailTemplate
     */
    public function setCustomTags($custom_tags)
    {
        $this->custom_tags = $custom_tags;

        return $this;
    }

}
