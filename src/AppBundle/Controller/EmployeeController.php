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
        if (!$employee) {
            throw $this->createNotFoundException('Сотрудник не найден');
        }

        return [
            'employee' => $employee,
        ];
    }

    /**
     * @param Request $request
     * @param Employee $employee
     *
     * @Route("/remove/{id}", name="remove_employee")
     *
     * @Method("DELETE")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeAction(Request $request, Employee $employee)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->get('app.form_generator')
            ->createEmployeeDeleteForm($employee);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em->remove($employee);
            $em->flush();
        }

        return $this->redirectToRoute('homepage');
    }
}
