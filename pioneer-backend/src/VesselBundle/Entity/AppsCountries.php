<?php

namespace VesselBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AppsCountries
 *
 * @ORM\Table(name="apps_countries")
 * @ORM\Entity(repositoryClass="VesselBundle\Repository\AppsCountriesRepository")
 */
class AppsCountries
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
     * @ORM\Column(name="countryCode", type="string", length=4)
     */
    private $countryCode;

    /**
     * @var string
     *
     * @ORM\Column(name="countryName", type="string", length=255)
     */
    private $countryName;


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
     * Set countryCode
     *
     * @param string $countryCode
     *
     * @return AppsCountries
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * Get countryCode
     *
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * Set countryName
     *
     * @param string $countryName
     *
     * @return AppsCountries
     */
    public function setCountryName($countryName)
    {
        $this->countryName = $countryName;

        return $this;
    }

    /**
     * Get countryName
     *
     * @return string
     */
    public function getCountryName()
    {
        return $this->countryName;
    }
}

