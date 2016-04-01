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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
        $spreadsheetManager = $this->get('app.spreadsheet_manager');
        $em = $this->getDoctrine()->getManager();
        $form = $this->get('app.form_generator')
            ->createEmployeeDeleteForm($employee);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $spreadsheetManager->deleteOneRow($employee);
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
     * @return array
     *
     * @Route("/show_new_worksheet_data", name="show_new_entries")
     *
     * @Template()
     */
    public function showNewGoogleTableDataAction()
    {
        $spreadsheetManager = $this->get('app.spreadsheet_manager');
        $data = $spreadsheetManager->getNewDataFromGoogleTable();

        return [
            'new' => $data
        ];
    }

    /**
     * @Route("/import", name="import_from_google_table")
     *
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     *
     */
    public function importAction()
    {
        $spreadSheetManager = $this->get('app.spreadsheet_manager');
        $preparedData = $spreadSheetManager->prepareDataToImport();
        $validator = $this->get('validator');
        $em = $this->getDoctrine()->getManager();

        foreach ($preparedData as $item) {
            $errors = $validator->validate($item);
            $fail = 0;
            $success = 0;
            if (0 == count($errors)) {
                $em->persist($item);
                $success++;
            } else {
                $fail++;
            }
        }
        $em->flush();

        $this->addFlash(
            'notice',
            "$success imported, $fail failed"
            );

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     *
     * @Route("/export", name="export_all")
     */
    public function exportAllAction()
    {
        $spreadsheetManager = $this->get('app.spreadsheet_manager');
        $spreadsheetManager->exportAllEmployees();

        $this->addFlash(
            'notice',
            'Сотрудники экспотрированы в Google таблицу'
        );

        return $this->redirectToRoute('homepage');
    }

    /**
     * @param Employee $employee
     *
     * @Route("/export/{id}", name="export_one", requirements={"id": "\d+"})
     *
     * @ParamConverter("employee", class="AppBundle:Employee")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function exportOneAction(Employee $employee)
    {
        $spreadsheetManager = $this->get('app.spreadsheet_manager');
        $spreadsheetManager->exportOne($employee);

        $this->addFlash(
            'notice',
            'Сотрудник экспотрирован в Google таблицу'
        );

        return $this->redirectToRoute('homepage');
    }

}