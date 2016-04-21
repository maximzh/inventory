<?php
/**
 * Created by PhpStorm.
 * User: fumus
 * Date: 08.04.16
 * Time: 20:24
 */

namespace AppBundle\Filter;

use AppBundle\Entity\Armchair;
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
                        'Новое' => Armchair::STATUS_NEW,
                        'Старое' => Armchair::STATUS_OLD,
                        'Сломанное' => Armchair::STATUS_BROKEN,
                        'После ремонта' => Armchair::STATUS_FIXED,
                    ),
                    'choices_as_values' => true,
                )
            )
            ->add('material', Filters\ChoiceFilterType::class, array(
                    'label' => 'обивка кресла',
                    'choices' => array(
                        'Кожа' => Armchair::MATERIAL_LETHER,
                        'Экологическая кожа' => Armchair::MATERIAL_ECO_LETHER,
                        'Ткань' => Armchair::MATERIAL_TEXTILE,
                        'Другое' => Armchair::MATERIAL_OTHER,
                    ),
                    'choices_as_values' => true,
                )
            )
        ;
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