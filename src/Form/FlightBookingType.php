<?php

namespace App\Form;

use App\Entity\Airline;
use App\Entity\FlightBooking;
use App\Enum\Status;
use App\Repository\AirlineRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FlightBookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $status = 'Active';
        $builder
        ->add('flight_from', TextType::class,
        ['attr' => ['autocompelete' => 'off']]
        )
        ->add('flight_to', TextType::class,
        ['attr' => ['autocompelete' => 'off']]
        )
        ->add('departure_date', DateType::class,[
            'widget' => 'single_text',
            //'format' => 'dd-M-yy',
            'html5' => false,
             'attr' => ['class' => 'js-datepicker'],
        ])
        ->add('airline_id', EntityType::class,[
               

        'class' => Airline::class,
        
        'query_builder' => function(AirlineRepository $airlineRpo) use ($status) {
        return $airlineRpo->createQueryBuilder('a')
        ->where('a.status = :status ')
        ->setParameter('status', $status);
        },
        'choice_value' => 'id',
        'choice_label' => 'name',
        'label' => 'Airline',
        'attr' => ['label' => 'Airline'],
        'placeholder' => 'Select Airline',
        
    ]
        
        )
        ->add('submit', SubmitType::class, ['attr' => ['class' => 'btn btn-primary']])
        
        ;
    }


    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FlightBooking::class,
        ]);
    }

}