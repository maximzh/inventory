<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Mac
 *
 * @ORM\Table(name="mac")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MacRepository")
 */
class Mac 
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * 
     * @Assert\NotBlank(message="Укажите модель Mac")
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    protected $type;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     */
    protected $status;

    /**
     * @var int
     *
     * @ORM\Column(name="ram", type="integer")
     *
     * @Assert\NotBlank(message="Укажите объем RAM")
     * @Assert\GreaterThan(value = 0, message="Это значение должно быть положительным")
     */
    
    private $ram;

    /**
     * @var int
     *
     * @ORM\Column(name="ssd", type="integer", nullable=true)
     *
     * @Assert\GreaterThan(value = 0, message="Это значение должно быть положительным")
     */
    private $ssd;

    /**
     * @var int
     *
     * @ORM\Column(name="hdd", type="integer", nullable=true)
     *
     * @Assert\GreaterThan(value = 0, message="Это значение должно быть положительным")
     */
    private $hdd;

    /**
     * @ORM\OneToOne(targetEntity="Employee", mappedBy="mac")
     */
    private $employee;
    

    /**
     * @return string
     */
    public function __toString() {
        return (string) $this->getName();
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
     * Set name
     *
     * @param string $name
     *
     * @return Mac
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
     * Set type
     *
     * @param string $type
     *
     * @return Mac
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Mac
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
     * Set ram
     *
     * @param integer $ram
     *
     * @return Mac
     */
    public function setRam($ram)
    {
        $this->ram = $ram;

        return $this;
    }

    /**
     * Get ram
     *
     * @return integer
     */
    public function getRam()
    {
        return $this->ram;
    }

    /**
     * Set ssd
     *
     * @param integer $ssd
     *
     * @return Mac
     */
    public function setSsd($ssd)
    {
        $this->ssd = $ssd;

        return $this;
    }

    /**
     * Get ssd
     *
     * @return integer
     */
    public function getSsd()
    {
        return $this->ssd;
    }

    /**
     * Set hdd
     *
     * @param integer $hdd
     *
     * @return Mac
     */
    public function setHdd($hdd)
    {
        $this->hdd = $hdd;

        return $this;
    }

    /**
     * Get hdd
     *
     * @return integer
     */
    public function getHdd()
    {
        return $this->hdd;
    }

    /**
     * Set employee
     *
     * @param Employee $employee
     *
     * @return Mac
     */
    public function setEmployee(Employee $employee = null)
    {

        $this->employee = $employee;
        if ($employee) {
            $employee->setMac($this);
        }

        return $this;
    }

    /**
     * Get employee
     *
     * @return Employee
     */
    public function getEmployee()
    {
        return $this->employee;
    }
}
