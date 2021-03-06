<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Monitor
 *
 * @ORM\Table(name="monitor")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MonitorRepository")
 */
class Monitor
{
    const STATUS_FIXED = 'fixed';
    const STATUS_BROKEN = 'broken';
    const STATUS_OK = 'ok';
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="diagonal", type="integer")
     *
     * @Assert\NotBlank(message="Укажите диагональ монитора")
     * @Assert\Type(type="integer")
     * @Assert\GreaterThan(value = 0, message="Это значение должно быть положительным")
     */
    private $diagonal;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     *
     * @Assert\NotBlank(message="Укажите название монитора")
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     */
    protected $status;

    /**
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="monitors")
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
     * Set diagonal
     *
     * @param integer $diagonal
     *
     * @return Monitor
     */
    public function setDiagonal($diagonal)
    {
        $this->diagonal = $diagonal;

        return $this;
    }

    /**
     * Get diagonal
     *
     * @return int
     */
    public function getDiagonal()
    {
        return $this->diagonal;
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
    public function setEmployee($employee)
    {
        $this->employee = $employee;
        if (null != $employee) {
            $employee->addMonitor($this);
        }
    }
    
    
    
    /**
     * @return string
     */
    public function __toString() {
        return (string) $this->getName();
    }
}
