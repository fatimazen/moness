<?php

namespace App\Form;

use App\Entity\Users;
use DateTimeImmutable;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UsersFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TypeTextType::class, [
                'label' => 'Adresse Email',

            ])
            // ->add('roles')

            ->add('plainPassword', PasswordType::class, [
            
                'mapped'=>false,
                'attr'=>[
                    'autocomplete'=>'new-password'
                ],
                'constraints'=>[
                    new NotBlank([
                        'message'=> 'veuillez entrée un mot de passe',
                    ]),
                    new length([
                        'min'=> 6,
                        'minMessage'=>'you password should be at least{{limit}} characters',
                        'max'=>4096,
                    ]),
                ],
                'label'=>'Mot de passe'
            ])
            ->add('firstName', TypeTextType::class, [
                'label' => 'Prénom',
                'attr' =>[

                    'class'=>'from-control'
                ],
                
            ])
            ->add('lastName', TypeTextType::class, [
                'label' => 'Nom',
                'attr'=>[
                    'class'=>'from-control'
                ],
                
            ])

    
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

            ])
            ->add('RGPDConsent', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'you should agree to our terms.'
                    ]),
                   
                ],
                'label'=>'En m\'inscrivant à ce site j\'accepte les condition d\'inscription'
                    ]);
                    
                
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
