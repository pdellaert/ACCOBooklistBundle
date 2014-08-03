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
     * @ORM\Column(type="string", length=512, unique=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    protected $command;

    /**
     * @ORM\Column(type="string", length=512, unique=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    protected $description;

    /**
     * @ORM\OneToMany(targetEntity="ScheduledCommand", mappedBy="commandType")
     */
    protected $sheduledCommands;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sheduledCommands = new \Doctrine\Common\Collections\ArrayCollection();
    }
}