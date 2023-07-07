<?php

namespace App\Form;

use App\Entity\Ess;
use App\Entity\Activity;
use App\Repository\ActivityRepository;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;



class EssFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nameStructure', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Nom de la structure',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
            ])
            ->add('sectorActivity', ChoiceType::class, [
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
                ],
                'label' => 'Secteur d\'activité',
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('activity', EntityType::class, [
                'class' => Activity::class,
                'choice_label' => 'name',
                'label' => 'Activité',
                'group_by' => 'parent.name',
                'query_builder' => function (ActivityRepository $cr) {
                    return $cr->createQueryBuilder('a')
                        ->Where('a.parent IS NOT NULL')
                        ->orderBy('a.name', 'ASC');
                },

                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-label mt-4',
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                ],
                'label' => 'Description',
            ])
            ->add('siretNumber', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => "Numéro de siret",
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le numéro SIRET ne doit pas être vide.'
                    ]),
                    new length([
                        'min' => 14,
                        'max' => 14,
                    ]),
                    new Regex([
                        'pattern' => '/^[0-9]{14}$/',
                        'message' => 'Le numéro SIRET doit être composé de 14 chiffres.'
                    ]),
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => 2,
                    'maxlength' => 180,
                ],
                'label' => 'Adresse email',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    // new Assert\Email(),
                    new Assert\Length(['min' => 2, 'max' => 180]),
                ],
            ])
            ->add('label', ChoiceType::class, [
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
                'label' => 'Label',
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('legalStatus', ChoiceType::class, [
                'choices' => [
                    'Entreprise individuelle (EI)' => 'Entreprise individuelle (EI)',
                    'Entreprise unipersonnelle à responsabilité limitée (EURL)' => 'Entreprise unipersonnelle à responsabilité limitée (EURL)',
                    'Société à responsabilité limitée (SARL)' => 'Société à responsabilité limitée (SARL)',
                    'Société anonyme (SA)' => 'Société anonyme (SA)',
                    'Société par actions simplifiée (SAS) ou société par actions simplifiée unipersonnelle (SASU)' => 'Société par actions simplifiée (SAS) ou société par actions simplifiée unipersonnelle (SASU)',
                    'Société en nom collectif (SNC)' => 'Société en nom collectif (SNC)',
                    'Société coopérative de production (SCOP)' => 'Société coopérative de production (SCOP)',
                    'Société en commandite par actions (SCA) et société en commandite simple (SCS)' => 'Société en commandite par actions (SCA) et société en commandite simple (SCS)',
                    'Économie sociale et solidaire' => 'Économie sociale et solidaire',
                    'Entreprise à mission' => 'Entreprise à mission',
                ],
                'label' => 'Statut juridique',
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('imageFile', VichFileType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Logo de Ess',
                'required' => false,
                'allow_delete' => true,
                'asset_helper' => true,
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'required' => false,
                'allow_delete' => true,
                'asset_helper' => true,
            ])
            ->add('city', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Ville',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                    'mapped' => false, // Indique que ce champ ne doit pas être mappé à l'entité
                ],
            ])
            ->add('zipCode', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => 5,
                    'maxlength' => 5,
                ],
                'label' => "Code postale",
                'label_attr' => [
                    'class' => 'form-label mt-4',
                    'mapped' => false,
                ],
                'constraints' => [
                    new Length([
                        'min' => 5,
                        'max' => 5,
                        'exactMessage' => 'Le code postal doit contenir exactement {{5}} chiffres.',
                    ]),
                ]
            ])
            ->add('adress', TextType::class, [
                'attr' => [
                    'class' => 'form-label mt-4',
                ],
                'label' => "Adresse complète",
                'mapped' => false,
            ])
            ->add('phoneNumber', TelType::class, [
                'attr' => [
                    'class' => 'form-label mt-4',
                ],
                'label' => "Numéros de téléphone",
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 10,
                        'max' => 13,
                        'minMessage' => 'Le numéro de téléphone doit avoir au moins {{10}} chiffres',
                        'maxMessage' => 'Le numéro de téléphone ne doit pas dépasser {{13}} chiffres',
                    ])
                ]
            ])
            ->add('socialNetworks', TextType::class, [
                'attr' => [
                    'class' => 'from-control',

                ],
                'label' => 'facebook',
                'label_attr' => [],
            ])
            ->add('webSite', TextType::class, [
                'label' => 'site-web',
            ])
            ->add('lastName', TextType::class, [
                'attr' => [
                    'form-control',
                ],
                'label' => 'Nom de la personne',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'required' => true,
            ])
            ->add('firstName', TextType::class, [
                'attr' => [
                    'form-control',
                ],
                'label' => 'Prénom',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'required' => true,
            ])
            ->add('openingHoursMonday', TimeType::class, [
                'label' => "ouvert le lundi à",
                'input' => 'datetime',
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
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success mt-4',
                    'style' => 'background-color: #25CCBF; border: none; border-radius: 15px;width: 300px;'
                ],
                'label' => 'Envoyer',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ess::class,
        ]);
    }
}
