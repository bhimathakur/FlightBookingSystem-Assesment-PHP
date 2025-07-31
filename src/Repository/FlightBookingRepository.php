<?php

namespace App\Repository;

use App\Entity\FlightBooking;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Parameter;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\VarDumper\VarDumper;

/**
 * @extends ServiceEntityRepository<FlightBooking>
 */
class FlightBookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FlightBooking::class);
    }

    /**
     * This funciton retun those flight whose departure date is greater or equal to current date.
     */
    public function findAllBooking()
    {
        $curretDate = new DateTime();
        return $this->createQueryBuilder('fb')
        ->where('fb.departure_date >= :currentDate')
        ->setParameter('currentDate', $curretDate)
        ->getQuery()
        ->getResult();
    }

    /**
     * This function return the flight booking records based on the search parameters
     */
    public function searchResult($parameters)
    {
       
        $qb = $this->createQueryBuilder('fb');

        if(!empty($parameters['flight_from'])) {
            $qb->where('fb.flight_from = :flightFrom')
            ->setParameter('flightFrom', $parameters['flight_from']);
        }

        if(!empty($parameters['flight_to'])) {
            $qb->andWhere('fb.flight_to = :flightTo')
            ->setParameter('flightTo', $parameters['flight_to']);
        }
        
        if(!empty($parameters['departure_date_from'])) {
            $qb->andWhere('fb.departure_date >= :departureDateFrom')
            ->setParameter('departureDateFrom', $parameters['departure_date_from']);
        }
        if(!empty($parameters['departure_date_to'])) {
            $qb->andWhere('fb.departure_date <= :departureDateTo')
            ->setParameter('departureDateTo', $parameters['departure_date_to']);
        }
        
        if(!empty($parameters['airline'])) {
            $qb->andWhere('fb.airline_id = :airline')
            ->setParameter('airline', $parameters['airline']);
        }
        return $qb->getQuery()->getResult();
    }

    //    /**
    //     * @return FlightBooking[] Returns an array of FlightBooking objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?FlightBooking
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
