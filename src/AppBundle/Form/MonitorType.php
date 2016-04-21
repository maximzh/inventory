<?php

namespace AppBundle\Form;

use AppBundle\Entity\Monitor;
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


class MonitorType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                    'label' => 'Марка монитора',
                    'required' => false,
                )
            )
            ->add('diagonal', IntegerType::class, array(
                    'label' => 'Диагональ монитора',
                    'required' => false,
                )
            )
            ->add('status', ChoiceType::class, array(
                    'label' => 'Состояние',
                    'required' => false,
                    'choices' => array(
                        'Исправный' => Monitor::STATUS_OK,
                        'Сломанный' => Monitor::STATUS_BROKEN,
                        'После ремонта' => Monitor::STATUS_FIXED,
                    ),
                    'choices_as_values' => true,
                )
            )
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $monitor = $event->getData();
                $form = $event->getForm();

                if (null == $monitor->getEmployee()) {
                    $form->add('employee', EntityType::class, [
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
                                ->leftJoin('e.monitors', 'mo');
                        },
                        'required' => false,
                        'label' => 'Сотрудник'
                    ]);
                }
            });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'AppBundle\Entity\Monitor',
                'em' => null,
            )
        );
    }
}