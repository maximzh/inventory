<?php
/**
 * Created by PhpStorm.
 * User: fumus
 * Date: 21.03.16
 * Time: 13:14
 */

namespace AppBundle\Form;

use AppBundle\Entity\Employee;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;


class EmployeeType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName', TextType::class, array(
                'label' => 'Фамилия*',
                'required' => false,
                )
            )
            ->add('firstName', TextType::class,
                array(
                    'label' => 'Имя*',
                    'required' => false,
                    )
            )
            ->add('fatherName', TextType::class, array(
                'label' => 'Отчество',
                'required' => false,
                )
            )
            ->add('employeeSince', DateType::class, array(
                'label' => 'Дата приема на работу*',
                'years' => range(2001, 2021)
            )
            )
            ->add('position', TextType::class, array(
                'label' => 'Должность*',
                'required' => false,
                )
            )
            /*
            ->add('monitors', EntityType::class,[
                'class' => 'AppBundle\Entity\Monitor',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('m')
                        ->select('m, e')
                        ->leftJoin('m.employee', 'e')
                        //->leftJoin('e.keyboard', 'k')
                        //->leftJoin('e.usbHub', 'u')
                        //->leftJoin('e.mac', 'mc')
                        //->leftJoin('e.mouse', 'ms')
                        //->leftJoin('e.headphones', 'h')
                        //->leftJoin('e.monitors', 'mo')
                        ->where('m.employee IS NULL');
                },
                'required' => false,
                'label' => 'Монитор'
            ])
            */

            ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
                $employee = $event->getData();
                $form = $event->getForm();

               /*
                if (!$employee || null === $employee->getId()) {
                    $form->add('name', TextType::class);
                }
               */

                if (null == $employee->getArmchair()) {
                    $form->add('armchair', EntityType::class,[
                        'class' => 'AppBundle\Entity\Armchair',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('a')
                                ->select('a, e')
                                ->leftJoin('a.employee', 'e')
                                ->where('e.armchair IS NULL');
                        },
                        'required' => false,
                        'label' => 'Кресло'
                    ]);
                }
                if (null == $employee->getMac()) {
                    $form->add('mac', EntityType::class,[
                        'class' => 'AppBundle\Entity\Mac',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('m')
                                ->select('m, e')
                                ->leftJoin('m.employee', 'e')
                                ->where('e.mac IS NULL');
                        },
                        'required' => false,
                        'label' => 'Mac Mini'
                    ]);
                }
                if (null == $employee->getUsbHub()) {
                    $form->add('usbHub', EntityType::class,[
                        'class' => 'AppBundle\Entity\UsbHub',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('u')
                                ->select('u, e')
                                ->leftJoin('u.employee', 'e')
                                ->where('e.usbHub IS NULL');
                        },
                        'required' => false,
                        'label' => 'Usb Hub'
                    ]);
                }
                /** @var Employee $employee */
                if (null == $employee->getHeadphones()) {
                    $form->add('headphones', EntityType::class,[
                        'class' => 'AppBundle\Entity\Headphones',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('h')
                                ->select('h, e')
                                ->leftJoin('h.employee', 'e')
                                ->where('e.headphones IS NULL');
                        },
                        'required' => false,
                        'label' => 'Наушники'
                    ]);
                }
                /** @var Employee $employee */
                if (null == $employee->getKeyboard()) {
                    $form->add('keyboard', EntityType::class,[
                        'class' => 'AppBundle\Entity\Keyboard',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('k')
                                ->select('k, e')
                                ->leftJoin('k.employee', 'e')
                                ->where('e.keyboard IS NULL');
                        },
                        'required' => false,
                        'label' => 'Клавиатура'
                    ]);
                }
                /** @var Employee $employee */
                if (null == $employee->getMouse()) {
                    $form->add('mouse', EntityType::class,[
                        'class' => 'AppBundle\Entity\Mouse',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('m')
                                ->select('m, e')
                                ->leftJoin('m.employee', 'e')
                                ->where('e.mouse IS NULL');
                        },
                        'required' => false,
                        'label' => 'Мышь'
                    ]);
                }
            })



            /*
            ->add('mac', EntityType::class, array(
                'class' => 'AppBundle\Entity\Mac',
                 'choice_label' => function ($mac) {
                     return $mac->getName().' Ram:'.$mac->getRam().' Gb';
                 },
                 'label' => 'Mac Mini',
                 'multiple' => false,
                 'expanded' => false,
                 'required' => false,
                 'query_builder' => function (EntityRepository $er) {
                     return $er->createQueryBuilder('m')
                         ->select('m')
                         ->where('m.status = :status')
                         ->setParameter('status', 'free');
                 }
                 )
            )

            ->add('armchair', EntityType::class, array(
                    'class' => 'AppBundle\Entity\Armchair',
                    'choice_label' => function ($armchair) {
                        return $armchair->getName();
                    },
                    'label' => 'Кресло',
                    'multiple' => false,
                    'expanded' => false,
                    'required' => false,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('a')
                            ->select('a')
                            ->where('a.status = :status')
                            ->setParameter('status', 'free');
                    }
                )
            )
            ->add('usbHub', EntityType::class, array(
                    'class' => 'AppBundle\Entity\UsbHub',
                    'choice_label' => function ($usbHub) {
                        return $usbHub->getName();
                    },
                    'label' => 'USB Hub',
                    'multiple' => false,
                    'expanded' => false,
                    'required' => false,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->select('u')
                            ->where('u.status = :status')
                            ->setParameter('status', 'free');
                    }
                )
            )
            ->add('headphones', EntityType::class, array(
                    'class' => 'AppBundle\Entity\Headphones',
                    'choice_label' => function ($headphones) {
                        return $headphones->getName();
                    },
                    'label' => 'Наушники',
                    'multiple' => false,
                    'expanded' => false,
                    'required' => false,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('h')
                            ->select('h')
                            ->where('h.status = :status')
                            ->setParameter('status', 'free');
                    }
                )
            )
            ->add('keyboard', EntityType::class, array(
                    'class' => 'AppBundle\Entity\Keyboard',
                    'choice_label' => function ($keyboard) {
                        return $keyboard->getName();
                    },
                    'label' => 'Клавиатура',
                    'multiple' => false,
                    'expanded' => false,
                    'required' => false,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('k')
                            ->select('k')
                            ->where('k.status = :status')
                            ->setParameter('status', 'free');
                    }
                )
            )
            ->add('mouse', EntityType::class, array(
                    'class' => 'AppBundle\Entity\Mouse',
                    'choice_label' => function ($mouse) {
                        return $mouse->getName();
                    },
                    'label' => 'Мышь',
                    'multiple' => false,
                    'expanded' => false,
                    'required' => false,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('m')
                            ->select('m')
                            ->where('m.status = :status')
                            ->setParameter('status', 'free');
                    }
                )
            )
            ->add('monitors', EntityType::class, array(
                    'class' => 'AppBundle\Entity\Monitor',
                    'choice_label' => function ($monitor) {
                        return $monitor->getName().' Screen size: '.$monitor->getDiagonal();
                    },
                    'label' => 'Мониторы',
                    'multiple' => true,
                    'expanded' => false,
                    'required' => false,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('m')
                            ->select('m')
                            ->where('m.status = :status')
                            ->setParameter('status', 'free');
                    }
                )
            )
            */
            ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'AppBundle\Entity\Employee',
                'em' => null,
            )
        );
    }

    public function getBlockPrefix()
    {
        return "employee";
    }
}