<?php

namespace App\Services;

use App\Entity\FlightBooking;
use Doctrine\ORM\EntityManagerInterface;

class Admin
{
    public function __construct(private EntityManagerInterface $em)
    {
        
    }

    
}