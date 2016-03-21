<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{
    public function indexAction()
    {
        return new Response('hello');
    }
}
