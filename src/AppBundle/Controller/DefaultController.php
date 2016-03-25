<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
        $query = $this->getDoctrine()->getRepository('AppBundle:Employee')
            ->findAllEmployeesQuery();

        $pagination = $this->get('knp_paginator')
            ->paginate($query, $request->query->getInt('page', 1), 100);

        return [
            'employees' => $pagination,
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
