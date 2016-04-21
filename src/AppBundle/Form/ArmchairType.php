<?php

namespace AppBundle\Form;

use AppBundle\Entity\Armchair;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ArmchairType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                    'label' => 'Название кресла',
                    'required' => true,
                )
            )
            ->add('material', ChoiceType::class,
                array(
                    'choices' => array(
                        'Кожа' => Armchair::MATERIAL_LETHER,
                        'Экологическая кожа' => Armchair::MATERIAL_ECO_LETHER,
                        'Ткань' => Armchair::MATERIAL_TEXTILE,
                        'Другое' => Armchair::MATERIAL_OTHER,
                    ),
                    'choices_as_values' => true,
                    'label' => 'Обивка',
                    'required' => false,
                )
            )
            ->add('status', ChoiceType::class, array(
                    'label' => 'Состояние',
                    'required' => false,
                    'choices' => array(
                        'Новое' => Armchair::STATUS_NEW,
                        'Старое' => Armchair::STATUS_OLD,
                        'Сломанное' => Armchair::STATUS_BROKEN,
                        'После ремонта' => Armchair::STATUS_FIXED,
                    ),
                    'choices_as_values' => true,
                )
            )
            ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
                $armchair = $event->getData();
                $form = $event->getForm();

                if (null == $armchair->getEmployee()) {
                    $form->add('employee', EntityType::class,[
                        'class' => 'AppBundle\Entity\Employee',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->select('e')
                                ->where('e.armchair IS NULL');
                        },
                        'required' => false,
                        'label' => 'Сотрудник'
                    ]);
                }
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'AppBundle\Entity\Armchair',
                'em' => null,
            )
        );
    }
}