<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Employee;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class EmployeeController
 * @Route("/employees")
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
        if (!$employee) {
            throw $this->createNotFoundException('Сотрудник не найден');
        }

        return [
            'employee' => $employee,
        ];
    }
}
