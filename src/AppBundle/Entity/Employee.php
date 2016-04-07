<?php
/**
 * Created by PhpStorm.
 * User: fumus
 * Date: 21.03.16
 * Time: 10:27
 */

namespace AppBundle\Entity;

use AppBundle\Entity\Armchair;
use AppBundle\Entity\Headphones;
use AppBundle\Entity\Keyboard;
use AppBundle\Entity\Mac;
use AppBundle\Entity\Monitor;
use AppBundle\Entity\Mouse;
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
     * @ORM\OneToOne(targetEntity="Mac", inversedBy="employee")
     */
    private $mac;

    /**
     * @ORM\OneToMany(targetEntity="Monitor", mappedBy="employee")
     */
    private $monitors;

    /**
     * @ORM\Column(name="monitors_number", type="integer", nullable=true)
     */
    private $monitorsNumber;

    /**
     * @ORM\OneToOne(targetEntity="Keyboard", inversedBy="employee")
     */
    private $keyboard;

    /**
     * @ORM\OneToOne(targetEntity="Mouse", inversedBy="employee")
     */
    private $mouse;

    /**
     * @ORM\OneToOne(targetEntity="Armchair", inversedBy="employee")
     */
    private $armchair;

    /**
     * @ORM\OneToOne(targetEntity="Headphones", inversedBy="employee")
     */
    private $headphones;

    /**
     * @ORM\OneToOne(targetEntity="UsbHub", inversedBy="employee")
     */
    private $usbHub;




    /**
     * @return string
     */
    public function __toString() {
        $name = $this->getFirstName().' '.$this->getLastName().' '.$this->getFatherName();
        return (string) $name;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->monitors = new \Doctrine\Common\Collections\ArrayCollection();
        if (!$this->getMonitorsNumber()) {
            $this->setMonitorsNumber(0);
        }
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
     * Set mac
     *
     * @param Mac $mac
     *
     * @return Employee
     */
    public function setMac(Mac $mac = null)
    {
        $this->mac = $mac;

        return $this;
    }

    /**
     * Get mac
     *
     * @return Mac
     */
    public function getMac()
    {
        return $this->mac;
    }

    /**
     * Add monitor
     *
     * @param Monitor $monitor
     *
     * @return Employee
     */
    public function addMonitor(Monitor $monitor)
    {
        $this->monitors[] = $monitor;

        if (null == $count = $this->getMonitorsNumber()) {
            $this->setMonitorsNumber(1);
        } else {
            $this->setMonitorsNumber($this->getMonitorsNumber() + 1);
        }

        return $this;
    }

    /**
     * Remove monitor
     *
     * @param Monitor $monitor
     */
    public function removeMonitor(Monitor $monitor)
    {
        $this->monitors->removeElement($monitor);
        $this->setMonitorsNumber($this->getMonitorsNumber() - 1);
        $monitor->setEmployee(null);
    }

    /**
     * Get monitors
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMonitors()
    {
        return $this->monitors;
    }

    /**
     * Set keyboard
     *
     * @param Keyboard $keyboard
     *
     * @return Employee
     */
    public function setKeyboard(Keyboard $keyboard = null)
    {
        $this->keyboard = $keyboard;

        return $this;
    }

    /**
     * Get keyboard
     *
     * @return Keyboard
     */
    public function getKeyboard()
    {
        return $this->keyboard;
    }

    /**
     * Set mouse
     *
     * @param Mouse $mouse
     *
     * @return Employee
     */
    public function setMouse(Mouse $mouse = null)
    {
        $this->mouse = $mouse;

        return $this;
    }

    /**
     * Get mouse
     *
     * @return Mouse
     */
    public function getMouse()
    {
        return $this->mouse;
    }

    /**
     * Set armchair
     *
     * @param Armchair $armchair
     *
     * @return Employee
     */
    public function setArmchair(Armchair $armchair = null)
    {
        $this->armchair = $armchair;

        return $this;
    }

    /**
     * Get armchair
     *
     * @return Armchair
     */
    public function getArmchair()
    {
        return $this->armchair;
    }

    /**
     * Set headphones
     *
     * @param Headphones $headphones
     *
     * @return Employee
     */
    public function setHeadphones(Headphones $headphones = null)
    {
        $this->headphones = $headphones;

        return $this;
    }

    /**
     * Get headphones
     *
     * @return Headphones
     */
    public function getHeadphones()
    {
        return $this->headphones;
    }

    /**
     * Set usbHub
     *
     * @param \AppBundle\Entity\UsbHub $usbHub
     *
     * @return Employee
     */
    public function setUsbHub(\AppBundle\Entity\UsbHub $usbHub = null)
    {
        $this->usbHub = $usbHub;

        return $this;
    }

    /**
     * Get usbHub
     *
     * @return \AppBundle\Entity\UsbHub
     */
    public function getUsbHub()
    {
        return $this->usbHub;
    }

    /**
     * Set monitorsNumber
     *
     * @param integer $monitorsNumber
     *
     * @return Employee
     */
    public function setMonitorsNumber($monitorsNumber)
    {
        $this->monitorsNumber = $monitorsNumber;

        return $this;
    }

    /**
     * Get monitorsNumber
     *
     * @return integer
     */
    public function getMonitorsNumber()
    {
        return $this->monitorsNumber;
    }
}
