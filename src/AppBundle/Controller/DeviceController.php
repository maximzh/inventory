<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AnotherDevice;
use AppBundle\Entity\Mouse;
use AppBundle\Entity\Monitor;
use AppBundle\Entity\Keyboard;
use AppBundle\Entity\Mac;
use AppBundle\Entity\Armchair;
use AppBundle\Entity\Headphones;
use AppBundle\Entity\UsbHub;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class DeviceController extends Controller
{
    /**
     * @Route("/devices", name="devices")
     * @Template()
     */
    public function allDeviceAction(Request $request)
    {
        $mouses = $this->getDoctrine()->getRepository('AppBundle:Mouse')->findAllOrdered();
        $monitors = $this->getDoctrine()->getRepository('AppBundle:Monitor')->findAllOrdered();
        $keyboards = $this->getDoctrine()->getRepository('AppBundle:Keyboard')->findAllOrdered();
        $macs = $this->getDoctrine()->getRepository('AppBundle:Mac')->findAllOrdered();
        $armchairs = $this->getDoctrine()->getRepository('AppBundle:Armchair')->findAllOrdered();
        $headphones = $this->getDoctrine()->getRepository('AppBundle:Headphones')->findAllOrdered();
        $usbHubs = $this->getDoctrine()->getRepository('AppBundle:UsbHub')->findAllOrdered();
        $otherDevices = $this->getDoctrine()->getRepository('AppBundle:AnotherDevice')->findAllOrdered();
        return [
            'mouses' => $mouses,
            'monitors' => $monitors,
            'keyboards' => $keyboards,
            'macs' => $macs,
            'armchairs' => $armchairs,
            'headphones' => $headphones,
            'usbhubs' => $usbHubs,
            'other' => $otherDevices,
        ];
    }

    /**
     * @param Mac $mac
     *
     * @Route("/devices/show/mac/{id}", name="show_mac", requirements={"id": "\d+"})
     *
     * @ParamConverter("mac", class="AppBundle:Mac")
     *
     * @Template()
     * @return array
     */
    public function showMacAction(Mac $mac)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
            $deleteForm = $this->get('app.form_generator')
                ->createMacDeleteForm($mac)
                ->createView();

            return [
                'mac' => $mac,
                'deleteForm' => $deleteForm,
            ];
        }

        return [
            'employee' => $mac,
            'deleteForm' => null,
        ];
    }

    /**
     * @param Armchair $armchair
     *
     * @Route("/devices/show/armchair/{id}", name="show_armchair", requirements={"id": "\d+"})
     *
     * @ParamConverter("armchair", class="AppBundle:Armchair")
     *
     * @Template()
     * @return array
     */
    public function showArmchairAction(Armchair $armchair)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
            $deleteForm = $this->get('app.form_generator')
                ->createArmchairDeleteForm($armchair)
                ->createView();

            return [
                'armchair' => $armchair,
                'deleteForm' => $deleteForm,
            ];
        }

        return [
            'armchair' => $armchair,
            'deleteForm' => null,
        ];
    }

    /**
     * @param Monitor $monitor
     *
     * @Route("/devices/show/monitor/{id}", name="show_monitor", requirements={"id": "\d+"})
     *
     * @ParamConverter("monitor", class="AppBundle:Monitor")
     *
     * @Template()
     * @return array
     */
    public function showMonitorAction(Monitor $monitor)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
            $deleteForm = $this->get('app.form_generator')
                ->createMonitorDeleteForm($monitor)
                ->createView();

            return [
                'monitor' => $monitor,
                'deleteForm' => $deleteForm,
            ];
        }

        return [
            'monitor' => $monitor,
            'deleteForm' => null,
        ];
    }

    /**
     * @param UsbHub $usbHub
     *
     * @Route("/devices/show/usbhub/{id}", name="show_usbhub", requirements={"id": "\d+"})
     *
     * @ParamConverter("usbHub", class="AppBundle:UsbHub")
     *
     * @Template()
     * @return array
     */
    public function showUsbHubAction(UsbHub $usbHub)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
            $deleteForm = $this->get('app.form_generator')
                ->createUsbHubDeleteForm($usbHub)
                ->createView();

            return [
                'usbHub' => $usbHub,
                'deleteForm' => $deleteForm,
            ];
        }

        return [
            'usbHub' => $usbHub,
            'deleteForm' => null,
        ];
    }

    /**
     * @param Keyboard $keyboard
     * 
     * @return array
     *
     * @Route("/devices/show/keyboard/{id}", name="show_keyboard", requirements={"id": "\d+"})
     *
     * @ParamConverter("keyboard", class="AppBundle:Keyboard")
     *
     * @Template()
     */
    public function showKeyboardAction(Keyboard $keyboard)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
            $deleteForm = $this->get('app.form_generator')
                ->createKeyboardDeleteForm($keyboard)
                ->createView();

            return [
                'keyboard' => $keyboard,
                'deleteForm' => $deleteForm,
            ];
        }

        return [
            'keyboard' => $keyboard,
            'deleteForm' => null,
        ];
    }

    /**
     *
     * @param Headphones $headphones
     * @return array
     * @Route("/devices/show/headphones/{id}", name="show_headphones", requirements={"id": "\d+"})
     *
     * @ParamConverter("headphones", class="AppBundle:Headphones")
     *
     * @Template()
     */
    public function showHeadphonesAction(Headphones $headphones)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
            $deleteForm = $this->get('app.form_generator')
                ->createHeadphonesDeleteForm($headphones)
                ->createView();

            return [
                'headphones' => $headphones,
                'deleteForm' => $deleteForm,
            ];
        }

        return [
            'headphones' => $headphones,
            'deleteForm' => null,
        ];
    }

    /**
     *
     * @return array
     * @Route("/devices/show/mouse/{id}", name="show_mouse", requirements={"id": "\d+"})
     *
     * @ParamConverter("mouse", class="AppBundle:Mouse")
     *
     * @Template()
     */
    public function showMouseAction(Mouse $mouse)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
            $deleteForm = $this->get('app.form_generator')
                ->createMouseDeleteForm($mouse)
                ->createView();

            return [
                'mouse' => $mouse,
                'deleteForm' => $deleteForm,
            ];
        }

        return [
            'mouse' => $mouse,
            'deleteForm' => null,
        ];
    }

    /**
     *
     * @return array
     * @Route("/devices/show/other/{id}", name="show_device", requirements={"id": "\d+"})
     *
     * @ParamConverter("device", class="AppBundle:AnotherDevice")
     *
     * @Template()
     */
    public function showAnotherDeviceAction(AnotherDevice $device)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
            $deleteForm = $this->get('app.form_generator')
                ->createAnotherDeviceDeleteForm($device)
                ->createView();

            return [
                'device' => $device,
                'deleteForm' => $deleteForm,
            ];
        }

        return [
            'device' => $device,
            'deleteForm' => null,
        ];
    }

    /**
     * @Route("/devices/available_monitors", name="available_monitors")
     *
     * @Template()
     */
    public function showFreeMonitorsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $freeMonitors = $em->getRepository('AppBundle:Monitor')
            ->findFreeMonitors();

        return [
            'freeMonitors' => $freeMonitors,
        ];
    }


    /**
     * @Route("/devices/available", name="available_devices")
     *
     * @Template()
     */
    public function showAvailableDeviceAction()
    {
        $em = $this->getDoctrine()->getManager();
        $freeMacs = $em->getRepository('AppBundle:Mac')
            ->findFreeMacs();

        $freeMonitors = $em->getRepository('AppBundle:Monitor')
            ->findFreeMonitors();

        $freeArmchairs = $em->getRepository('AppBundle:Armchair')
            ->findFreeArmchairs();

        $freeKeyboards = $em->getRepository('AppBundle:Keyboard')
            ->findFreeKeyboards();

        $freeMouses = $em->getRepository('AppBundle:Mouse')
            ->findFreeMouses();

        $freeHeadphones = $em->getRepository('AppBundle:Headphones')
            ->findFreeHeadphones();

        $freeUsbHubs = $em->getRepository('AppBundle:UsbHub')
            ->findFreeUsbHubs();
        
        $freeAnotherDevices = $em->getRepository('AppBundle:AnotherDevice')
            ->findFreeDevices();

        return [
            'freeMacs' => $freeMacs,
            'freeMonitors' => $freeMonitors,
            'freeArmchairs' => $freeArmchairs,
            'freeKeyboards' => $freeKeyboards,
            'freeMouses' => $freeMouses,
            'freeHeadphones' => $freeHeadphones,
            'freeUsbHubs' => $freeUsbHubs,
            'freeAnotherDevices' => $freeAnotherDevices,
        ];
    }
}
