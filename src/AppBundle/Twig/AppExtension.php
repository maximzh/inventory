<?php
/**
 * Created by PhpStorm.
 * User: fumus
 * Date: 03.04.16
 * Time: 11:38
 */

namespace AppBundle\Twig;

use Symfony\Bridge\Doctrine\RegistryInterface;
use AppBundle\Entity\Mac;

class AppExtension extends \Twig_Extension
{
    protected $doctrine;

    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction(
                'countFreeDevices',
                array($this, 'countFreeDevices'),
                array(
                    'needs_environment' => true,
                    'is_safe' => array('html'),
                )
            ),
        );
    }

    // $devices should be an ArrayCollection
    // of Mac, Armchair, Headphones, Keyboard, Monitor, Mouse or UsbHub

    public function countFreeDevices(\Twig_Environment $twig, $devices)
    {

        $count = 0;
        foreach ($devices as $device) {
            if (!$device->getEmployee()) {
                $count++;
            }
        }

        return $count;
    }

    public function getName()
    {
        return 'app_extension';
    }

}