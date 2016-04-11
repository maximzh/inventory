<?php
/**
 * Created by PhpStorm.
 * User: fumus
 * Date: 08.04.16
 * Time: 20:24
 */

namespace AppBundle\Filter;

use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;


class ArmchairFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', Filters\TextFilterType::class, array(
                    'condition_pattern' => FilterOperands::STRING_CONTAINS,
                    'label' => ' '
                )
            )
            ->add('status', Filters\ChoiceFilterType::class, array(
                'label' => 'состояние кресла',
                'choices' => array(
                    'Новое' => 'new',
                    'Старое' => 'old',
                    'Сломанное' => 'broken',
                    'После ремонта' => 'fixed',
                ),
                'choices_as_values' => true,
                //'condition_pattern' => FilterOperands::STRING_EQUALS,

            ));
    }

    public function getParent()
    {
        return Filters\SharedableFilterType::class; // this allow us to use the "add_shared" option
    }

    public function getBlockPrefix()
    {
        return 'filter_armchair';
    }

}