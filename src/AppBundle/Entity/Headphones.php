<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Headphones
 *
 * @ORM\Table(name="headphones")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HeadphonesRepository")
 */
class Headphones
{
    const TYPE_WIRED = 'wired';
    const TYPE_WIRELESS = 'wireless';
    
    const STATUS_OK = 'ok';
    const STATUS_BROKEN = 'broken';
    
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
     * @Assert\NotBlank(message="Укажите название наушников")
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     */
    protected $status;

    /**
     * @ORM\OneToOne(targetEntity="Employee", mappedBy="headphones")
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
     * @return $this
     */
    public function setEmployee(Employee $employee = null)
    {
        $this->employee = $employee;
        if ($employee) {
            $employee->setHeadphones($this);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function __toString() {
        return (string) $this->getName();
    }
}
