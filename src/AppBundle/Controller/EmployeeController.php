<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Employee;
use AppBundle\Filter\EmployeeFilterType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class EmployeeController
 * @Route("/employees")
 *
 * @Security("has_role('ROLE_USER')")
 */
class EmployeeController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/filter", name="filter_employees")
     */
    public function employeeFilterAction(Request $request)
    {
        $form = $this->get('form.factory')->create(new EmployeeFilterType());

        if ($request->query->has($form->getName())) {
            // manually bind values from the request
            if ('employee_filter' == $form->getName())

                $form->submit($request->query->get($form->getName()));

            // initialize a query builder
            $filterBuilder = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Employee')
                ->createQueryBuilder('e');

            // build the query from the given form object
            $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);
            //var_dump($filterBuilder->getDql());

            $result = $filterBuilder
                ->getQuery()
                ->getResult();

        }

        return $this->render(
            '@App/Employee/filtered.html.twig',
            array(
                'employees' => $result,
            )
        );
    }

    /**
     * @param Employee $employee
     * @return Response
     *
     * @Route("/{id}", name="show_employee")
     *
     * @ParamConverter("employee", class="AppBundle:Employee")
     *
     * @Template()
     */
    public function showAction(Employee $employee)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
            $deleteForm = $this->get('app.form_generator')
                ->createEmployeeDeleteForm($employee)
                ->createView();

            return [
                'employee' => $employee,
                'deleteForm' => $deleteForm,
            ];
        }

        return [
            'employee' => $employee,
            'deleteForm' => null,
        ];
    }


}
