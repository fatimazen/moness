<?php

namespace App\Form;

use App\Entity\Ess;
use DateTime;
use Doctrine\DBAL\Types\TextType;
use Doctrine\DBAL\Types\TimeType as TypesTimeType;
use Faker\Core\Number;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EssFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nameStructure', TypeTextType::class, [
                'label' => 'Nom de la structure',
            ])
            ->add('sectorActivity', ChoiceType::class, [
                'label' => 'Secteur d\'activité',
                'choices' => [
                    'Agriculture, sylviculture et pêche' => 'Agriculture, sylviculture et pêche',
                    'Industries extractives' => 'Industries extractives',
                    ' Industrie manufacturière' => 'Industrie manufacturière',
                    'Production et distribution d\'électricité, de gaz, de vapeur et d\'air conditionné' => 'Production et distribution d\'électricité, de gaz, de vapeur et d\'air conditionné',
                    'Production et distribution d\'eau; assainissement, gestion des déchets et dépollution' => 'Production et distribution d\'eau; assainissement, gestion des déchets et dépollution',
                    'Construction' => 'Construction',
                    'Commerce ; réparation d\'automobiles et de motocycles' => 'Commerce ; réparation d\'automobiles et de motocycles',
                    'Transports et entreposage' => 'Transports et entreposage',
                    'Hébergement et restauration' => 'Hébergement et restauration',
                    'Information et communication' => 'Information et communication',
                    'Activités financières et d\'assurance' => 'Activités financières et d\'assurance',
                    'Activités immobilières' => 'Activités immobilières',
                    'Activités spécialisées, scientifiques et techniques' => 'Activités spécialisées, scientifiques et techniques',
                    'Activités de services administratifs et de soutien' => 'Activités de services',
                    ' Administration publique' => 'Administration publique',
                    ' Enseignement' => 'Enseignement',
                    'Santé humaine et action sociale' => 'Santé humaine et action sociale',
                    ' Arts, spectacles et activités récréatives' => 'Arts, spectacles et activités récréatives',
                    ' Autres activités de services' => 'Autres activités de services',
                    'Activités des ménages en tant qu\'employeurs ; activités indifférenciées des ménages en tant que producteurs de biens et services pour usage propre' => 'Activités des ménages en tant qu\'employeurs ;activités indifférenciées des ménages en tant que producteurs de biens et services pour usage propre',
                    ' Activités extra-territoriales' => 'Activités extra-territoriales',
                ]
            ])
            ->add('activity',TypeTextType::class, [
                'label' => 'Activité',
                ])
        
            ->add('description')
            ->add('siretNumber',NumberType::class, [
                'label' => 'Numéro de siret',
                ])
            ->add('label',ChoiceType::class,[
                'label' => 'Label',
                'choices' =>[
                    'L\'agrément ESUS'=>'ESUS',
                    'ISR'=> 'ISR',
                    'FINANSOL'=>'FINANSOL',
                    ' ISO 26000'=> 'ISO 26000',
                    'LUCIE 26 000'=> 'LUCIE 26 000',
                    'RSE'=> 'RSE',
                    'Relations Fournisseurs et Achat Responsable (RFAR)'=> 'Relations Fournisseurs et Achat Responsable (RFAR)',
                    'aucun'=> 'Aucun',
                    ]
                
                ])
            ->add('legalStatus',ChoiceType::class,[
                'label' => 'Satut juridique',
                'choices' =>[
                    'Entreprise individuelle (EI)'=> 'Entreprise individuelle (EI)',
                    'Entreprise unipersonnelle à responsabilité limitée (EURL)'=>'Entreprise unipersonnelle à responsabilité limitée (EURL)',
                    'Société à responsabilité limitée (SARL)'=> 'Société à responsabilité limitée (SARL)',
                    'Société anonyme (SA)'=>'Société anonyme (SA)',
                    'Société par actions simplifiée (SAS) ou société par actions simplifiée unipersonnelle (SASU)'=>'Société par actions simplifiée (SAS) ou société par actions simplifiée unipersonnelle (SASU)',
                    'Société en nom collectif (SNC)'=>'Société en nom collectif (SNC)',
                    'Société coopérative de production (SCOP)'=>'Société coopérative de production (SCOP)',
                    'Société en commandite par actions (SCA) et société en commandite simple (SCS)'=>'Société en commandite par actions (SCA) et société en commandite simple (SCS)',
                    
                    ]
                ])
            ->add('adress',TypeTextType::class,[
              'label' => 'Adresse',  
                ])
            ->add('email')
            ->add('phoneNumber',NumberType::class,[
                'label' => 'numéros de téléphone',
                ])
            ->add('socialNetworks',CollectionType::class,[
               'label' => 'reseaux sociaux',
               'entry_type' => SocialNetworkType::class,
               'allow_add' => true,
               'allow_delete' => true,
               'prototype' => true,
               'by_reference' => false,
                ])
            ->add('webSite')
            ->add('lastName', TypeTextType::class,[
                
                'label' => 'Nom de la personne',
               'required' => false,])
            ->add('firstName', TypeTextType::class,[
                
                'label' => 'Prénom',
              'required' => false,
              ])
            // ->add('image')
            ->add('openingHoursMonday', TimeType::class,[
               'label' => 'ouvert le lundi de  à',

                ])
            ->add('closingHoursMonday',TimeType::class,[
                
                'label' => 'fermé lundi de  à',])

            ->add('openingHoursTuesday', TimeType::class,[
                
                'label' => 'ouvert le mardi de à ',

                ])
            ->add('closingHoursTuesday',TimeType::class,[
                
                'label' => 'fermé mardi de  à ',])

            ->add('openingHoursWednesday', TimeType::class,[
                
                'label' => 'ouvert le mercredi de   à',

                ])
            ->add('closingHoursWednesday',TimeType::class,[
                
                'label' => 'fermé mercredi de   à',])

            ->add('openingHoursThursday', TimeType::class,[
                
                'label' => 'ouvert le jeudi de   à',

                ])
            ->add('closingHoursThursday',TimeType::class,[
                
                'label' => 'fermé jeudi de   à',])

            ->add('openingHoursFriday', TimeType::class,[
                
                'label' => 'ouvert le vendredi de   à',

                ])
            ->add('closingHoursFriday',TimeType::class,[
                
                'label' => 'fermé vendredi de   à',])

            ->add('openingHoursSaturday', TimeType::class,[
                
                'label' => 'ouvert le samedi de   à',

                ])
            ->add('closingHoursSaturday',TimeType::class,[
                'label' => 'fermé samedi de   à',
                ])
        
           
            ->add('openingHoursSunday', TimeType::class,[
                'label' => 'ouvert le dimanche de   à',
                ])
            ->add('closingHoursSunday', TimeType::class,[
                'label' => 'fermé dimanche de   à',
                ])
            // ->add('region')
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
