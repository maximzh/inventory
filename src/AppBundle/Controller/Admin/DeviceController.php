<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Armchair;
use AppBundle\Entity\Headphones;
use AppBundle\Entity\Keyboard;
use AppBundle\Entity\Mac;
use AppBundle\Entity\Monitor;
use AppBundle\Entity\Mouse;
use AppBundle\Entity\UsbHub;
use AppBundle\Form\ArmchairType;
use AppBundle\Form\HeadphonesType;
use AppBundle\Form\KeyboardType;
use AppBundle\Form\MacType;
use AppBundle\Form\MonitorType;
use AppBundle\Form\MouseType;
use AppBundle\Form\UsbHubType;
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
                return $this->redirect($this->generateUrl('devices', array('device' => $device)));
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
                return $this->redirect($this->generateUrl('devices', array('device' => $device)));
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
                return $this->redirect($this->generateUrl('devices', array('device' => $device)));
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
                return $this->redirect($this->generateUrl('devices', array('device' => $device)));
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
                return $this->redirect($this->generateUrl('devices', array('device' => $device)));
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

        $form = $this->createForm(ArmchairType::class, $device);
        $form->handleRequest($request);

        if($request->getMethod() == Request::METHOD_POST) {
            if ($form->isValid()) {
                $this->getDoctrine()->getManager()->flush();
                return $this->redirect($this->generateUrl('devices', array('device' => $device)));
            }
        }

        return [
            'device' => $device,
            'form_device' => $form->createView()
        ];
    }

    /**
     * @Route("/add-headphones", name="add-headphones")
     * @Template()
     *
     * @Method({"GET", "POST"})
     *
     */
    public function addHeadphonesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $device = new Headphones();
        $device->setType('Headphones');

        $form = $this->createForm(HeadphonesType::class, $device);
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

    /**
     * @Route("/edit-headphones/{id}", name="edit-headphones")
     * @Template()
     * @param $id
     *
     * @Method({"GET", "POST"})
     *
     * @return array
     */
    public function editHeadphonesAction(Request $request, $id)
    {
        $device = $this->getDoctrine()->getManager()->getRepository('AppBundle:Headphones')->find($id);

        $form = $this->createForm(HeadphonesType::class, $device);
        $form->handleRequest($request);

        if($request->getMethod() == Request::METHOD_POST) {
            if ($form->isValid()) {
                $this->getDoctrine()->getManager()->flush();
                return $this->redirect($this->generateUrl('devices', array('device' => $device)));
            }
        }

        return [
            'device' => $device,
            'form_device' => $form->createView()
        ];
    }

    /**
     * @Route("/add-keyboard", name="add-keyboard")
     * @Template()
     *
     * @Method({"GET", "POST"})
     *
     */
    public function addKeyboardAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $device = new Keyboard();
        $device->setType('Keyboard');

        $form = $this->createForm(KeyboardType::class, $device);
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

    /**
     * @Route("/edit-keyboard/{id}", name="edit-keyboard")
     * @Template()
     * @param $id
     *
     * @Method({"GET", "POST"})
     *
     * @return array
     */
    public function editKeyboardAction(Request $request, $id)
    {
        $device = $this->getDoctrine()->getManager()->getRepository('AppBundle:Keyboard')->find($id);

        $form = $this->createForm(KeyboardType::class, $device);
        $form->handleRequest($request);

        if($request->getMethod() == Request::METHOD_POST) {
            if ($form->isValid()) {
                $this->getDoctrine()->getManager()->flush();
                return $this->redirect($this->generateUrl('devices', array('device' => $device)));
            }
        }

        return [
            'device' => $device,
            'form_device' => $form->createView()
        ];
    }

    /**
     * @Route("/add-mouse", name="add-mouse")
     * @Template()
     *
     * @Method({"GET", "POST"})
     *
     */
    public function addMouseAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $device = new Mouse();
        $device->setType('Mouse');

        $form = $this->createForm(MouseType::class, $device);
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

    /**
     * @Route("/edit-mouse/{id}", name="edit-mouse")
     * @Template()
     * @param $id
     *
     * @Method({"GET", "POST"})
     *
     * @return array
     */
    public function editMouseAction(Request $request, $id)
    {
        $device = $this->getDoctrine()->getManager()->getRepository('AppBundle:Mouse')->find($id);

        $form = $this->createForm(MouseType::class, $device);
        $form->handleRequest($request);

        if($request->getMethod() == Request::METHOD_POST) {
            if ($form->isValid()) {
                $this->getDoctrine()->getManager()->flush();
                return $this->redirect($this->generateUrl('devices', array('device' => $device)));
            }
        }

        return [
            'device' => $device,
            'form_device' => $form->createView()
        ];
    }

    /**
     * @Route("/add-usbhub", name="add-usbhub")
     * @Template()
     *
     * @Method({"GET", "POST"})
     *
     */
    public function addUsbHubAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $device = new UsbHub();
        $device->setType('Usb Hub');

        $form = $this->createForm(UsbHubType::class, $device);
        $form->handleRequest($request);

        if($request->getMethod() == Request::METHOD_POST){
            if ($form->isValid()) {
                if($device->getEmployee() != null){
                    $device->setStatus('busy');
                }else{
                    $device->setStatus('free');
                }
                $em->persist($device);
                $em->flush();
                return $this->redirect($this->generateUrl('devices', array('device' => $device)));
            }
        }
        return ['form_device' => $form->createView()];
    }

    /**
     * @Route("/edit-usbhub/{id}", name="edit-usbhub")
     * @Template()
     * @param $id
     *
     * @Method({"GET", "POST"})
     *
     * @return array
     */
    public function editUsbHubAction(Request $request, $id)
    {
        $device = $this->getDoctrine()->getManager()->getRepository('AppBundle:UsbHub')->find($id);

        $form = $this->createForm(UsbHubType::class, $device);
        $form->handleRequest($request);

        if($request->getMethod() == Request::METHOD_POST) {
            if ($form->isValid()) {
                $this->getDoctrine()->getManager()->flush();
                return $this->redirect($this->generateUrl('devices', array('device' => $device)));
            }
        }

        return [
            'device' => $device,
            'form_device' => $form->createView()
        ];
    }
}
