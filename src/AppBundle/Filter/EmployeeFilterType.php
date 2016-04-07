<?php
/**
 * Created by PhpStorm.
 * User: fumus
 * Date: 26.03.16
 * Time: 22:48
 */

namespace AppBundle\Filter;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderExecuterInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\DateRangeFilterType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;


class EmployeeFilterType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /*
            ->add('firstName', Filters\TextFilterType::class, array(
                'condition_pattern' => FilterOperands::STRING_CONTAINS,
                'label' => 'Имя'
            ))
            ->add('fatherName', Filters\TextFilterType::class, array(
                'condition_pattern' => FilterOperands::STRING_CONTAINS,
                'label' => 'Отчество'
            ))
            ->add('lastName', Filters\TextFilterType::class, array(
                'condition_pattern' => FilterOperands::STRING_CONTAINS,
                'label' => 'Фамилия'
            ))
            ->add('position', Filters\TextFilterType::class, array(
                'condition_pattern' => FilterOperands::STRING_CONTAINS,
                'label' => 'Позиция'
                ))
            */
            ->add('employeeSince', DateRangeFilterType::class, array(
                'label' => 'Принят на работу (в период):',
                'left_date_options' => array(
                    'label' => 'От:',
                    'years' => range(2001, 2021),
                    'data' => new \DateTime('2001-01-01')
                ),
                'right_date_options' => array(
                    'label' => 'До:',
                    'years' => range(2001, 2021),
                    'data' => new \DateTime('2021-01-01')
                )

            ))
            ->add('monitorsNumber', Filters\NumberFilterType::class, array(
                //'condition_pattern' => FilterOperands::OPERATOR_EQUAL,
                'label' => 'Кол-во мониторов'
            ))
            ->add('monitors', Filters\CollectionAdapterFilterType::class, array(
                'label' => ' ',
                'entry_type' => new MonitorFilterType(),
                'add_shared' => function (FilterBuilderExecuterInterface $qbe)  {
                    $closure = function (QueryBuilder $filterBuilder, $alias, $joinAlias, Expr $expr) {
                        // add the join clause to the doctrine query builder
                        // the where clause for the label and color fields will be added automatically with the right alias later by the Lexik\Filter\QueryBuilderUpdater
                        $filterBuilder->leftJoin($alias . '.monitors', $joinAlias);
                    };
                    // then use the query builder executor to define the join and its alias.
                    $qbe->addOnce($qbe->getAlias().'.monitors', 'mon', $closure);
                },

            ))
            ->add('armchair', Filters\EntityFilterType::class, array(
                'label' => 'Кресло',
                'class' => 'AppBundle\Entity\Armchair'
            ))
            ->add('mac', Filters\EntityFilterType::class, array(
                'label' => 'Mac Mini',
                'class' => 'AppBundle\Entity\Mac'
            ))
            ->add('usbHub', Filters\EntityFilterType::class, array(
                'label' => 'Usb Hub',
                'class' => 'AppBundle\Entity\UsbHub'
            ))
            /*
            ->add('armchair', Filters\CollectionAdapterFilterType::class, array(
                'label' => 'Кресло',
                'entry_type' => new ArmchairFilterType(),
                'add_shared' => function (FilterBuilderExecuterInterface $qbe)  {
                    $closure = function (QueryBuilder $filterBuilder, $alias, $joinAlias, Expr $expr) {
                        // add the join clause to the doctrine query builder
                        // the where clause for the label and color fields will be added automatically with the right alias later by the Lexik\Filter\QueryBuilderUpdater
                        $filterBuilder->leftJoin($alias . '.armchair', $joinAlias);
                    };
                    // then use the query builder executor to define the join and its alias.
                    $qbe->addOnce($qbe->getAlias().'.armchair', 'a', $closure);
                },

            ))
            */
        ;
    }

    public function getBlockPrefix()
    {
        return 'employee_filter';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            //'data_class' => 'AppBundle\Entity\Employee',
            'error_bubbling'    => true,
            'csrf_protection'   => false,
            'validation_groups' => array('filtering'),// avoid NotBlank() constraint-related message
            'method'            => 'get',
        ));
    }
}