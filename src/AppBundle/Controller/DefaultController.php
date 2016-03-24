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
        $em = $this->getDoctrine()->getManager();
        $dql = "SELECT e FROM AppBundle:Employee e";
        $query = $em->createQuery($dql);

        $pager = $this->get('knp_paginator');
        $pagination = $pager->paginate($query, $request->query->getInt('page', 1), 50);

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
