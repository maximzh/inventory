<?php
/**
 * Created by PhpStorm.
 * User: fumus
 * Date: 21.03.16
 * Time: 13:35
 */

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Employee;
use AppBundle\Form\EmployeeType;
use Google\Spreadsheet\SpreadsheetService;
use Google_Auth_AssertionCredentials;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Google\Spreadsheet\DefaultServiceRequest;
use Google\Spreadsheet\ServiceRequestFactory;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class EmployeeController
 * @Route("/admin/employees")
 *
 */
class EmployeeController extends Controller
{
    /**
     * @param Request $request
     *
     *
     * @Route("/new", name="new_employee")
     *
     * @Template()
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function newAction(Request $request)
    {
        $employee = new Employee();
        $form = $this->createForm(
            EmployeeType::class,
            $employee,
            array(
                'method' => 'POST',
            )
        );
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($employee);
                $em->flush();

                $this->addFlash(
                    'notice',
                    'Новый сотрудник успешно добавлен.'
                );

                return $this->redirectToRoute('homepage');
            }
        }

        return [
            'employee' => $employee,
            'form' => $form->createView(),
        ];

    }

    /**
     * @param Request $request
     * @param Employee $employee
     *
     * @Route("/edit/{id}", name="edit_employee", requirements={"id": "\d+"})
     *
     * @Method({"GET", "POST"})
     *
     * @Template()
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(Request $request, Employee $employee)
    {
        $editForm = $this->createForm(EmployeeType::class, $employee);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash(
                'notice',
                'Данные сотрудника были изменены.'
            );

            return $this->redirectToRoute('show_employee', ['id' => $employee->getId()]);
        }

        return [
            'employee' => $employee,
            'edit_form' => $editForm->createView(),
        ];

    }

    /**
     * @param Request $request
     * @param Employee $employee
     *
     * @Route("/remove/{id}", name="remove_employee", requirements={"id": "\d+"})
     *
     * @Method("DELETE")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeAction(Request $request, Employee $employee)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->get('app.form_generator')
            ->createEmployeeDeleteForm($employee);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em->remove($employee);
            $em->flush();
        }

        $this->addFlash(
            'notice',
            'Сотрудник был успешно удален.'
        );

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     *
     * @Route("/export")
     */
    public function importAction()
    {
        //$user = $this->getUser();
        //$accessToken = $user->getGoogleAccessToken();

        $client = new \Google_Client();
        //$client->setApplicationName('Invent');
        //$clientId = "116075106357728342687";
        //$client->setClientId($clientId);


        $cred = new Google_Auth_AssertionCredentials(
            "invent-1264@appspot.gserviceaccount.com",
            array('https://spreadsheets.google.com/feeds'),
            file_get_contents('Invent.p12', FILE_USE_INCLUDE_PATH)
        );
        $client->setAssertionCredentials($cred);

        if($client->isAccessTokenExpired()) {
            $client->getAuth()->refreshTokenWithAssertion($cred);
        }

        $obj_token  = json_decode($client->getAccessToken());
        $accessToken = $obj_token->access_token;

        $serviceRequest = new DefaultServiceRequest($accessToken);
        ServiceRequestFactory::setInstance($serviceRequest);

        $spreadsheetService = new SpreadsheetService();
        $spreadsheetFeed = $spreadsheetService->getSpreadsheets();

        $spreadsheet = $spreadsheetFeed->getByTitle('Employees');
        $worksheetFeed = $spreadsheet->getWorksheets();
        $worksheet = $worksheetFeed->getByTitle('sheet');

        $listFeed = $worksheet->getListFeed();

        $entries = $listFeed->getEntries();
        $listEntry = $entries[0];
        $values = $listEntry->getValues();

        //return new Response(var_dump($values));

        $row = array('name'=>'hfjufg', 'position'=>'wascdorsker');
        $listFeed->insert($row);
        return new Response();

    }

}