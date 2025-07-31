<?php
namespace App\Controller;

use App\Entity\FlightBooking;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/visitor', name: 'visitor_')]
class VisitorController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
        
    }

    /**
     * This funciton return the flight booking records of the logged in user
     */
     #[Route('/dashboard', name: 'dashboard')]
    public function visitor()
    {
        $userId = $this->getUserId();

        $bookings = $this->em->getRepository(FlightBooking::class)->findBy(['user_id' => $userId]);
        
        return $this->render('visitor/dashboard.html.twig',[
            'bookings' => $bookings            
        ]);

    }

    /**
     * This function check user is logged in or not
     * If user logged in then return current logged in user id
     * else redirect to login page
     */
    public function getUserId()
    {
        $user = $this->getUser();

        if (!$user) {
           return $this->redirectToRoute('app_login');
        }
        return $user->getId();
    }


}