<?php

namespace App\Entity;

use App\Repository\FlightBookingRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FlightBookingRepository::class)]
class FlightBooking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: 'Please enter flight from field')]
    #[ORM\Column(length: 255)]
    private ?string $flight_from = null;

    #[Assert\NotBlank(message: 'Please enter flight to field')]

    #[ORM\Column(length: 255)]
    private ?string $flight_to = null;

    #[Assert\NotBlank(message: 'Please select departure date')]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $departure_date = null;

    #[ORM\ManyToOne(inversedBy: 'flightBookings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Airline $airline_id = null;

    #[ORM\ManyToOne(inversedBy: 'flightBookings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFlightFrom(): ?string
    {
        return $this->flight_from;
    }

    public function setFlightFrom(string $flight_from): static
    {
        $this->flight_from = $flight_from;

        return $this;
    }

    public function getFlightTo(): ?string
    {
        return $this->flight_to;
    }

    public function setFlightTo(string $flight_to): static
    {
        $this->flight_to = $flight_to;

        return $this;
    }

    public function getDepartureDate(): ?\DateTime
    {
        return $this->departure_date;
    }

    public function setDepartureDate(\DateTime $departure_date): static
    {
        $this->departure_date = $departure_date;

        return $this;
    }


    public function getAirlineId(): ?Airline
    {
        return $this->airline_id;
    }

    public function setAirlineId(?Airline $airline_id): static
    {
        $this->airline_id = $airline_id;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }
    public function getNow(): \DateTime
    {
        return new \DateTime();
    }
}
