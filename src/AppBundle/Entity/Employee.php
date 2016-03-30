<?php
/**
 * Created by PhpStorm.
 * User: fumus
 * Date: 21.03.16
 * Time: 10:27
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Employee
 * @ORM\Table(name="employee")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmployeeRepository")
 */
class Employee
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=100, unique=false)
     *
     * @Assert\NotBlank(message="Имя сотрудника должно быть указано")
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="father_name", type="string", length=100, unique=false, nullable=true)
     *
     */
    private $fatherName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=100, unique=false)
     *
     * @Assert\NotBlank(message="Фамилия сотрудника должна быть указана")
     */
    private $lastName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="employee_since", type="date")
     *
     * @Assert\Date()
     */
    private $employeeSince;

    /**
     * @var string
     *
     * @ORM\Column(name="position", type="string", length=255, unique=false)
     *
     * @Assert\NotBlank(message="Должность сотрудника должна быть указана")
     */
    private $position;

    /**
     * @ORM\OneToOne(targetEntity="Mac", mappedBy="employee")
     */
    private $mac;

    /**
     * @ORM\OneToMany(targetEntity="Monitor", mappedBy="employee")
     */
    private $monitors;

    /**
     * @ORM\OneToOne(targetEntity="Keyboard", inversedBy="employee")
     */
    private $keyboard;

    /**
     * @ORM\OneToOne(targetEntity="Mouse", inversedBy="employee")
     */
    private $mouse;

    /**
     * @ORM\OneToOne(targetEntity="Armchair", mappedBy="employee")
     */
    private $armchair;

    /**
     * @ORM\OneToOne(targetEntity="Headphones", inversedBy="employee")
     */
    private $headphones;

    /**
     * @ORM\OneToOne(targetEntity="UsbHub", mappedBy="employee")
     */
    private $usbHub;

    public function __construct()
    {
        $this->monitors = new ArrayCollection();
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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Employee
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set fatherName
     *
     * @param string $fatherName
     *
     * @return Employee
     */
    public function setFatherName($fatherName)
    {
        $this->fatherName = $fatherName;

        return $this;
    }

    /**
     * Get fatherName
     *
     * @return string
     */
    public function getFatherName()
    {
        return $this->fatherName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Employee
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set employeeSince
     *
     * @param \DateTime $employeeSince
     *
     * @return Employee
     */
    public function setEmployeeSince($employeeSince)
    {
        $this->employeeSince = $employeeSince;

        return $this;
    }

    /**
     * Get employeeSince
     *
     * @return \DateTime
     */
    public function getEmployeeSince()
    {
        return $this->employeeSince;
    }

    /**
     * Set position
     *
     * @param string $position
     *
     * @return Employee
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return Mac
     */
    public function getMac()
    {
        return $this->mac;
    }

    /**
     * @param Mac $mac
     */
    public function setMac($mac)
    {
        $this->mac = $mac;
    }

    /**
     * @return Monitor
     */
    public function getMonitors()
    {
        return $this->monitors;
    }

    /**
     * @param Monitor $monitor
     */
    public function setMonitor($monitor)
    {
        $this->monitors = $monitor;
    }

    /**
     * @return Keyboard
     */
    public function getKeyboard()
    {
        return $this->keyboard;
    }

    /**
     * @param Keyboard $keyboard
     */
    public function setKeyboard($keyboard)
    {
        $this->keyboard = $keyboard;
    }

    /**
     * @return Mouse
     */
    public function getMouse()
    {
        return $this->mouse;
    }

    /**
     * @param Mouse $mouse
     */
    public function setMouse($mouse)
    {
        $this->mouse = $mouse;
    }

    /**
     * @return Armchair
     */
    public function getArmchair()
    {
        return $this->armchair;
    }

    /**
     * @param Armchair $armchair
     */
    public function setArmchair($armchair)
    {
        $this->armchair = $armchair;
    }

    /**
     * @return Headphones
     */
    public function getHeadphones()
    {
        return $this->headphones;
    }

    /**
     * @param Headphones $headphones
     */
    public function setHeadphones($headphones)
    {
        $this->headphones = $headphones;
    }

    /**
     * @return UsbHub
     */
    public function getUsbHub()
    {
        return $this->usbHub;
    }

    /**
     * @param UsbHub $usbHub
     */
    public function setUsbHub($usbHub)
    {
        $this->usbHub = $usbHub;
    }


    /**
     * @return string
     */
    public function __toString() {
        $name = $this->getFirstName().' '.$this->getLastName().' '.$this->getFatherName();
        return (string) $name;
    }

    /**
     * Add monitor
     *
     * @param Monitor $monitor
     *
     * @return Employee
     */
    public function addMonitor($monitor)
    {
        $this->monitors[] = $monitor;
        if ($monitor) {
            $monitor->setEmployee($this);
        }

        return $this;
    }

    /**
     * Remove monitor
     *
     * @param Monitor $monitor
     */
    public function removeMonitor($monitor)
    {
        $this->monitors->removeElement($monitor);
    }
}
