<?php

namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var string
     *
     * @ORM\Column(name="companyId", type="string",nullable=true)
     */
    protected $companyId;
    /**
     * @var string
     *
     * @ORM\Column(name="mobile", type="string",nullable=true)
     */
    protected $mobile;
    /**
     * @var string
     *
     * @ORM\Column(name="imagepath", type="string",nullable=true)
     */
    protected $imagepath;
    /**
     * @var string
     *
     * @ORM\Column(name="systemsettings", type="string",nullable=true)
     */
    protected $systemsettings;
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string",nullable=true)
     */
    protected $name;


    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * @return string
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * @param string $companyId
     */
    public function setCompanyId($companyId)
    {
        $this->companyId = $companyId;
    }

    /**
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param string $mobile
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    }

    /**
     * @return string
     */
    public function getImagepath()
    {
        return $this->imagepath;
    }

    /**
     * @param string $imagepath
     */
    public function setImagepath($imagepath)
    {
        $this->imagepath = $imagepath;
    }

    /**
     * @return string
     */
    public function getSystemsettings()
    {
        return $this->systemsettings;
    }

    /**
     * @param string $systemsettings
     */
    public function setSystemsettings($systemsettings)
    {
        $this->systemsettings = $systemsettings;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }



}

