<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Mouse;
use AppBundle\Entity\Monitor;
use AppBundle\Entity\Keyboard;
use AppBundle\Entity\Mac;
use AppBundle\Entity\Armchair;
use AppBundle\Entity\Headphones;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DeviceController extends Controller
{
    /**
     * @Route("/devices", name="devices")
     * @Template()
     */
    public function allDeviceAction(Request $request)
    {
        $mouses = $this->getDoctrine()->getRepository('AppBundle:Mouse')->findAll();
        $monitors = $this->getDoctrine()->getRepository('AppBundle:Monitor')->findAll();
        $keyboards = $this->getDoctrine()->getRepository('AppBundle:Keyboard')->findAll();
        $macs = $this->getDoctrine()->getRepository('AppBundle:Mac')->findAll();
        $armchairs = $this->getDoctrine()->getRepository('AppBundle:Armchair')->findAll();
        $headphones = $this->getDoctrine()->getRepository('AppBundle:Headphones')->findAll();
        $usbHubs = $this->getDoctrine()->getRepository('AppBundle:UsbHub')->findAll();
        $otherDevices = $this->getDoctrine()->getRepository('AppBundle:AnotherDevice')->findAll();
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

        return [
            'freeMacs' => $freeMacs,
            'freeMonitors' => $freeMonitors,
            'freeArmchairs' => $freeArmchairs,
            'freeKeyboards' => $freeKeyboards,
            'freeMouses' => $freeMouses,
            'freeHeadphones' => $freeHeadphones,
            'freeUsbHubs' => $freeUsbHubs,
        ];
    }
}
