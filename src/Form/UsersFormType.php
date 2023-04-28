<?php

namespace App\Form;

use App\Entity\Users;
use DateTimeImmutable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormTypeInterface;
class UsersFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TypeTextType::class, [
                'label' => 'Adresse Email',

            ])
            // ->add('roles')
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
            ])
            ->add('firstName', TypeTextType::class, [
                'label' => 'Prénom',
                
            ])
            ->add('lastName', TypeTextType::class, [
                'label' => 'Nom',
                
            ])
            // ->add('created_At',DateTimeImmutable::class, [
            //     'label' => 'date de création',
                   
            // ])

            
            // ->add('is_abonneNewsLetter')
            ->add('birthdate', DateType::class, [
                'label' => 'Date de naissance',
                'widget' => 'single_text',
                'input' => 'string',
            ])

            ->add('gender',ChoiceType::class,[
                'label' => 'Civilité',
                'choices' => [
                    'M' => 'Homme',
                    'F' => 'Femme',
                ],
                'expanded' => true,
                'multiple' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
