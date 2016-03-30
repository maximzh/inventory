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
        return [
            'mouses' => $mouses,
            'monitors' => $monitors,
            'keyboards' => $keyboards,
            'macs' => $macs,
            'armchairs' => $armchairs,
            'headphones' => $headphones,
            'usbhubs' => $usbHubs,
        ];
    }
}
