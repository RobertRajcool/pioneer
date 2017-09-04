<?php

namespace UserBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * CompanyUsers
 *
 * @ORM\Table(name="company_users")
 * @ORM\Entity(repositoryClass="DashboardBundle\Repository\CompanyUsersRepository")
 */
class CompanyUsers
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
     * @ORM\Column(name="companyname", type="string")
     */
    private $companyname;
    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="userId", referencedColumnName="id")
     * })
     */
    private $userId;




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
     * @return string
     */
    public function getCompanyname()
    {
        return $this->companyname;
    }

    /**
     * @param string $companyname
     */
    public function setCompanyname($companyname)
    {
        $this->companyname = $companyname;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }




}

