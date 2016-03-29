<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Armchair;
use AppBundle\Entity\Mac;
use AppBundle\Entity\Monitor;
use AppBundle\Form\ArmchairType;
use AppBundle\Form\MacType;
use AppBundle\Form\MonitorType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DeviceController
 * @Route("/admin/devices")
 *
 */
class DeviceController extends Controller
{
    /**
     * @Route("/add-monitor", name="add-monitor")
     * @Template()
     *
     * @Method({"GET", "POST"})
     *
     */
    public function addMonitorAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $device = new Monitor;
        $device->setType('Monitor');

        $form = $this->createForm(MonitorType::class, $device);
        $form->handleRequest($request);

        if($request->getMethod() == Request::METHOD_POST){
            if ($form->isValid()) {
                $em->persist($device);
                $em->flush();
                return $this->redirect($this->generateUrl('homepage', array('device' => $device)));
            }
        }
        return ['form_device' => $form->createView()];
    }

    /**
     * @Route("/edit-monitor/{id}", name="edit-monitor")
     * @Template()
     * @param $id
     *
     * @Method({"GET", "POST"})
     *
     * @return array
     */
    public function editMonitorAction(Request $request, $id)
    {
        $device = $this->getDoctrine()->getManager()->getRepository('AppBundle:Monitor')->find($id);

        $form = $this->createForm(MonitorType::class, $device);
        $form->handleRequest($request);

        if($request->getMethod() == Request::METHOD_POST) {
            if ($form->isValid()) {
                $this->getDoctrine()->getManager()->flush();
                return $this->redirect($this->generateUrl('homepage', array('device' => $device)));
            }
        }

        return [
            'device' => $device,
            'form_device' => $form->createView()
        ];
    }

    /**
     * @Route("/add-mac", name="add-mac")
     * @Template()
     *
     * @Method({"GET", "POST"})
     *
     */
    public function addMacAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $device = new Mac();
        $device->setType('Mac');

        $form = $this->createForm(MacType::class, $device);
        $form->handleRequest($request);

        if($request->getMethod() == Request::METHOD_POST){
            if ($form->isValid()) {
                $em->persist($device);
                $em->flush();
                return $this->redirect($this->generateUrl('homepage', array('device' => $device)));
            }
        }
        return ['form_device' => $form->createView()];
    }

    /**
     * @Route("/edit-mac/{id}", name="edit-mac")
     * @Template()
     * @param $id
     *
     * @Method({"GET", "POST"})
     *
     * @return array
     */
    public function editMacAction(Request $request, $id)
    {
        $device = $this->getDoctrine()->getManager()->getRepository('AppBundle:Mac')->find($id);

        $form = $this->createForm(MacType::class, $device);
        $form->handleRequest($request);

        if($request->getMethod() == Request::METHOD_POST) {
            if ($form->isValid()) {
                $this->getDoctrine()->getManager()->flush();
                return $this->redirect($this->generateUrl('homepage', array('device' => $device)));
            }
        }

        return [
            'device' => $device,
            'form_device' => $form->createView()
        ];
    }

    /**
     * @Route("/add-armchair", name="add-armchair")
     * @Template()
     *
     * @Method({"GET", "POST"})
     *
     */
    public function addArmchairAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $device = new Armchair();
        $device->setType('Armchair');

        $form = $this->createForm(ArmchairType::class, $device);
        $form->handleRequest($request);

        if($request->getMethod() == Request::METHOD_POST){
            if ($form->isValid()) {
                $em->persist($device);
                $em->flush();
                return $this->redirect($this->generateUrl('homepage', array('device' => $device)));
            }
        }
        return ['form_device' => $form->createView()];
    }

    /**
     * @Route("/edit-armchair/{id}", name="edit-armchair")
     * @Template()
     * @param $id
     *
     * @Method({"GET", "POST"})
     *
     * @return array
     */
    public function editArmchairAction(Request $request, $id)
    {
        $device = $this->getDoctrine()->getManager()->getRepository('AppBundle:Armchair')->find($id);

        $form = $this->createForm(MacType::class, $device);
        $form->handleRequest($request);

        if($request->getMethod() == Request::METHOD_POST) {
            if ($form->isValid()) {
                $this->getDoctrine()->getManager()->flush();
                return $this->redirect($this->generateUrl('homepage', array('device' => $device)));
            }
        }

        return [
            'device' => $device,
            'form_device' => $form->createView()
        ];
    }
}
