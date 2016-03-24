<?php

namespace AppBundle\Controller\Admin;

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
     * @Route("/add-device", name="add-device")
     * @Template()
     */
    public function addDeviceAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $device = new Device();

        $form = $this->createForm(DeviceType::class, $device);
        $form->handleRequest($request);

        if($request->getMethod() == Request::METHOD_POST){
            if ($form->isValid()) {
                $em->persist($device);
                $em->flush();
                return $this->redirect($this->generateUrl('devices', array('device' => $device)));
            }
        }
        return ['form_device' => $form->createView()];
    }

//    /**
//     * @Route("/edit-device", name="edit-device")
//     * @Template()
//     */
//    public function editDeviceAction(Request $request)
//    {
//        $em = $this->getDoctrine()->getManager();
//        $device = new Device();
//
//        $form = $this->createForm(DeviceType::class, $device);
//        $form->handleRequest($request);
//
//        if($request->getMethod() == Request::METHOD_POST){
//            if ($form->isValid()) {
//                $em->persist($device);
//                $em->flush();
//                return $this->redirect($this->generateUrl('devices', array('device' => $device)));
//            }
//        }
//        return ['form_device' => $form->createView()];
//    }
}
