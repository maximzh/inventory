<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Security("has_role('ROLE_USER')")
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
}
