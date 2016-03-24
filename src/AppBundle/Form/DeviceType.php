<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class DeviceType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Название устройства',
                'required' => false,
                )
            )
            ->add('type', ChoiceType::class,
                array(
                        'label' => 'Тип устройства',
                        'required' => false,
                        'choices'  => array(
                            'keyboard' => 'Клавиатура',
                            'monitor' => 'Монитор',
                            'Mac' => 'Mac',
                            'mouse' => 'Мышь',
                            'armchair' => 'Кресло',
                            'headphones' => 'Наушники',
                        ),
                    )
            )
            ->add('status', ChoiceType::class, array(
                'label' => 'Статус',
                'required' => false,
                    'choices'  => array(
                        'free' => "Свободен",
                        'busy' => "Занят",
                    ),
                )
            )
            ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'AppBundle\Entity\Device',
                'em' => null,
            )
        );
    }
//
//    public function getBlockPrefix()
//    {
//        return "device";
//    }
}