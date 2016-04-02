<?php

namespace AppBundle\Form;

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


class KeyboardType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Название клавиатуры',
                'required' => true,
                )
            )
            ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
                $keyboard = $event->getData();
                $form = $event->getForm();

                if (null == $keyboard->getEmployee()) {
                    $form->add('employee', EntityType::class,[
                        'class' => 'AppBundle\Entity\Employee',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->select('e, k')
                                ->leftJoin('e.keyboard', 'k')
                                ->where('k.employee IS NULL');
                        },
                        'required' => false,
                        'label' => 'Сотрудник'
                    ]);
                }
            })
            //->add('employee', EntityType::class,[
            //    'class' => 'AppBundle\Entity\Employee'
            //])
            /*
            ->add('status', ChoiceType::class, array(
                'label' => 'Статус',
                'required' => false,
                    'choices'  => array(
                        'free' => "Свободен",
                        'busy' => "Занят",
                    ),
                )
            )
            */
            ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'AppBundle\Entity\Keyboard',
                'em' => null,
            )
        );
    }
}