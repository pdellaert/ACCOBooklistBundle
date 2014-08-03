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
     * @ORM\Column(type="string", length=512, unique=true)
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
}