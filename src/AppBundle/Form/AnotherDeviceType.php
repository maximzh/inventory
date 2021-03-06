<?php
/**
 * Created by PhpStorm.
 * User: fumus
 * Date: 09.04.16
 * Time: 15:39
 */

namespace AppBundle\Form;

use AppBundle\Entity\AnotherDevice;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;


class AnotherDeviceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                    'label' => 'Название',
                    'required' => false,
                )
            )
            ->add('type', ChoiceType::class,
                array(
                    'choices' => array(
                        'Мебель' => AnotherDevice::FURNITURE_DEVICE,
                        'Электронное устройство' => AnotherDevice::ELECTRONIC_DEVICE,
                        'Офисная техника' => AnotherDevice::TECHNICS_DEVICE,
                        'Другое' => AnotherDevice::ANOTHER_DEVICE,
                    ),
                    'choices_as_values' => true,
                    'label' => 'Тип устройств',
                    'required' => false,
                )
            )
            ->add('status', ChoiceType::class,
                array(
                    'choices' => array(
                        'Новое' => AnotherDevice::STATUS_NEW,
                        'Старое' => AnotherDevice::STATUS_OLD,
                        'После ремонта' => AnotherDevice::STATUS_FIXED,
                        'Исправное' => AnotherDevice::STATUS_OK,
                        'Сломаное' => AnotherDevice::STATUS_BROKEN,
                    ),
                    'choices_as_values' => true,
                    'label' => 'Состояние',
                    'required' => false,
                )
            )
            ->add('description', TextType::class, array(
                    'label' => 'Описание',
                    'required' => false,
                )
            )
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $device = $event->getData();
                $form = $event->getForm();

                if (null == $device->getEmployee()) {
                    $form->add('employee', EntityType::class, [
                        'class' => 'AppBundle\Entity\Employee',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->select('e, a, k, u, mc, ms, h, mo, an')
                                ->leftJoin('e.armchair', 'a')
                                ->leftJoin('e.keyboard', 'k')
                                ->leftJoin('e.usbHub', 'u')
                                ->leftJoin('e.mac', 'mc')
                                ->leftJoin('e.mouse', 'ms')
                                ->leftJoin('e.headphones', 'h')
                                ->leftJoin('e.monitors', 'mo')
                                ->leftJoin('e.anotherDevices', 'an');
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
                'data_class' => 'AppBundle\Entity\AnotherDevice',
                'em' => null,
            )
        );
    }
}