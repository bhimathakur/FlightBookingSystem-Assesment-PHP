<?php

namespace App\Services;

use App\Entity\FlightBooking as EntityFlightBooking;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\VarDumper\VarDumper;

class FlightBooking
{
    public function __construct(
        private EntityManagerInterface $em,
        private ContainerBagInterface $params
        )
    {
        
    }

    /**
     * This function return the flight booking based on the search parameters
     */
    public function getFlightBookingRecords($searchParameters): array
    {
        $searchResult = $this->em->getRepository(EntityFlightBooking::class)->searchResult($searchParameters);
        $bookings = [];
        foreach ($searchResult as $result) {
            $booking = [
                'flight_from' => $result->getFlightFrom(),
                'flight_to' => $result->getFlightTo(),
                'departure_date' => $result->getDepartureDate()->format('Y-m-d'),
                'name' => $result->getUserId()->getFirstName(),
                'airline' => $result->getAirlineId()->getName(),
            ];
            $bookings[] = $booking;
        }
        return $bookings;
    }

    /**
     * This function create the csv file and save then return the file name.
     */
    public function createCsvFileAndSave($searchParameters): string
    {
        $bookings = $this->getFlightBookingRecords($searchParameters);
        $headersData = [
            "column1" => "Flight From",
            "column2" => "Flight To",
            "column3" => "Departure Date",
            "column4" => "Name",
            "column5" => "Airline"
        ];
        $directory = $this->params->get('kernel.project_dir') . '/public/csv';
        $fileName = 'data_' . date('YmdHis') . '.csv';
        $filepath = $directory . '/' . $fileName;

        $handle = fopen($filepath, 'w');

        fputcsv($handle, array_values($headersData)); // Write header row

        foreach ($bookings as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);
        return $fileName;

    }
}