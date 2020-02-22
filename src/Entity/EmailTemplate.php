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
     * @ORM\Column(name="identifier", type="string", length=255, unique=true)
     */
    private $identifier;

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
     * @var string
     *
     * @ORM\Column(name="variable", type="text", nullable=true)
     */
    private $variable;

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

    /** @var int
     *
     * @ORM\Column(name="created_at", type="integer", length=10)
     */
    private $created_at;

    /**
     * @var int
     *
     * @ORM\Column(name="updated_at", type="integer", length=10, nullable=true)
     */
    private $updated_at;

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
     * Set identifier.
     *
     * @param string $identifier
     *
     * @return EmailTemplate
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
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
     * Set variable.
     *
     * @param string $variable
     *
     * @return EmailTemplate
     */
    public function setVariable($variable)
    {
        $this->variable = $variable;

        return $this;
    }

    /**
     * Get variable.
     *
     * @return string
     */
    public function getVariable()
    {
        return $this->variable;
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
     * Set created at.
     *
     * @param int $createdAt
     *
     * @return EmailTemplate
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get created at.
     *
     * @return int
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated at.
     *
     * @param int $updatedAt
     *
     * @return EmailTemplate
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updated at.
     *
     * @return int
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set created at value.
     *
     * @ORM\PrePersist()
     */
    public function setCreatedAtValue()
    {
        $this->created_at = time();
    }

    /**
     * Set updated at value.
     *
     * @ORM\PreUpdate()
     */
    public function setUpdatedAtValue()
    {
        $this->updated_at = time();
    }

    /**
     * @var bool
     *
     * @ORM\Column(name="has_layout", type="boolean", nullable=true)
     */
    private $has_layout;

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
}
