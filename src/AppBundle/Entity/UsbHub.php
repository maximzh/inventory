<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * UsbHub
 *
 * @ORM\Table(name="usb_hub")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsbHubRepository")
 */
class UsbHub
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
     * @ORM\Column(name="name", type="string", length=255)
     * 
     * @Assert\NotBlank(message="Укажите название Usb Hub")
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="ports_number", type="string", length=255, nullable=true)
     * 
     * @Assert\Type(type="integer")
     * @Assert\GreaterThan(value = 0, message="Это значение должно быть положительным")
     * 
     */
    protected $portsNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     */
    protected $status;

    /**
     * @ORM\OneToOne(targetEntity="Employee", mappedBy="usbHub")
     */
    private $employee;

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
     * Set name
     *
     * @param string $name
     *
     * @return Monitor
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Monitor
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return Employee
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * @param Employee $employee
     */
    public function setEmployee(Employee $employee = null)
    {
        $this->employee = $employee;
    }

    /**
     * @return string
     */
    public function __toString() {
        return (string) $this->getName();
    }
    

    /**
     * Set portsNumber
     *
     * @param string $portsNumber
     *
     * @return UsbHub
     */
    public function setPortsNumber($portsNumber)
    {
        $this->portsNumber = $portsNumber;

        return $this;
    }

    /**
     * Get portsNumber
     *
     * @return string
     */
    public function getPortsNumber()
    {
        return $this->portsNumber;
    }
}
