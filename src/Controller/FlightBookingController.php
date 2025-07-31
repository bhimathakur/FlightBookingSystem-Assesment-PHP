<?php
namespace App\Controller;

use App\Entity\FlightBooking;
use App\Entity\User;
use App\Form\FlightBookingType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\VarDumper\VarDumper;

/**
 * This class manage flight booking add/edit
 */
#[Route('/booking', name:'')]
class FlightBookingController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
        
    }


    /**
     * This function add the flight booking details in database
     */
    #[Route('/add', name:'booking_add')]
    public function add(Request $request)
    {
        $flghtBooking = new FlightBooking();
        $form = $this->createForm(FlightBookingType::class, $flghtBooking);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $flghtBooking->setUserId($this->getUser());
            $flghtBooking->setDate(new DateTime());
            $this->em->persist($flghtBooking);
            $this->em->flush();

            return $this->redirectToRoute('visitor_dashboard');

        }
        return $this->render('flight_booking/add.html.twig', [
            'bookingForm' => $form
        ]);       

    }

    /**
     * This funciton update the flight booking details and update into database
     */
    #[Route('/edit/{id}', name: 'booking_edit')]
    public function edit(Request $request, $id)
    {

        $loggedInUserId = $this->getUserId();

        $flghtBooking = $this->em->getRepository(FlightBooking::class)->find($id);
        $userId = $flghtBooking->getUserId()->getId();
        if($loggedInUserId !== $userId) {
            return $this->redirectToRoute('visitor_dashboard');
        }
        $form = $this->createForm(FlightBookingType::class, $flghtBooking);
        $form->handleRequest($request);
         if($form->isSubmitted() && $form->isValid()){

            $this->em->persist($flghtBooking);
            $this->em->flush();
            return $this->redirectToRoute('visitor_dashboard');
        }

        return $this->render('flight_booking/edit.html.twig',['flightBooking' => $form
            
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