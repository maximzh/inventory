<?php
/**
 * Created by PhpStorm.
 * User: fumus
 * Date: 22.03.16
 * Time: 11:27
 */

namespace AppBundle\Service;


use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Request;

class SearchManager
{
    protected $doctrine;

    public function __construct( RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function search(Request $request)
    {
        $text = strip_tags(trim($request->get('search_text')));

        if ($text == null or $text == '') {
            return;
        }

        $employees = $this->doctrine
            ->getRepository('AppBundle:Employee')
            ->searchEmployees($text);

        return [
            'employees' => $employees,
            'search_text' => $text,
        ];

    }

}