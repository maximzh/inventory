<?php
/**
 * Created by PhpStorm.
 * User: fumus
 * Date: 21.03.16
 * Time: 13:14
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class EmployeeType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName', TextType::class, array(
                'label' => 'Фамилия',
                'required' => false,
                )
            )
            ->add('firstName', TextType::class,
                array(
                    'label' => 'Имя',
                    'required' => false,
                    )
            )
            ->add('fatherName', TextType::class, array(
                'label' => 'Отчество',
                'required' => false,
                )
            )
            ->add('employeeSince', DateType::class, array(
                'label' => 'Дата приема на работу',
                'years' => range(2000, 2021)
            )
            )
            ->add('position', TextType::class, array(
                'label' => 'Должность',
                'required' => false,
                )
            )
            ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'AppBundle\Entity\Employee',
                'em' => null,
            )
        );
    }

    public function getBlockPrefix()
    {
        return "employee";
    }
}