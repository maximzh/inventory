<?php
/**
 * Created by PhpStorm.
 * User: fumus
 * Date: 29.03.16
 * Time: 11:48
 */

namespace AppBundle\Service;


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
    const PRIVATE_KEY = __DIR__.'/../Resources/google/Invent.p12';
    const SCOPE = 'https://spreadsheets.google.com/feeds';
    const SPREADSHEET_TITLE = 'Employees';
    const WORKSHEET_TITLE = 'sheet';

    protected $doctrine;
    protected $router;
    protected $googleServiceEmail;


    public function __construct(RegistryInterface $doctrine,
        RouterInterface $router,
        $googleServiceEmail
    )
    {
        $this->doctrine = $doctrine;
        $this->router = $router;
        $this->googleServiceEmail = $googleServiceEmail;

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

        while (!empty($employees)) {
            $employee = array_shift($employees);
            $date = $employee->getEmployeeSince()
                ->format("d.m.Y");
            $name = $employee->getLastName().' '.$employee->getFirstName();
            $position = $employee->getPosition();
            $row = array('name' => $name, 'startdate' => $date, 'position' => $position);
            $listFeed->insert($row);
        }
        /*
        foreach ($employees as $employee) {

            $date = $employee->getEmployeeSince();
            $date = $date->format("d.m.Y");
            $row = array(
                'name' => $employee->getLastName().' '.$employee->getFirstName(),
                'position' => $employee->getPosition(),
                'startdate' => $date
            );

            $listFeed->insert($row);
        }
        */
    }

    private function getWorksheet($spreadsheetTitle, $worksheetTitle)
    {
        $client = new \Google_Client();

        $cred = new Google_Auth_AssertionCredentials(
            $this->googleServiceEmail,
            array(self::SCOPE),
            file_get_contents(self::PRIVATE_KEY, FILE_USE_INCLUDE_PATH)
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



    private function setSpreadsheetService()
    {
        $client = new \Google_Client();

        $cred = new Google_Auth_AssertionCredentials(
            $this->googleServiceEmail,
            array(self::SCOPE),
            file_get_contents(self::PRIVATE_KEY, FILE_USE_INCLUDE_PATH)
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

        $this->spreadsheetService = $spreadsheetService;

        if (!$spreadsheetService) {
            throw new \Exception('Error getting Spreadsheet Service. ');
        }

        //return $this->spreadsheetService;

        //return $spreadsheetService;
    }

}