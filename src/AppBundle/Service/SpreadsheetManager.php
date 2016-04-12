<?php
/**
 * Created by PhpStorm.
 * User: fumus
 * Date: 29.03.16
 * Time: 11:48
 */

namespace AppBundle\Service;


use AppBundle\Entity\Employee;
use Google\Spreadsheet\DefaultServiceRequest;
use Google\Spreadsheet\ServiceRequestFactory;
use Google\Spreadsheet\SpreadsheetService;
use Google_Auth_AssertionCredentials;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;

class SpreadsheetManager
{
    // move to parameters in prod
    const SCOPE = 'https://spreadsheets.google.com/feeds';
    const SPREADSHEET_TITLE = 'Employees';
    const WORKSHEET_TITLE = 'sheet';

    const EMPLOYEE_NAME_COLUMN = 'name';
    const EMPLOYEE_STARTDATE_COLUMN = 'startdate';
    const EMPLOYEE_POSITION_COLUMN = 'position';
    const MONITORS_COLUMN = 'monitors';
    const RAM_MACMINI_COLUMN = 'rammacmini';
    const SSD_MACMINI_COLUMN = 'ssd';
    const SOFT_CHAIR_COLUMN = 'softchair';
    const USB_HUB_COLUMN = 'startdate';


    protected $doctrine;
    protected $router;
    protected $googleClientEmail;
    protected $privateKeyPath;


    public function __construct(
        RegistryInterface $doctrine,
        RouterInterface $router,
        $googleServiceEmail,
        $privateKeyPath
    ) {
        $this->doctrine = $doctrine;
        $this->router = $router;
        $this->googleServiceEmail = $googleServiceEmail;
        $this->privateKeyPath = $privateKeyPath;

    }

    public function getNewDataFromGoogleTable()
    {
        $worksheet = $this->getWorksheet(self::SPREADSHEET_TITLE, self::WORKSHEET_TITLE);
        $listFeed = $worksheet->getListFeed();
        $entries = $listFeed->getEntries();
        $new = array();

        $employees = $this->doctrine->getRepository('AppBundle:Employee')
            ->findAll();

        foreach ($entries as $key => $entry) {
            $fullNameFromTable = strtolower($entry->getValues()[self::EMPLOYEE_NAME_COLUMN]);
            //$startDate = \DateTime::createFromFormat('d.m.Y', $entry->getValues()['startdate']);
            //$position = $entry->getValues()['position'];

            foreach ($employees as $employee) {
                $nameFromDB = strtolower($employee->getLastName().' '.$employee->getFirstName());
                if ($fullNameFromTable == $nameFromDB) {
                    unset($entries[$key]);
                    break;
                }
            }
        }
        foreach ($entries as $entry) {
            $new[] = $entry->getValues();
        }

        return $new;
    }

    public function prepareDataToImport()
    {
        $dataToImport = $this->getNewDataFromGoogleTable();
        $preparedData = array();

        foreach ($dataToImport as $item) {
            $fullName = $item[self::EMPLOYEE_NAME_COLUMN];
            $array = explode(' ', $fullName);
            if (2 == count($array)) {
                $lastName = $array[0];
                $firstName = $array[1];
            } else {
                throw new \Exception('Wrong name format');
            }
            $position = $item[self::EMPLOYEE_POSITION_COLUMN];
            $startDateString = $item[self::EMPLOYEE_STARTDATE_COLUMN];
            $startDate = \DateTime::createFromFormat('d.m.Y', $startDateString);

            $employee = new Employee();
            $employee->setLastName($lastName);
            $employee->setFirstName($firstName);
            $employee->setPosition($position);
            $employee->setEmployeeSince($startDate);

            $preparedData[] = $employee;
        }

        return $preparedData;
    }



    public function exportOne(Employee $employee)
    {
        $listFeed = $this->getListFeed();
        $entry = $this->findEmployeeInWorksheet($employee);
        if ( !$entry) {
            $row = $this->getEmployeeData($employee);
            $listFeed->insert($row);

            return true;
        }
        $entry->update($this->getEmployeeData($employee));

        return true;
    }

    public function deleteOneRow(Employee $employee)
    {
        $entry = $this->findEmployeeInWorksheet($employee);

        if (!$entry) {
            return false;
        } else {
            $entry->delete();

            return true;
        }
    }

    public function exportAllEmployees()
    {
        $employees = $this->doctrine
            ->getRepository('AppBundle:Employee')
            ->findAll();
        if (!$employees) {
            throw new NotFoundHttpException('Сотрудники в БД не найдены');
        }

        $worksheet = $this->getWorksheet(self::SPREADSHEET_TITLE, self::WORKSHEET_TITLE);

        $listFeed = $worksheet->getListFeed();
        $entries = $listFeed->getEntries();

        foreach ($entries as $entry) {
            // if employee already exists in google table, we update existing row
            $entryValues = $entry->getValues();

            foreach ($employees as $key => $employee) {
                $employeeName = $employee->getLastName().' '.$employee->getFirstName();
                $employeePosition = $employee->getPosition();
                $startDate = $employee->getEmployeeSince()->format("d.m.Y");

                if ($entryValues[self::EMPLOYEE_NAME_COLUMN] == $employeeName && $entryValues[self::EMPLOYEE_STARTDATE_COLUMN] == $startDate) {
                    $entry->update($this->getEmployeeData($employee));
                    unset($employees[$key]);
                }
            }
        }
        // if employee not exists in google table, create a new row
        while (!empty($employees)) {
            $employee = array_shift($employees);
            $row = $this->getEmployeeData($employee);

            $listFeed->insert($row);
        }
    }

    private function getEmployeeData(Employee $employee)
    {
        $countMonitors = 0;
        $name = $employee->getLastName().' '.$employee->getFirstName();
        $position = $employee->getPosition();
        $startDate = $employee->getEmployeeSince()->format('d.m.Y');
        $ram = 0;
        $ssd = 0;
        $softChair = 0;
        $usbHub = 0;

        if ($employee->getMonitors()) {
            $countMonitors = count($employee->getMonitors());
        }

        if ($mac = $employee->getMac()) {
            $ram = $mac->getRam();
            if ($mac->getSsd()) {
                $ssd = $mac->getSsd();
            }
        }

        if ($employee->getArmchair()) {
            $softChair = 1;
        }

        if ($employee->getUsbHub()) {
            $usbHub =1;
        }

        return [
            self::EMPLOYEE_NAME_COLUMN => $name,
            self::EMPLOYEE_STARTDATE_COLUMN => $startDate,
            self::EMPLOYEE_POSITION_COLUMN => $position,
            self::MONITORS_COLUMN => $countMonitors,
            self::RAM_MACMINI_COLUMN => $ram,
            self::SSD_MACMINI_COLUMN => $ssd,
            self::SOFT_CHAIR_COLUMN => $softChair,
            self::USB_HUB_COLUMN => $usbHub,
        ];

    }


    private function getListFeed()
    {
        $worksheet = $this->getWorksheet(self::SPREADSHEET_TITLE, self::WORKSHEET_TITLE);
        $listFeed = $worksheet->getListFeed();

        return $listFeed;
    }

    private function findEmployeeInWorksheet(Employee $employee)
    {
        $listFeed = $this->getListFeed();
        $entries = $listFeed->getEntries();
        $employeeFullName = $employee->getLastName().' '.$employee->getFirstName();
        $employeeStartDate = $employee->getEmployeeSince()->format("d.m.Y");

        foreach ($entries as $entry) {
            if ($employeeFullName == $entry->getValues()[self::EMPLOYEE_NAME_COLUMN] && $employeeStartDate == $entry->getValues()[self::EMPLOYEE_STARTDATE_COLUMN]) {

                return $entry;
            }
        }

        return false;
    }

    private function getWorksheet($spreadsheetTitle, $worksheetTitle)
    {
        $client = new \Google_Client();

        $cred = new Google_Auth_AssertionCredentials(
            $this->googleServiceEmail,
            array(self::SCOPE),
            file_get_contents($this->privateKeyPath, FILE_USE_INCLUDE_PATH)
        );
        $client->setAssertionCredentials($cred);

        if ($client->isAccessTokenExpired()) {
            $client->getAuth()->refreshTokenWithAssertion($cred);
        }

        $obj_token = json_decode($client->getAccessToken());
        $accessToken = $obj_token->access_token;

        $serviceRequest = new DefaultServiceRequest($accessToken);
        ServiceRequestFactory::setInstance($serviceRequest);

        $spreadsheetService = new SpreadsheetService();

        //$this->spreadsheetService = $spreadsheetService;

        if (!$spreadsheetService) {
            throw new \Exception('Error getting Spreadsheet Service. ');
        }

        $spreadsheetFeed = $spreadsheetService
            ->getSpreadsheets();
        if (!$spreadsheetFeed) {
            throw new \Exception('Cant get Spreadsheets');
        }

        $spreadsheet = $spreadsheetFeed
            ->getByTitle($spreadsheetTitle);
        if (!$spreadsheet) {
            throw new \Exception('Wrong Spreadsheep title');
        }


        $worksheetFeed = $spreadsheet
            ->getWorksheets();
        if (!$worksheetFeed) {
            throw new \Exception("cant get worksheets in spreadsheet");
        }

        $worksheet = $worksheetFeed
            ->getByTitle($worksheetTitle);
        if (!$worksheet) {
            throw new \Exception('Wrong workship title');
        }

        return $worksheet;
    }

}