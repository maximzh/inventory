<?php
/**
 * Created by PhpStorm.
 * User: fumus
 * Date: 26.03.16
 * Time: 22:48
 */

namespace AppBundle\Filter;

use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\DateRangeFilterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;


class EmployeeFilterType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', Filters\TextFilterType::class, array(
                'condition_pattern' => FilterOperands::STRING_CONTAINS,
                'label' => 'Имя'
            ))
            ->add('fatherName', Filters\TextFilterType::class, array(
                'condition_pattern' => FilterOperands::STRING_CONTAINS,
                'label' => 'Отчество'
            ))
            ->add('lastName', Filters\TextFilterType::class, array(
                'condition_pattern' => FilterOperands::STRING_CONTAINS,
                'label' => 'Фамилия'
            ))
            ->add('position', Filters\TextFilterType::class, array(
                'condition_pattern' => FilterOperands::STRING_CONTAINS,
                'label' => 'Позиция'
                ))
            ->add('employeeSince', DateRangeFilterType::class, array(
                'label' => 'Принят на работу (в период):',
                'left_date_options' => array(
                    'label' => 'От:',
                    'years' => range(2001, 2021),
                    'data' => new \DateTime('2001-01-01')
                ),
                'right_date_options' => array(
                    'label' => 'До:',
                    'years' => range(2001, 2021),
                    'data' => new \DateTime('2021-01-01')
                )
            ))
        ;
    }

    public function getBlockPrefix()
    {
        return 'employee_filter';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            //'data_class' => 'AppBundle\Entity\Employee',
            'error_bubbling'    => true,
            'csrf_protection'   => false,
            'validation_groups' => array('filtering'),// avoid NotBlank() constraint-related message
            'method'            => 'get',
        ));
    }
}