<?php
/**
 * Created by PhpStorm.
 * User: fumus
 * Date: 22.03.16
 * Time: 23:46
 */

namespace AppBundle\Service;


use AppBundle\Entity\Employee;
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
                ['label' => ' ', 'attr' => ['class' => 'glyphicon glyphicon-trash btn-danger btn-lg pull-right']]
            )
            ->getForm();

        return $form;
    }


}