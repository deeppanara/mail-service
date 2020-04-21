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
use Doctrine\ORM\Mapping as ORM;

/**
 * EmailTemplate.
 *
 * @author Deep Panara
 *
 * @ORM\Entity(repositoryClass="App\Repository\EmailTemplateRepository")
 * @ORM\Table(
 *     name="email_group",
 * )
 * @ORM\HasLifecycleCallbacks
 */
class EmailGroup
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="smallint", options={"default" = 1})
     */
    private $status;

    /**
     * Construct.
     */
    public function __construct()
    {

    }

    public function __toString()
    {
        return $this->name;
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


}
