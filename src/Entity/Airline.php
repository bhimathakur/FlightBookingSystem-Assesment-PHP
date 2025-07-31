<?php

namespace App\Entity;

use App\Enum\Status;
use App\Repository\AirlineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AirlineRepository::class)]
class Airline
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

   
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(length: 255)]
    private ?Status $status = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date = null;

    /**
     * @var Collection<int, FlightBooking>
     */
    #[ORM\OneToMany(targetEntity: FlightBooking::class, mappedBy: 'airline_id')]
    private Collection $flightBookings;

    public function __construct()
    {
        $this->flightBookings = new ArrayCollection();
    }

   
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(Status $status): static
    {
        $this->status = $status;

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

    /**
     * @return Collection<int, FlightBooking>
     */
    public function getFlightBookings(): Collection
    {
        return $this->flightBookings;
    }

    public function addFlightBooking(FlightBooking $flightBooking): static
    {
        if (!$this->flightBookings->contains($flightBooking)) {
            $this->flightBookings->add($flightBooking);
            $flightBooking->setAirlineId($this);
        }

        return $this;
    }

    public function removeFlightBooking(FlightBooking $flightBooking): static
    {
        if ($this->flightBookings->removeElement($flightBooking)) {
            // set the owning side to null (unless already changed)
            if ($flightBooking->getAirlineId() === $this) {
                $flightBooking->setAirlineId(null);
            }
        }

        return $this;
    }


   
    }
