<?php

namespace App\Controller;

use App\Entity\Airline;
use App\Entity\FlightBooking;
use App\Services\Admin;
use App\Services\FlightBooking as ServicesFlightBooking;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\VarDumper\VarDumper;

#[Route('/admin', '')]
class AdminController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private ServicesFlightBooking $flightBookingService
    ) {}

    /**
     * This function return all the flight booking records
     */
    #[Route('/dashboard', name: 'admin_dashboard')]
    public function list()
    {
        $bookings = $this->em->getRepository(FlightBooking::class)->findAllBooking();
        $airlines = $this->em->getRepository(Airline::class)->findActiveAirlines();

        return $this->render('admin/dashboard.html.twig', [
            'bookings' => $bookings,
            'airlines' => $airlines

        ]);
    }



    /**
     * This funciton return the flight booking record based on the search parameters
     */
    #[Route('/search', name: 'search_result', methods: ['POST'])]
    public function search(Request $request)
    {
        $bookings = $this->flightBookingService->getFlightBookingRecords($request->request->all());

        return new JsonResponse(['bookings' => $bookings], Response::HTTP_OK);
    }

    


    /**
     * This function generate the csv file based on searched parameters and return the file name.
     */
    #[Route('/export_csv', name: 'export_csv', methods: ['POST', 'GET'])]
    public function exportCsv(Request $request)
    {
        $fileName = $this->flightBookingService->createCsvFileAndSave($request->request->all());
        
        return new JsonResponse(['filename' => $fileName], Response::HTTP_OK);
    }

    /**
     * This funciton download csv file 
     */
    #[Route('/download_csv/{filename}', name: 'download-csv')]
    public function downloadCsv(string $filename): Response
    {
        $filePath = $this->getParameter('kernel.project_dir') . '/public/csv/' . $filename;

        if (!file_exists($filePath)) {
            throw $this->createNotFoundException('The file does not exist');
        }

        $response = new Response();
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $filename . '"');
        $response->headers->set('Content-Length', filesize($filePath));

        $response->setContent(file_get_contents($filePath));

        return $response;
    }
}
