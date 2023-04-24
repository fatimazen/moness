<?php

namespace App\Form;

use App\Entity\Ess;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EssFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('nameStructure')
            ->add('lastName')
            ->add('firstName')
            ->add('adress')
            ->add('city')
            ->add('zipCode')
            ->add('sectorActivity')
            ->add('activity')
            ->add('legalStatus')
            ->add('description')
            ->add('phoneNumber')
            ->add('image')
            ->add('webSite')
            ->add('socialNetworks')
            ->add('openingHoursMonday')
            ->add('closingHoursMonday')
            ->add('openingHoursTuesday')
            ->add('closingHoursTuesday')
            ->add('openingHoursWednesday')
            ->add('closingHoursWednesday')
            ->add('openingHoursThursday')
            ->add('closingHoursThursday')
            ->add('openingHoursFriday')
            ->add('closingHoursfriday')
            ->add('openingHoursSaturday')
            ->add('closingHoursSaturday')
            ->add('openingHoursSunday')
            ->add('closingHoursSunday')
            ->add('region')
            ->add('label')
            ->add('siretNumber')
            // ->add('users')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ess::class,
        ]);
    }
}
