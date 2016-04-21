<?php

namespace AppBundle\Form;

use AppBundle\Entity\Mac;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;


class MacType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                    'label' => 'Модель Mac Mini',
                    'required' => true,
                )
            )
            ->add('ssd', IntegerType::class, array(
                    'label' => 'Емкость SSD',
                    'required' => false,
                )
            )
            ->add('hdd', IntegerType::class, array(
                    'label' => 'Емкость HDD',
                    'required' => false,
                )
            )
            ->add('ram', IntegerType::class, array(
                    'label' => 'Размер RAM',
                    'required' => false,
                )
            )
            ->add('status', ChoiceType::class, array(
                    'label' => 'Состояние',
                    'required' => false,
                    'choices' => array(
                        'Исправный' => Mac::STATUS_OK,
                        'Сломанный' => Mac::STATUS_BROKEN,
                        'После ремонта' => Mac::STATUS_FIXED,
                    ),
                    'choices_as_values' => true,
                )
            )
            ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
                $mac = $event->getData();
                $form = $event->getForm();

                if (null == $mac->getEmployee()) {
                    $form->add('employee', EntityType::class,[
                        'class' => 'AppBundle\Entity\Employee',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->select('e')
                                ->where('e.mac IS NULL');
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
                'data_class' => 'AppBundle\Entity\Mac',
                'em' => null,
            )
        );
    }
}