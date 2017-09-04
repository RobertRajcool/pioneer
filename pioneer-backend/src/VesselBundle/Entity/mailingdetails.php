<?php

namespace VesselBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * mailingdetails
 *
 * @ORM\Table(name="mailingdetails")
 * @ORM\Entity(repositoryClass="VesselBundle\Repository\mailingdetailsRepository")
 */
class mailingdetails
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
     * @ORM\Column(name="userEmail", type="string", length=255)
     */
    private $userEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="senderMail", type="string", length=255)
     */
    private $senderMail;

    /**
     * @return string
     */
    public function getSendername()
    {
        return $this->sendername;
    }

    /**
     * @param string $sendername
     */
    public function setSendername($sendername)
    {
        $this->sendername = $sendername;
    }

    /**
     * @return string
     */
    public function getTextcontent()
    {
        return $this->Textcontent;
    }

    /**
     * @param string $Textcontent
     */
    public function setTextcontent($Textcontent)
    {
        $this->Textcontent = $Textcontent;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="Textcontent", type="string", length=255)
     */
    private $Textcontent;
    /**
     * @var string
     *
     * @ORM\Column(name="sendername", type="string", length=255)
     */
    private $sendername;

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */

    private $status;

    /**
     * @return string
     */

    public function getSenderMail()
    {
        return $this->senderMail;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->Date;
    }

    /**
     * @param \DateTime $Date
     */
    public function setDate($Date)
    {
        $this->Date = $Date;
    }

    /**
     * @param string $senderMail
     */
    public function setSenderMail($senderMail)
    {
        $this->senderMail = $senderMail;
    }

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date", type="datetime", nullable=true)
     */
    private $Date;
    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255)
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="companyName", type="string", length=255)
     */
    private $companyName;


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
     * Set userEmail
     *
     * @param string $userEmail
     *
     * @return mailingdetails
     */
    public function setUserEmail($userEmail)
    {
        $this->userEmail = $userEmail;

        return $this;
    }

    /**
     * Get userEmail
     *
     * @return string
     */
    public function getUserEmail()
    {
        return $this->userEmail;
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return mailingdetails
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set companyName
     *
     * @param string $companyName
     *
     * @return mailingdetails
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * Get companyName
     *
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }
}

