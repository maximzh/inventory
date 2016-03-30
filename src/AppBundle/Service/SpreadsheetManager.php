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
    const SERVICE_EMAIL = 'invent-1264@appspot.gserviceaccount.com';
    const SPREADSHEET_TITLE = 'Employees';
    const WORKSHEET_TITLE = 'sheet';

    protected $doctrine;
    protected $spreadsheetService;

    public function __construct(RegistryInterface $doctrine, RouterInterface $router)
    {
        $this->doctrine = $doctrine;
        $this->router = $router;
        $this->setSpreadsheetService();
    }

    public function exportAllEmployees()
    {
        $employees = $this->doctrine
            ->getRepository('AppBundle:Employee')
            ->findAll();
        if (!$employees) {
            throw new NotFoundHttpException('Сотрудники в БД не найдены');
        }

        $spreadsheetFeed = $this->spreadsheetService
            ->getSpreadsheets();
        if (!$spreadsheetFeed) {
            throw new \Exception('Cant get Spreadsheets');
        }

        $spreadsheet = $spreadsheetFeed
            ->getByTitle(self::SPREADSHEET_TITLE);
        if (!$spreadsheet) {
            throw new \Exception('Wrong Spreadsheep title');
        }


        $worksheetFeed = $spreadsheet
            ->getWorksheets();
        if (!$worksheetFeed) {
            throw new \Exception("cant get worksheets in spreadsheet");
        }

        $worksheet = $worksheetFeed
            ->getByTitle(self::WORKSHEET_TITLE);
        if (!$worksheet) {
            throw new \Exception('Wrong workship title');
        }

        $listFeed = $worksheet->getListFeed();

        foreach ($employees as $key => $employee) {
            $date = $employee->getEmployeeSince();
            $date = $date->format("d.m.Y");
            $row = array(
                'name' => $employee->getLastName().' '.$employee->getFirstName(),
                'position' => $employee->getPosition(),
                'startdate' => $date
            );

            $listFeed->insert($row);
            unset($employees[$key]);
        }
        return true;
    }



    private function setSpreadsheetService()
    {
        $client = new \Google_Client();

        $cred = new Google_Auth_AssertionCredentials(
            self::SERVICE_EMAIL,
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

        return $this->spreadsheetService;

        //return $spreadsheetService;
    }

}