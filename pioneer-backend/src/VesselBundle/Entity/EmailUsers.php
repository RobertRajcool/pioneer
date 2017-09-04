<?php

namespace VesselBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmailUsers
 *
 * @ORM\Table(name="email_users")
 * @ORM\Entity(repositoryClass="VesselBundle\Repository\EmailUsersRepository")
 */
class EmailUsers
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="VesselBundle\Entity\EmailGroup")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="groupid", referencedColumnName="id")
     * })
     */
    private $groupid;

    /**
     * @var string
     *
     * @ORM\Column(name="useremailid", type="string", length=255)
     */
    private $useremailid;

    /**
     * @return string
     */
    public function getGroupid()
    {
        return $this->groupid;
    }

    /**
     * @param string $groupid
     */
    public function setGroupid($groupid)
    {
        $this->groupid = $groupid;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set useremailid
     *
     * @param string $useremailid
     *
     * @return EmailUsers
     */
    public function setUseremailid($useremailid)
    {
        $this->useremailid = $useremailid;

        return $this;
    }

    /**
     * Get useremailid
     *
     * @return string
     */
    public function getUseremailid()
    {
        return $this->useremailid;
    }
}

