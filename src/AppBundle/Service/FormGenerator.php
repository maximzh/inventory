<?php
/**
 * Created by PhpStorm.
 * User: fumus
 * Date: 22.03.16
 * Time: 23:46
 */

namespace AppBundle\Service;


use AppBundle\Entity\AnotherDevice;
use AppBundle\Entity\Armchair;
use AppBundle\Entity\Employee;
use AppBundle\Entity\Headphones;
use AppBundle\Entity\Keyboard;
use AppBundle\Entity\Mac;
use AppBundle\Entity\Monitor;
use AppBundle\Entity\Mouse;
use AppBundle\Entity\UsbHub;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\RouterInterface;

class FormGenerator
{
    protected $formFactory;
    protected $doctrine;
    protected $router;

    public function __construct(FormFactoryInterface $formFactory, RouterInterface $router, RegistryInterface $doctrine)
    {
        $this->formFactory = $formFactory;
        $this->doctrine = $doctrine;
        $this->router = $router;
    }

    /**
     * @param Employee $employee
     * @return mixed
     */
    public function createEmployeeDeleteForm(Employee $employee)
    {
        $builder = $this->formFactory->createBuilder();
        $form = $builder->setAction($this->router->generate('remove_employee', array('id' => $employee->getId())))
            ->setMethod('DELETE')
            ->add(
                'submit',
                SubmitType::class,
                ['label' => ' Удалить сотрудника', 'attr' => ['class' => 'glyphicon glyphicon-trash btn-danger btn-block']]
            )
            ->getForm();

        return $form;
    }

    /**
     * @param Mac $mac
     * @return \Symfony\Component\Form\Form
     */
    public function createMacDeleteForm(Mac $mac)
    {
        $builder = $this->formFactory->createBuilder();
        $form = $builder->setAction($this->router->generate('remove_mac', array('id' => $mac->getId())))
            ->setMethod('DELETE')
            ->add(
                'submit',
                SubmitType::class,
                ['label' => ' ', 'attr' => ['class' => 'glyphicon glyphicon-trash btn-danger btn-sm']]
            )
            ->getForm();

        return $form;
    }

    /**
     * @param Armchair $armchair
     * @return \Symfony\Component\Form\Form
     */
    public function createArmchairDeleteForm(Armchair $armchair)
    {
        $builder = $this->formFactory->createBuilder();
        $form = $builder->setAction($this->router->generate('remove_armchair', array('id' => $armchair->getId())))
            ->setMethod('DELETE')
            ->add(
                'submit',
                SubmitType::class,
                ['label' => ' ', 'attr' => ['class' => 'glyphicon glyphicon-trash btn-danger btn-sm']]
            )
            ->getForm();

        return $form;
    }

    /**
     * @param Monitor $monitor
     * @return \Symfony\Component\Form\Form
     */
    public function createMonitorDeleteForm(Monitor $monitor)
    {
        $builder = $this->formFactory->createBuilder();
        $form = $builder->setAction($this->router->generate('remove_monitor', array('id' => $monitor->getId())))
            ->setMethod('DELETE')
            ->add(
                'submit',
                SubmitType::class,
                ['label' => ' ', 'attr' => ['class' => 'glyphicon glyphicon-trash btn-danger btn-sm']]
            )
            ->getForm();

        return $form;
    }

    /**
     * @param UsbHub $usbHub
     * @return \Symfony\Component\Form\Form
     */
    public function createUsbHubDeleteForm(UsbHub $usbHub)
    {
        $builder = $this->formFactory->createBuilder();
        $form = $builder->setAction($this->router->generate('remove_usbhub', array('id' => $usbHub->getId())))
            ->setMethod('DELETE')
            ->add(
                'submit',
                SubmitType::class,
                ['label' => ' ', 'attr' => ['class' => 'glyphicon glyphicon-trash btn-danger btn-sm']]
            )
            ->getForm();

        return $form;
    }

    /**
     * @param Keyboard $keyboard
     * @return \Symfony\Component\Form\Form
     */
    public function createKeyboardDeleteForm(Keyboard $keyboard)
    {
        $builder = $this->formFactory->createBuilder();
        $form = $builder->setAction($this->router->generate('remove_keyboard', array('id' => $keyboard->getId())))
            ->setMethod('DELETE')
            ->add(
                'submit',
                SubmitType::class,
                ['label' => ' ', 'attr' => ['class' => 'glyphicon glyphicon-trash btn-danger btn-sm']]
            )
            ->getForm();

        return $form;
    }

    /**
     * @param Headphones $headphones
     * @return \Symfony\Component\Form\Form
     */
    public function createHeadphonesDeleteForm(Headphones $headphones)
    {
        $builder = $this->formFactory->createBuilder();
        $form = $builder->setAction($this->router->generate('remove_headphones', array('id' => $headphones->getId())))
            ->setMethod('DELETE')
            ->add(
                'submit',
                SubmitType::class,
                ['label' => ' ', 'attr' => ['class' => 'glyphicon glyphicon-trash btn-danger btn-sm']]
            )
            ->getForm();

        return $form;
    }

    /**
     * @param Mouse $mouse
     * @return \Symfony\Component\Form\Form
     */
    public function createMouseDeleteForm(Mouse $mouse)
    {
        $builder = $this->formFactory->createBuilder();
        $form = $builder->setAction($this->router->generate('remove_mouse', array('id' => $mouse->getId())))
            ->setMethod('DELETE')
            ->add(
                'submit',
                SubmitType::class,
                ['label' => ' ', 'attr' => ['class' => 'glyphicon glyphicon-trash btn-danger btn-sm']]
            )
            ->getForm();

        return $form;
    }

    public function createAnotherDeviceDeleteForm(AnotherDevice $device)
    {
        $builder = $this->formFactory->createBuilder();
        $form = $builder->setAction($this->router->generate('remove_device', array('id' => $device->getId())))
            ->setMethod('DELETE')
            ->add(
                'submit',
                SubmitType::class,
                ['label' => ' ', 'attr' => ['class' => 'glyphicon glyphicon-trash btn-danger btn-sm']]
            )
            ->getForm();

        return $form;
    }
   
    /*
    public function createDeleteForm($entity)
    {
        $builder = $this->formFactory->createBuilder();
        
        if ($entity instanceof Mac) {
            $form = $builder->setAction($this->router->generate('remove_mac', array('id' => $entity->getId())));
        } elseif ($entity instanceof Armchair ) {
            $form = $builder->setAction($this->router->generate('remove_armchair', array('id' => $entity->getId())));

        }
        $form = $form->setMethod('DELETE')
            ->add(
                'submit',
                SubmitType::class,
                ['label' => ' ', 'attr' => ['class' => 'glyphicon glyphicon-trash btn-danger btn-sm']]
            )
            ->getForm();

        return $form;
    }
    */



}