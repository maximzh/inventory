<?php
/**
 * Created by PhpStorm.
 * User: fumus
 * Date: 21.03.16
 * Time: 13:35
 */

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\AnotherDevice;
use AppBundle\Entity\Employee;
use AppBundle\Entity\Monitor;
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
        if ($request->getMethod() == Request::METHOD_POST) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($employee);
                $em->flush();

                $this->addFlash(
                    'notice',
                    'Новый сотрудник добавлен.'
                );

                return $this->redirectToRoute('show_employee', ['id' => $employee->getId()]);
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
     * @param Employee $employee
     *
     * @Route("/{id}/free_mac", name="free_employee_mac")
     *
     * @ParamConverter("employee", class="AppBundle:Employee")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function freeEmployeeMacAction(Employee $employee)
    {
        $mac = $employee->getMac();
        if ($mac) {
            $em = $this->getDoctrine()->getManager();
            $mac->setEmployee(null);
            $employee->setMac(null);
            $em->flush();

            $this->addFlash(
                'notice',
                "Устройство освободилось"
            );
        }
        return $this->redirectToRoute('show_employee', ['id' => $employee->getId()]);
    }

    /**
     * @param Employee $employee
     *
     * @Route("/{id}/free_armchair", name="free_employee_armchair")
     *
     * @ParamConverter("employee", class="AppBundle:Employee")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function freeEmployeeArmchairAction(Employee $employee)
    {
        $armchair = $employee->getArmchair();
        if ($armchair) {
            $em = $this->getDoctrine()->getManager();
            $armchair->setEmployee(null);
            $employee->setArmchair(null);
            $em->flush();

            $this->addFlash(
                'notice',
                "Устройство освободилось"
            );
        }
        return $this->redirectToRoute('show_employee', ['id' => $employee->getId()]);
    }

    /**
     * @param Employee $employee
     *
     * @Route("/{id}/free_usbhub", name="free_employee_usbhub")
     *
     * @ParamConverter("employee", class="AppBundle:Employee")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function freeEmployeeUsbHubAction(Employee $employee)
    {
        $hub = $employee->getUsbHub();
        if ($hub) {
            $em = $this->getDoctrine()->getManager();
            $hub->setEmployee(null);
            $employee->setUsbHub(null);
            $em->flush();

            $this->addFlash(
                'notice',
                "Устройство освободилось"
            );
        }
        return $this->redirectToRoute('show_employee', ['id' => $employee->getId()]);
    }

    /**
     * @param Employee $employee
     *
     * @Route("/{id}/free_headphones", name="free_employee_headphones")
     *
     * @ParamConverter("employee", class="AppBundle:Employee")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function freeEmployeeHeadphonesAction(Employee $employee)
    {
        $headphones = $employee->getHeadphones();
        if ($headphones) {
            $em = $this->getDoctrine()->getManager();
            $headphones->setEmployee(null);
            $employee->setHeadphones(null);
            $em->flush();

            $this->addFlash(
                'notice',
                "Устройство освободилось"
            );
        }
        return $this->redirectToRoute('show_employee', ['id' => $employee->getId()]);
    }

    /**
     * @param Employee $employee
     *
     * @Route("/{id}/free_keyboard", name="free_employee_keyboard")
     *
     * @ParamConverter("employee", class="AppBundle:Employee")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function freeEmployeeKeyboardAction(Employee $employee)
    {
        $keyboard = $employee->getKeyboard();
        if ($keyboard) {
            $em = $this->getDoctrine()->getManager();
            $keyboard->setEmployee(null);
            $employee->setKeyboard(null);
            $em->flush();

            $this->addFlash(
                'notice',
                "Устройство освободилось"
            );
        }
        return $this->redirectToRoute('show_employee', ['id' => $employee->getId()]);
    }

    /**
     * @param Employee $employee
     *
     * @Route("/{id}/free_mouse", name="free_employee_mouse")
     *
     * @ParamConverter("employee", class="AppBundle:Employee")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function freeEmployeeMouseAction(Employee $employee)
    {
        $mouse = $employee->getMouse();
        if ($mouse) {
            $em = $this->getDoctrine()->getManager();
            $mouse->setEmployee(null);
            $employee->setMouse(null);
            $em->flush();

            $this->addFlash(
                'notice',
                "Устройство освободилось"
            );
        }
        return $this->redirectToRoute('show_employee', ['id' => $employee->getId()]);
    }

    /**
     * @param Employee $employee
     *
     * @Route("/{employee_id}/free_monitor/{monitor_id}", name="free_employee_monitor")
     *
     * @ParamConverter("employee", class="AppBundle:Employee", options={"mapping": {"employee_id": "id"}})
     * @ParamConverter("monitor", class="AppBundle:Monitor", options={"mapping": {"monitor_id": "id"}})
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function freeEmployeeMonitorAction(Employee $employee, Monitor $monitor)
    {

        $em = $this->getDoctrine()->getManager();
        $monitors = array();
        foreach ($employee->getMonitors() as $mon) {
            $monitors[] = $mon;
        }
        if (in_array($monitor, $monitors)) {
            $employee->removeMonitor($monitor);
            $em->flush();
            $this->addFlash(
                'notice',
                "Устройство освободилось"
            );
        }

        return $this->redirectToRoute('show_employee', ['id' => $employee->getId()]);
    }

    /**
     * @param Employee $employee
     *
     * @Route("/{employee_id}/free_device/{device_id}", name="free_employee_device")
     *
     * @ParamConverter("employee", class="AppBundle:Employee", options={"mapping": {"employee_id": "id"}})
     * @ParamConverter("device", class="AppBundle:AnotherDevice", options={"mapping": {"device_id": "id"}})
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function freeEmployeeDeviceAction(Employee $employee, AnotherDevice $device)
    {

        $em = $this->getDoctrine()->getManager();
        $devices = array();
        foreach ($employee->getAnotherDevices() as $anotherDevice) {
            $devices[] = $anotherDevice;
        }
        if (in_array($device, $devices)) {
            $employee->removeAnotherDevice($device);
            $em->flush();
            $this->addFlash(
                'notice',
                "Устройство освободилось"
            );
        }

        return $this->redirectToRoute('show_employee', ['id' => $employee->getId()]);
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
        $preparedData = $spreadSheetManager->prepareDataToValidate();
        $validator = $this->get('validator');
        $em = $this->getDoctrine()->getManager();

        $fail = 0;
        $success = 0;
        foreach ($preparedData as $item) {
            $errors = $validator->validate($item);

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
            "$success импортировано, $fail неудач(и)"
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

        return $this->redirectToRoute('show_employee', array('id' => $employee->getId()));
    }

}