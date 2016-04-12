<?php

namespace AppBundle\Form;

use AppBundle\Entity\Mouse;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;


class MouseType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                    'label' => 'Название мыши',
                    'required' => true,
                )
            )
            ->add('type', ChoiceType::class, array(
                    'label' => 'Тип',
                    'required' => false,
                    'choices' => array(
                        'Проводная' => Mouse::TYPE_WIRED,
                        'Беcпроводная' => Mouse::TYPE_WIRELESS,
                    ),
                    'choices_as_values' => true,
                )
            )
            ->add('status', ChoiceType::class, array(
                    'label' => 'Состояние',
                    'required' => false,
                    'choices' => array(
                        'Исправная' => Mouse::STATUS_OK,
                        'Сломанная' => Mouse::STATUS_BROKEN,
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
                                ->where('e.mouse IS NULL');
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
                'data_class' => 'AppBundle\Entity\Mouse',
                'em' => null,
            )
        );
    }
}