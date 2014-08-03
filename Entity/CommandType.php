<?php
namespace Dellaert\ACCOBooklistBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="accobooklist_command_type")
 */
class CommandType
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
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    protected $command;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    protected $description;

    /**
     * @ORM\OneToMany(targetEntity="ScheduledCommand", mappedBy="commandType")
     */
    protected $scheduledCommands;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->scheduledCommands = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set command
     *
     * @param string $command
     * @return CommandType
     */
    public function setCommand($command)
    {
        $this->command = $command;

        return $this;
    }

    /**
     * Get command
     *
     * @return string 
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return CommandType
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
     * Add sheduledCommands
     *
     * @param \Dellaert\ACCOBooklistBundle\Entity\ScheduledCommand $sheduledCommands
     * @return CommandType
     */
    public function addScheduledCommand(\Dellaert\ACCOBooklistBundle\Entity\ScheduledCommand $sheduledCommands)
    {
        $this->sheduledCommands[] = $sheduledCommands;

        return $this;
    }

    /**
     * Remove sheduledCommands
     *
     * @param \Dellaert\ACCOBooklistBundle\Entity\ScheduledCommand $sheduledCommands
     */
    public function removeScheduledCommand(\Dellaert\ACCOBooklistBundle\Entity\ScheduledCommand $sheduledCommands)
    {
        $this->sheduledCommands->removeElement($sheduledCommands);
    }

    /**
     * Get sheduledCommands
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getScheduledCommands()
    {
        return $this->sheduledCommands;
    }
}
