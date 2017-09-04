<?php

namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BodyAreasAffected
 *
 * @ORM\Table(name="body_areas_affected")
 * @ORM\Entity(repositoryClass="DashboardBundle\Repository\BodyAreasAffectedRepository")
 */
class BodyAreasAffected
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
     * @ORM\Column(name="bodyareaAffectedname", type="string", length=255)
     */
    private $bodyareaAffectedname;


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
    public function getBodyareaAffectedname()
    {
        return $this->bodyareaAffectedname;
    }

    /**
     * @param string $bodyareaAffectedname
     */
    public function setBodyareaAffectedname($bodyareaAffectedname)
    {
        $this->bodyareaAffectedname = $bodyareaAffectedname;
    }

}

