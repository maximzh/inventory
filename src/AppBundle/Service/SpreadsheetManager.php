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
            $fullNameFromTable = strtolower($entry->getValues()['name']);

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
            $fullName = $item['name'];
            $array = explode(' ', $fullName);
            if (2 == count($array)) {
                $lastName = $array[0];
                $firstName = $array[1];
            } else {
                throw new \Exception('Wrong name format');
            }
            $position = $item['position'];
            $startDateString = $item['startdate'];
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
        $worksheet = $this->getWorksheet(self::SPREADSHEET_TITLE, self::WORKSHEET_TITLE);
        $listFeed = $worksheet->getListFeed();
        $entries = $listFeed->getEntries();
        $employeeFullName = $employee->getLastName().' '.$employee->getFirstName();
        $employeeStartDate = $employee->getEmployeeSince()->format("d.m.Y");
        foreach ($entries as $entry) {

            if ($employeeFullName == $entry->getValues()['name']
                && $employeeStartDate == $entry->getValues()['startdate']
            ) {

                $entry->update(array('position' => $employee->getPosition()));

                return true;
            }
        }
        $row = array(
            'name' => $employeeFullName,
            'startdate' => $employeeStartDate,
            'position' => $employee->getPosition(),
        );
        $listFeed->insert($row);

        return true;
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

                if ($entryValues['name'] == $employeeName && $entryValues['startdate'] == $startDate) {
                    $entry->update(array('position' => $employeePosition));
                    unset($employees[$key]);
                }
            }
        }
        // if employee not exists in google table, create a new row
        while (!empty($employees)) {
            $employee = array_shift($employees);

            $date = $employee->getEmployeeSince()
                ->format("d.m.Y");
            $name = $employee->getLastName().' '.$employee->getFirstName();
            $position = $employee->getPosition();

            $row = array('name' => $name, 'startdate' => $date, 'position' => $position);
            $listFeed->insert($row);
        }
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