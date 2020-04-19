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
 * @ORM\Entity(repositoryClass="App\Repository\EmailTagRepository")
 * @ORM\Table(
 *     name="email_tag",
 * )
 * @ORM\HasLifecycleCallbacks
 */
class EmailTag
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
     * @ORM\Column(name="code", type="string", length=255)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="default_value", type="string", length=255, nullable=true)
     */
    private $default_value;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $decreption;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\EmailTemplate", mappedBy="tags")
     */
    private $email_template;

    /**
     * Construct.
     */
    public function __construct()
    {
        $this->email_template = new ArrayCollection();
    }

    /**
     * Set id.
     *
     * @param int $id
     *
     * @return EmailTag
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
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultValue()
    {
        return $this->default_value;
    }

    /**
     * @param string $default_value
     */
    public function setDefaultValue($default_value)
    {
        $this->default_value = $default_value;

        return $this;
    }

    /**
     * @return string
     */
    public function getDecreption()
    {
        return $this->decreption;
    }

    /**
     * @param string $decreption
     */
    public function setDecreption($decreption)
    {
        $this->decreption = $decreption;

        return $this;
    }

    /**
     * @return Collection|EmailTemplate[]
     */
    public function getEmailTemplate(): Collection
    {
        return $this->email_template;
    }
    public function addEmailTemplate(EmailTemplate $email_template): self
    {
        if (!$this->email_template->contains($email_template)) {
            $this->email_template[] = $email_template;
            $email_template->addTag($this);
        }
        return $this;
    }
    public function removeEmailTemplate(EmailTemplate $email_template): self
    {
        if ($this->email_template->contains($email_template)) {
            $this->email_template->removeElement($email_template);
            $email_template->removeTag($this);
        }
        return $this;
    }

}
