<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\AnotherDevice;
use AppBundle\Entity\Armchair;
use AppBundle\Entity\Headphones;
use AppBundle\Entity\Keyboard;
use AppBundle\Entity\Mac;
use AppBundle\Entity\Monitor;
use AppBundle\Entity\Mouse;
use AppBundle\Entity\UsbHub;
use AppBundle\Form\AnotherDeviceType;
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
     * @Route("/add-device", name="add-device")
     * @Template()
     * @Method({"GET", "POST"})
     *
     */
    public function addAnotherDeviceAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $device = new AnotherDevice();
        //$device->setType('Monitor');

        $form = $this->createForm(AnotherDeviceType::class, $device);
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
     * @Route("/edit-device/{id}", name="edit-device")
     * @Template()
     * @param $id
     *
     * @Method({"GET", "POST"})
     *
     * @return array
     */
    public function editAnotherDeviceAction(Request $request, $id)
    {
        $device = $this->getDoctrine()->getManager()->getRepository('AppBundle:AnotherDevice')->find($id);

        $form = $this->createForm(AnotherDeviceType::class, $device);
        $form->handleRequest($request);

        if($request->getMethod() == Request::METHOD_POST) {
            if ($form->isValid()) {
                $this->getDoctrine()->getManager()->flush();
                return $this->redirect($this->generateUrl('devices', array('device' => $device)));
                //return $this->redirectToRoute('devices');
            }
        }

        return [
            'device' => $device,
            'form_device' => $form->createView()
        ];
    }

    /**
     * @param Request $request
     *
     * @Route("/remove-device/{id}", name="remove_device", requirements={"id": "\d+"})
     *
     * @Method("DELETE")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeAnotherDeviceAction(Request $request, AnotherDevice $device)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->get('app.form_generator')
            ->createAnotherDeviceDeleteForm($device);

        $form->handleRequest($request);
        if ($form->isValid()) {
            if ($employee = $device->getEmployee()) {
                $device->setEmployee(null);
            }
            $em->remove($device);
            $em->flush();

            $this->addFlash(
                'notice',
                'Устройство удалено.'
            );
        }
        return $this->redirectToRoute('devices');

    }
    
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
     * @param Request $request
     *
     * @Route("/remove-monitor/{id}", name="remove_monitor", requirements={"id": "\d+"})
     *
     * @Method("DELETE")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeMonitorAction(Request $request, Monitor $monitor)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->get('app.form_generator')
            ->createMonitorDeleteForm($monitor);

        $form->handleRequest($request);
        if ($form->isValid()) {
            if ($employee = $monitor->getEmployee()) {
                $monitor->setEmployee(null);
            }
            $em->remove($monitor);
            $em->flush();

            $this->addFlash(
                'notice',
                'Монитор удален.'
            );
        }
        return $this->redirectToRoute('devices');

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
     * @param Request $request
     * @param Mac $mac
     *
     * @Route("/remove-mac/{id}", name="remove_mac", requirements={"id": "\d+"})
     *
     * @Method("DELETE")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeMacAction(Request $request, Mac $mac)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->get('app.form_generator')
            ->createMacDeleteForm($mac);

        $form->handleRequest($request);
        if ($form->isValid()) {
            if ($employee = $mac->getEmployee()) {
                $employee->setMac(null);
            }
            $em->remove($mac);
            $em->flush();

            $this->addFlash(
                'notice',
                'Mac Mini удален.'
            );
        }
        return $this->redirectToRoute('devices');

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
     * @param Request $request
     * @param Armchair $armchair
     *
     * @Route("/remove-armchair/{id}", name="remove_armchair", requirements={"id": "\d+"})
     *
     * @Method("DELETE")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeArmchairAction(Request $request, Armchair $armchair)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->get('app.form_generator')
            ->createArmchairDeleteForm($armchair);

        $form->handleRequest($request);
        if ($form->isValid()) {
            if ($employee = $armchair->getEmployee()) {
                $employee->setArmchair(null);
            }
            $em->remove($armchair);
            $em->flush();

            $this->addFlash(
                'notice',
                'Кресло удалено.'
            );
        }
        return $this->redirectToRoute('devices');

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
     * @param Request $request
     *
     * @Route("/remove-headphones/{id}", name="remove_headphones", requirements={"id": "\d+"})
     *
     * @Method("DELETE")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeHeadphonesAction(Request $request, Headphones $headphones)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->get('app.form_generator')
            ->createHeadphonesDeleteForm($headphones);

        $form->handleRequest($request);
        if ($form->isValid()) {
            if ($employee = $headphones->getEmployee()) {
                $employee->setHeadphones(null);
            }
            $em->remove($headphones);
            $em->flush();

            $this->addFlash(
                'notice',
                'Наушники удалены.'
            );
        }
        return $this->redirectToRoute('devices');

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
     * @param Request $request
     *
     * @Route("/remove-keyboard/{id}", name="remove_keyboard", requirements={"id": "\d+"})
     *
     * @Method("DELETE")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeKeyboardAction(Request $request, Keyboard $keyboard)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->get('app.form_generator')
            ->createKeyboardDeleteForm($keyboard);

        $form->handleRequest($request);
        if ($form->isValid()) {
            if ($employee = $keyboard->getEmployee()) {
                $employee->setKeyboard(null);
            }
            $em->remove($keyboard);
            $em->flush();

            $this->addFlash(
                'notice',
                'Клавиатура удалена.'
            );
        }
        return $this->redirectToRoute('devices');

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
     * @param Request $request
     *
     * @Route("/remove-mouse/{id}", name="remove_mouse", requirements={"id": "\d+"})
     *
     * @Method("DELETE")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeMouseAction(Request $request, Mouse $mouse)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->get('app.form_generator')
            ->createMouseDeleteForm($mouse);

        $form->handleRequest($request);
        if ($form->isValid()) {
            if ($employee = $mouse->getEmployee()) {
                $employee->setMouse(null);
            }
            $em->remove($mouse);
            $em->flush();

            $this->addFlash(
                'notice',
                'Мышь удалена.'
            );
        }
        return $this->redirectToRoute('devices');

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

    /**
     * @param Request $request
     *
     * @Route("/remove-usbhub/{id}", name="remove_usbhub", requirements={"id": "\d+"})
     *
     * @Method("DELETE")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeUsbHubAction(Request $request, UsbHub $usbHub)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->get('app.form_generator')
            ->createUsbHubDeleteForm($usbHub);

        $form->handleRequest($request);
        if ($form->isValid()) {
            if ($employee = $usbHub->getEmployee()) {
                $employee->setUsbHub(null);
            }
            $em->remove($usbHub);
            $em->flush();

            $this->addFlash(
                'notice',
                'Usb Hub удален.'
            );
        }
        return $this->redirectToRoute('devices');

    }
}
