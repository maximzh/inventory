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


class HeadphonesType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Название наушников',
                'required' => true,
                )
            )
            /*
            ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
                $headphones = $event->getData();
                $form = $event->getForm();

                if (null == $headphones->getEmployee()) {
                    $form->add('employee', EntityType::class,[
                        'class' => 'AppBundle\Entity\Employee',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->select('e, h, a, k , u, mc, ms, mo')
                                ->leftJoin('e.headphones', 'h')
                                ->leftJoin('e.armchair', 'a')
                                ->leftJoin('e.keyboard', 'k')
                                ->leftJoin('e.usbHub', 'u')
                                ->leftJoin('e.mac', 'mc')
                                ->leftJoin('e.mouse', 'ms')
                                ->leftJoin('e.monitors', 'mo')
                                ->where('h.employee IS NULL');
                        },
                        'required' => false,
                        'label' => 'Сотрудник'
                    ]);
                }
            })
            */
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
                'data_class' => 'AppBundle\Entity\Headphones',
                'em' => null,
            )
        );
    }
}