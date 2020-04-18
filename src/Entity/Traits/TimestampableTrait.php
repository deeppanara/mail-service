<?php
// src/Blog/AppBundle/Entity/Traits/TimestampableTrait.php

namespace App\Entity\Traits;

use App\Entity\EmailTemplate;
use App\Entity\EmailTemplate as EmailTemplateAlias;
use Doctrine\ORM\Mapping as ORM;

trait TimestampableTrait
{
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
     * Get created at.
     *
     * @return int
     */
    public function getCreatedAt()
    {
        return $this->created_at;
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
     * Set created at.
     *
     * @param int $createdAt
     *
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Set updated at.
     *
     * @param int $updatedAt
     *
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
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
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function setUpdatedAtValue()
    {
        $this->updated_at = time();
    }
}