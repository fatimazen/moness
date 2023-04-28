<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;

class UsersFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TypeTextType::class, [
                'label' => 'Email',

            ])
            // ->add('roles')
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
            ])
            ->add('firstName', TypeTextType::class, [
                'label' => 'Prénom',
                'attr' => ['placeholder' => 'Prénom'],
            ])
            ->add('lastName', TypeTextType::class, [
                'label' => 'Nom',
                'attr' => ['placeholder' => 'Nom'],
            ])
            // ->add('created_At')
            // ->add('is_abonneNewsLetter')
            ->add('birthdate', DateType::class, [
                'label' => 'Date de naissance',
            ])

            ->add('gender',ChoiceType::class,[
                'label' => 'Genre',
                'choices' => [
                    'M' => 'Homme',
                    'F' => 'Femme',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
