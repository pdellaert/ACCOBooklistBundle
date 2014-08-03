<?php
namespace Dellaert\ACCOBooklistBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

/**
 * @ORM\Entity
 * @ORM\Table(name="accobooklist_scheduled_command")
 */
class ScheduledCommand
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     * @var integer
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="CommandType", inversedBy="scheduledCommands")
     * @ORM\JoinColumn(name="commandtype_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $commandType;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * 
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * 
     * @var \DateTime
     */
    protected $finishedAt;

    /**
     * @ORM\Column(type="boolean")
     * 
     * @var number
     */
    protected $executed;

    /**
     * @ORM\Column(type="string", length=512, nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    protected $result;

    /**
     * @ORM\Column(type="string", length=512)
     * @Assert\NotBlank()
     *
     * @var string
     */
    protected $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     *
     * @var string
     */
    protected $school;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     *
     * @var string
     */
    protected $faculty;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     *
     * @var string
     */
    protected $level;
    
    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return ScheduledCommand
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set finishedAt
     *
     * @param \DateTime $finishedAt
     * @return ScheduledCommand
     */
    public function setFinishedAt($finishedAt)
    {
        $this->finishedAt = $finishedAt;

        return $this;
    }

    /**
     * Get finishedAt
     *
     * @return \DateTime 
     */
    public function getFinishedAt()
    {
        return $this->finishedAt;
    }

    /**
     * Set executed
     *
     * @param boolean $executed
     * @return ScheduledCommand
     */
    public function setExecuted($executed)
    {
        $this->executed = $executed;

        return $this;
    }

    /**
     * Get executed
     *
     * @return boolean 
     */
    public function getExecuted()
    {
        return $this->executed;
    }

    /**
     * Set result
     *
     * @param string $result
     * @return ScheduledCommand
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get result
     *
     * @return string 
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return ScheduledCommand
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set school
     *
     * @param string $school
     * @return ScheduledCommand
     */
    public function setSchool($school)
    {
        $this->school = $school;

        return $this;
    }

    /**
     * Get school
     *
     * @return string 
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * Set faculty
     *
     * @param string $faculty
     * @return ScheduledCommand
     */
    public function setFaculty($faculty)
    {
        $this->faculty = $faculty;

        return $this;
    }

    /**
     * Get faculty
     *
     * @return string 
     */
    public function getFaculty()
    {
        return $this->faculty;
    }

    /**
     * Set level
     *
     * @param string $level
     * @return ScheduledCommand
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return string 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set commandType
     *
     * @param \Dellaert\ACCOBooklistBundle\Entity\CommandType $commandType
     * @return ScheduledCommand
     */
    public function setCommandType(\Dellaert\ACCOBooklistBundle\Entity\CommandType $commandType = null)
    {
        $this->commandType = $commandType;

        return $this;
    }

    /**
     * Get commandType
     *
     * @return \Dellaert\ACCOBooklistBundle\Entity\CommandType 
     */
    public function getCommandType()
    {
        return $this->commandType;
    }
}
