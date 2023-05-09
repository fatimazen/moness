<?php

namespace App\Form;

use App\Entity\Ess;
use App\Entity\Image;
use App\Entity\Picture;
use App\Repository\ImageRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Vich\UploaderBundle\Mapping\Annotation as Vich;






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
            ->add('activity', TypeTextType::class, [
                'label' => 'Activité',
            ])

            ->add('description', TextareaType::class, [

                'label' => 'Description',
            ])
            ->add('siretNumber', TypeTextType::class, [
                'label' => "Numéro de siret",
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le numéro SIRET ne doit pas être vide.'
                    ]),
                    new length([
                        'min' => 14,
                        'max' => 14,
                        'exactMessage' => 'Le numéro SIRET doit contenir exactement {{ limit }} chiffres.'
                    ]),
                    new Regex([
                        'pattern' => '/^[0-9]{14}$/',
                        'message' => 'Le numéro SIRET doit être composé de 14 chiffres.'
                    ]),
                ]

            ])



            ->add('email', EmailType::class, [
                'label' => 'Adresse Email',



            ])

            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',
            ])
            ->add('label', ChoiceType::class, [
                'label' => 'Label',
                'choices' => [
                    'L\'agrément ESUS' => 'ESUS',
                    'ISR' => 'ISR',
                    'FINANSOL' => 'FINANSOL',
                    ' ISO 26000' => 'ISO 26000',
                    'LUCIE 26 000' => 'LUCIE 26 000',
                    'RSE' => 'RSE',
                    'Relations Fournisseurs et Achat Responsable (RFAR)' => 'Relations Fournisseurs et Achat Responsable (RFAR)',
                    'aucun' => 'Aucun',
                ],
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('legalStatus', ChoiceType::class, [
                'label' => 'Statut juridique',
                'choices' => [
                    'Entreprise individuelle (EI)' => 'Entreprise individuelle (EI)',
                    'Entreprise unipersonnelle à responsabilité limitée (EURL)' => 'Entreprise unipersonnelle à responsabilité limitée (EURL)',
                    'Société à responsabilité limitée (SARL)' => 'Société à responsabilité limitée (SARL)',
                    'Société anonyme (SA)' => 'Société anonyme (SA)',
                    'Société par actions simplifiée (SAS) ou société par actions simplifiée unipersonnelle (SASU)' => 'Société par actions simplifiée (SAS) ou société par actions simplifiée unipersonnelle (SASU)',
                    'Société en nom collectif (SNC)' => 'Société en nom collectif (SNC)',
                    'Société coopérative de production (SCOP)' => 'Société coopérative de production (SCOP)',
                    'Société en commandite par actions (SCA) et société en commandite simple (SCS)' => 'Société en commandite par actions (SCA) et société en commandite simple (SCS)',
                ],
                'expanded' => false,
                'required' => true,
            ])
            ->add('imageFile', VichFileType ::class, [
                'label'=>'Logo de Ess',
                'required'=> false,
                'allow_delete'=> true,
                'asset_helper'=>true,
                'label_attr'=>[
                    'class'=>'form-label mt-4'
                ],
                'required' => false,
                'allow_delete' => true,
                'asset_helper' => true,
            ])

          
            


            // ->add('economieSocialeEtSolidaire', CheckboxType::class, [
            //     'label' => 'Entreprise économique sociale et solidaire',

            // ])
            // ->add('entrepriseAMission', CheckboxType::class, [
            //     'label' => 'Entreprise à mission',


            // ])

            ->add('city', TypeTextType::class, [
                'label' => 'Ville',
            ])
            ->add('zip_code', TypeTextType::class, [
                'label' => "Code postale",
                'constraints' => [
                    new Length([
                        'min' => 5,
                        'max' => 5,
                        'exactMessage' => 'Le code postal doit contenir exactement {{ limit }} chiffres.',
                    ]),
                ]
            ])
            ->add('adress', TypeTextType::class, [
                'label' => "Adresse complète",
            ])
            ->add('region', TypeTextType::class, [
                'label' => 'Région',
            ])


            ->add('phoneNumber', TelType::class, [

                'label' => "Numéros de téléphone",
                'constraints' => [
                    new NotBlank(),
                    new length([
                        'min' => 10,
                        'max' => 13,
                        'minMessage' => 'Le numéro de téléphone doit avoir au moins {{ limit }} chiffres',
                        'maxMessage' => 'Le numéro de téléphone ne doit pas dépasser {{ limit }} chiffres',
                    ])
                ]
            ])
            ->add('socialNetworks', TypeTextType::class, [
                'label' => 'facebook',

            ])

            ->add('webSite', TypeTextType::class, [
                'label' => 'site web',
            ])
            ->add('lastName', TypeTextType::class, [

                'label' => 'Nom de la personne',
                'required' => true,
            ])
            ->add('firstName', TypeTextType::class, [

                'label' => 'Prénom',
                'required' => true,
            ])

            ->add('openingHoursMonday', TimeType::class, [
                'label' => "ouvert le lundi de à",

            ])
            ->add('closingHoursMonday', TimeType::class, [

                'label' => "fermé lundi de  à",
            ])

            ->add('openingHoursTuesday', TimeType::class, [

                'label' => "ouvert le mardi de à ",

            ])
            ->add('closingHoursTuesday', TimeType::class, [

                'label' => "fermé mardi de  à",
            ])

            ->add('openingHoursWednesday', TimeType::class, [

                'label' => "ouvert le mercredi de   à",

            ])
            ->add('closingHoursWednesday', TimeType::class, [

                'label' => "fermé mercredi de   à",
            ])

            ->add('openingHoursThursday', TimeType::class, [

                'label' => "ouvert le jeudi de   à",

            ])
            ->add('closingHoursThursday', TimeType::class, [

                'label' => "fermé jeudi de   à",
            ])

            ->add('openingHoursFriday', TimeType::class, [

                'label' => "ouvert le vendredi de   à",

            ])
            ->add('closingHoursFriday', TimeType::class, [

                'label' => "fermé vendredi de   à",
            ])

            ->add('openingHoursSaturday', TimeType::class, [

                'label' => "ouvert le samedi de   à",

            ])
            ->add('closingHoursSaturday', TimeType::class, [
                'label' => "fermé samedi de   à",
            ])


            ->add('openingHoursSunday', TimeType::class, [
                'label' => "ouvert le dimanche de   à",
            ])
            ->add('closingHoursSunday', TimeType::class, [
                'label' => "fermé dimanche de   à",
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ess::class,
            'constraints' => [
                new UniqueEntity([
                    'fields' => ['email'],

                    'message' => 'cette adresse e-mail est déjà utilisée'
                ])
            ],
        ]);
    }
}
