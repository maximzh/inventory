<?php
/**
 * Created by PhpStorm.
 * User: fumus
 * Date: 08.04.16
 * Time: 22:29
 */

namespace AppBundle\Filter;

use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;


class MacFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', Filters\TextFilterType::class, array(
                'condition_pattern' => FilterOperands::STRING_CONTAINS,
                'label' => 'Модель Mac Mini'
            ))
            ->add('ram', Filters\NumberFilterType::class, array(
                //'condition_pattern' => FilterOperands::OPERATOR_EQUAL,
                'label' => 'RAM Mac Mini'
            ))
            ->add('ssd', Filters\NumberFilterType::class, array(
                //'condition_pattern' => FilterOperands::OPERATOR_EQUAL,
                'label' => 'SSD Mac Mini'
            ))
            ->add('hdd', Filters\NumberFilterType::class, array(
                //'condition_pattern' => FilterOperands::OPERATOR_EQUAL,
                'label' => 'HDD Mac Mini'
            ))
        ;
    }

    public function getParent()
    {
        return Filters\SharedableFilterType::class; // this allow us to use the "add_shared" option
    }

    public function getBlockPrefix()
    {
        return 'filter_mac';
    }

}