<?php
/**
 * Created by PhpStorm.
 * User: fumus
 * Date: 10.04.16
 * Time: 12:44
 */

namespace AppBundle\Filter;

use AppBundle\Entity\AnotherDevice;
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
                    'Мебель' => AnotherDevice::FURNITURE_DEVICE,
                    'Электронное устройство' => AnotherDevice::ELECTRONIC_DEVICE,
                    'Офисная техника' => AnotherDevice::TECHNICS_DEVICE,
                    'Другое' => AnotherDevice::ANOTHER_DEVICE,
                ),
                'choices_as_values' => true,

            ))
            ->add('status', Filters\ChoiceFilterType::class, array(
                'label' => 'состояние',
                'choices' => array(
                    'Новое' => AnotherDevice::STATUS_NEW,
                    'Старое' => AnotherDevice::STATUS_OLD,
                    'После ремонта' => AnotherDevice::STATUS_FIXED,
                    'Исправное' => AnotherDevice::STATUS_OK,
                    'Сломаное' => AnotherDevice::STATUS_BROKEN,
                ),
                'choices_as_values' => true,
            ));
    }

    public function getBlockPrefix()
    {
        return 'another_device_filter';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'error_bubbling' => true,
            'csrf_protection' => false,
            'validation_groups' => array('filtering'),// avoid NotBlank() constraint-related message
            'method' => 'get',
        ));
    }

}