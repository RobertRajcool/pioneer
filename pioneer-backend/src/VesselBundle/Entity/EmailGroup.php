<?php

namespace VesselBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmailGroup
 *
 * @ORM\Table(name="email_group")
 * @ORM\Entity(repositoryClass="VesselBundle\Repository\EmailGroupRepository")
 */
class EmailGroup
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
     *
     * @ORM\Column(name="groupname", type="string", length=255)
     */
    private $groupname;

    /**
     * @var string
     *
     * @ORM\Column(name="companyname", type="string", length=255)
     */
    private $companyname;

    /**
     * @var int
     *
     * @ORM\Column(name="groupstatus", type="integer")
     */
    private $groupstatus;


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
     * Set groupname
     *
     * @param string $groupname
     *
     * @return EmailGroup
     */
    public function setGroupname($groupname)
    {
        $this->groupname = $groupname;

        return $this;
    }

    /**
     * Get groupname
     *
     * @return string
     */
    public function getGroupname()
    {
        return $this->groupname;
    }

    /**
     * Set companyname
     *
     * @param string $companyname
     *
     * @return EmailGroup
     */
    public function setCompanyname($companyname)
    {
        $this->companyname = $companyname;

        return $this;
    }

    /**
     * Get companyname
     *
     * @return string
     */
    public function getCompanyname()
    {
        return $this->companyname;
    }

    /**
     * Set groupstatus
     *
     * @param integer $groupstatus
     *
     * @return EmailGroup
     */
    public function setGroupstatus($groupstatus)
    {
        $this->groupstatus = $groupstatus;

        return $this;
    }

    /**
     * Get groupstatus
     *
     * @return int
     */
    public function getGroupstatus()
    {
        return $this->groupstatus;
    }
}

