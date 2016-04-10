<?php
/**
 * Created by PhpStorm.
 * User: fumus
 * Date: 10.04.16
 * Time: 12:44
 */

namespace AppBundle\Filter;

use Doctrine\ORM\EntityRepository;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\DateRangeFilterType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;


class AnotherDeviceFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('name', Filters\TextFilterType::class, array(
                'condition_pattern' => FilterOperands::STRING_CONTAINS,
                'label' => 'Другое устройство'
            ))

            ->add('type', Filters\ChoiceFilterType::class, array(
                'label' => 'тип устройства',
                'choices' => array(
                    'Мебель' => 'furniture',
                    'Электронное устройство' => 'electronics',
                    'Офисная техника' => 'technics',
                    'Другое' => 'another',
                ),
                'choices_as_values' => true,
                //'condition_pattern' => FilterOperands::STRING_EQUALS,

            ))
            ->add('condition', Filters\ChoiceFilterType::class, array(
                'label' => 'состояние',
                'choices' => array(
                    'Новое' => 'new',
                    'Старое' => 'old',
                    'Сломанное' => 'broken',
                    'После ремонта' => 'fixed',
                ),
                'choices_as_values' => true,
                //'condition_pattern' => FilterOperands::STRING_EQUALS,

            ))

            ;
    }

    public function getBlockPrefix()
    {
        return 'another_device_filter';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'error_bubbling'    => true,
            'csrf_protection'   => false,
            'validation_groups' => array('filtering'),// avoid NotBlank() constraint-related message
            'method'            => 'get',
        ));
    }

}