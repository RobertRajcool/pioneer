<?php

namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IncidentOperatorWeather
 *
 * @ORM\Table(name="incident_operator_weather")
 * @ORM\Entity(repositoryClass="DashboardBundle\Repository\IncidentOperatorWeatherRepository")
 */
class IncidentOperatorWeather
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
     * @ORM\ManyToOne(targetEntity="DashboardBundle\Entity\Incident")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="incidentId", referencedColumnName="id")
     * })
     */
    private $incidentId;
    /**
     * @var integer
     *
     * @ORM\Column(name="whether", type="integer")
     */
    private $whether;
    /**
     * @var integer
     *
     * @ORM\Column(name="water", type="integer")
     */
    private $water;
    /**
     * @var integer
     *
     * @ORM\Column(name="wind", type="integer")
     */
    private $wind;
    /**
     * @var integer
     *
     * @ORM\Column(name="windDirection", type="integer")
     */
    private $windDirection;
    /**
     * @var integer
     *
     * @ORM\Column(name="visiblity", type="integer")
     */
    private $visiblity;
    /**
     * @var integer
     *
     * @ORM\Column(name="tide", type="integer")
     */
    private $tide;
    /**
     * @var string
     *
     * @ORM\Column(name="operator_sure_name", type="string", length=255,nullable=true)
     */
    private $operator_sure_name;
    /**
     * @var string
     *
     * @ORM\Column(name="operator_given_name", type="string", length=255,nullable=true)
     */
    private $operator_given_name;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="operator_dob", type="datetime", nullable=true)
     */
    private $operator_dob;
    /**
     * @var string
     *
     * @ORM\Column(name="operator_address", type="string", length=255,nullable=true)
     */
    private $operator_address;
    /**
     * @var string
     *
     * @ORM\Column(name="operator_mobile", type="string", length=255,nullable=true)
     */
    private $operator_mobile;
    /**
     * @var string
     *
     * @ORM\Column(name="operator_landline", type="string", length=255,nullable=true)
     */
    private $operator_landline;
    /**
     * @var string
     *
     * @ORM\Column(name="operator_email", type="string", length=255,nullable=true)
     */
    private $operator_email;
    /**
     * @var string
     *
     * @ORM\Column(name="operator_LicenseType", type="string", length=255,nullable=true)
     */
    private $operator_LicenseType;
    /**
     * @var string
     *
     * @ORM\Column(name="operator_LicenseNumber", type="string", length=255,nullable=true)
     */
    private $operator_LicenseNumber;



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
     * @return int
     */
    public function getWhether()
    {
        return $this->whether;
    }

    /**
     * @param int $whether
     */
    public function setWhether($whether)
    {
        $this->whether = $whether;
    }

    /**
     * @return int
     */
    public function getWater()
    {
        return $this->water;
    }

    /**
     * @param int $water
     */
    public function setWater($water)
    {
        $this->water = $water;
    }

    /**
     * @return int
     */
    public function getWind()
    {
        return $this->wind;
    }

    /**
     * @param int $wind
     */
    public function setWind($wind)
    {
        $this->wind = $wind;
    }

    /**
     * @return int
     */
    public function getWindDirection()
    {
        return $this->windDirection;
    }

    /**
     * @param int $windDirection
     */
    public function setWindDirection($windDirection)
    {
        $this->windDirection = $windDirection;
    }

    /**
     * @return int
     */
    public function getVisiblity()
    {
        return $this->visiblity;
    }

    /**
     * @param int $visiblity
     */
    public function setVisiblity($visiblity)
    {
        $this->visiblity = $visiblity;
    }

    /**
     * @return int
     */
    public function getTide()
    {
        return $this->tide;
    }

    /**
     * @param int $tide
     */
    public function setTide($tide)
    {
        $this->tide = $tide;
    }


    /**
     * @return string
     */
    public function getOperatorSureName()
    {
        return $this->operator_sure_name;
    }

    /**
     * @param string $operator_sure_name
     */
    public function setOperatorSureName($operator_sure_name)
    {
        $this->operator_sure_name = $operator_sure_name;
    }

    /**
     * @return string
     */
    public function getOperatorGivenName()
    {
        return $this->operator_given_name;
    }

    /**
     * @param string $operator_given_name
     */
    public function setOperatorGivenName($operator_given_name)
    {
        $this->operator_given_name = $operator_given_name;
    }

    /**
     * @return \DateTime
     */
    public function getOperatorDob()
    {
        return $this->operator_dob;
    }

    /**
     * @param \DateTime $operator_dob
     */
    public function setOperatorDob($operator_dob)
    {
        $this->operator_dob = $operator_dob;
    }

    /**
     * @return string
     */
    public function getOperatorAddress()
    {
        return $this->operator_address;
    }

    /**
     * @param string $operator_address
     */
    public function setOperatorAddress($operator_address)
    {
        $this->operator_address = $operator_address;
    }

    /**
     * @return string
     */
    public function getOperatorMobile()
    {
        return $this->operator_mobile;
    }

    /**
     * @param string $operator_mobile
     */
    public function setOperatorMobile($operator_mobile)
    {
        $this->operator_mobile = $operator_mobile;
    }

    /**
     * @return string
     */
    public function getOperatorLandline()
    {
        return $this->operator_landline;
    }

    /**
     * @param string $operator_landline
     */
    public function setOperatorLandline($operator_landline)
    {
        $this->operator_landline = $operator_landline;
    }

    /**
     * @return string
     */
    public function getOperatorEmail()
    {
        return $this->operator_email;
    }

    /**
     * @param string $operator_email
     */
    public function setOperatorEmail($operator_email)
    {
        $this->operator_email = $operator_email;
    }

    /**
     * @return string
     */
    public function getOperatorLicenseType()
    {
        return $this->operator_LicenseType;
    }

    /**
     * @param string $operator_LicenseType
     */
    public function setOperatorLicenseType($operator_LicenseType)
    {
        $this->operator_LicenseType = $operator_LicenseType;
    }

    /**
     * @return string
     */
    public function getOperatorLicenseNumber()
    {
        return $this->operator_LicenseNumber;
    }

    /**
     * @param string $operator_LicenseNumber
     */
    public function setOperatorLicenseNumber($operator_LicenseNumber)
    {
        $this->operator_LicenseNumber = $operator_LicenseNumber;
    }

    /**
     * @return string
     */
    public function getIncidentId()
    {
        return $this->incidentId;
    }

    /**
     * @param string $incidentId
     */
    public function setIncidentId($incidentId)
    {
        $this->incidentId = $incidentId;
    }


}

