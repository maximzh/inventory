<?php
/**
 * Created by PhpStorm.
 * User: fumus
 * Date: 09.04.16
 * Time: 11:32
 */

namespace AppBundle\Filter;

use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;


class UsbHubFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', Filters\TextFilterType::class, array(
                    'condition_pattern' => FilterOperands::STRING_CONTAINS,
                    'label' => ' '
                )
            )
            ->add('portsNumber', Filters\NumberFilterType::class, array(
                //'condition_pattern' => FilterOperands::OPERATOR_EQUAL,
                'label' => 'Usb Hub кол. портов'
            ))
        ;
    }

    public function getParent()
    {
        return Filters\SharedableFilterType::class; // this allow us to use the "add_shared" option
    }

    public function getBlockPrefix()
    {
        return 'filter_usbhub';
    }

}