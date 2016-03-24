<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Device;
use AppBundle\Form\DeviceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

///**
// * Class DeviceController
// *
// * @Security("has_role('ROLE_SUPER_ADMIN')")
// *
// * @Route("/admin/devices")
// *
// */
class DeviceController extends Controller
{
    /**
     * @Route("/devices", name="devices")
     * @Template()
     */
    public function allDeviceAction(Request $request)
    {
        $devices = $this->getDoctrine()->getRepository('AppBundle:Device')->findAll();
        return ['devices' => $devices];
    }
}
