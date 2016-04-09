<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UsbHubType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Название USB HUB',
                'required' => true,
                )
            )
            /*
            ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
                $hub = $event->getData();
                $form = $event->getForm();

                if (null == $hub->getEmployee()) {
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
                                ->where('u.employee IS NULL');
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
                'data_class' => 'AppBundle\Entity\UsbHub',
                'em' => null,
            )
        );
    }
}