<?php
/**
 * Created by PhpStorm.
 * User: fumus
 * Date: 09.04.16
 * Time: 11:46
 */

namespace AppBundle\Filter;

use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;


class KeyboardFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', Filters\TextFilterType::class, array(
            'condition_pattern' => FilterOperands::STRING_CONTAINS,
            'label' => ' '
        ));
    }

    public function getParent()
    {
        return Filters\SharedableFilterType::class; // this allow us to use the "add_shared" option
    }

    public function getBlockPrefix()
    {
        return 'filter_keyboard';
    }

}