<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 * @Security("has_role('ROLE_USER')")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     *
     * @Method("GET")
     *
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $employees = $this->getDoctrine()
            ->getRepository('AppBundle:Employee')
            ->findAllEmployees();

        if (!$employees) {
            throw $this->createNotFoundException('Сотрудники не найдены');
        }


        return [
            'employees' => $employees,
        ];
    }

    /**
     * @param Request $request
     *
     * @Route("/search", name="search")
     *
     * @Method("GET")
     *
     * @Template()
     *
     * @return array
     */
    public function searchEmployeesAction(Request $request)
    {
        $result = $this->get('app.search_manager')->search($request);

        return [
            'employees' => $result['employees'],
            'search_text' => $result['search_text'],
        ];

    }
}
