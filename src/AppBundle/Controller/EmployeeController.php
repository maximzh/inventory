<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Employee;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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

            return  [
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
