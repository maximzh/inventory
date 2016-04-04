<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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
            ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
                $armchair = $event->getData();
                $form = $event->getForm();

                if (null == $armchair->getEmployee()) {
                    $form->add('employee', EntityType::class,[
                        'class' => 'AppBundle\Entity\Employee',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->select('e, a, k, u, mc, ms, h, mo')
                                ->leftJoin('e.armchair', 'a')
                                ->leftJoin('e.keyboard', 'k')
                                ->leftJoin('e.usbHub', 'u')
                                ->leftJoin('e.mac', 'mc')
                                ->leftJoin('e.mouse', 'ms')
                                ->leftJoin('e.headphones', 'h')
                                ->leftJoin('e.monitors', 'mo')
                                ->where('a.employee IS NULL');
                        },
                        'required' => false,
                        'label' => 'Сотрудник'
                    ]);
                }
            })
            //->add('employee', EntityType::class,[
            //    'class' => 'AppBundle\Entity\Employee',
            //    'label' => 'Сотрудник',
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
                'data_class' => 'AppBundle\Entity\Armchair',
                'em' => null,
            )
        );
    }
}