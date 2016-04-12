<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Armchair
 *
 * @ORM\Table(name="armchair")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArmchairRepository")
 */
class Armchair
{
    const STATUS_NEW = 'new';
    const STATUS_OLD = 'old';
    const STATUS_FIXED = 'fixed';
    const STATUS_BROKEN = 'broken';
    const STATUS_OK = 'ok';
    
    const MATERIAL_LETHER = 'lether';
    const MATERIAL_TEXTILE = 'textile';
    const MATERIAL_ECO_LETHER = 'ecolether';
    const MATERIAL_OTHER = 'other';
    
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
     * @ORM\Column(name="material", type="string", length=255, nullable=true)
     */
    protected $material;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     */
    protected $status;

    /**
     * @ORM\OneToOne(targetEntity="Employee", mappedBy="armchair")
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
     * Set type
     *
     * @param string $type
     *
     * @return Monitor
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
     * @return Armchair
     */
    public function setEmployee(Employee $employee = null)
    {
        $this->employee = $employee;
        if ($employee) {
            $employee->setArmchair($this);
        }

        return $this;
    }
    
    /**
     * @return string
     */
    public function __toString() {
        return (string) $this->getName();
    }

    /**
     * Set material
     *
     * @param string $material
     *
     * @return Armchair
     */
    public function setMaterial($material)
    {
        $this->material = $material;

        return $this;
    }

    /**
     * Get material
     *
     * @return string
     */
    public function getMaterial()
    {
        return $this->material;
    }
}
