<?php

namespace App\Form;



use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder


            ->add('password', RepeatedType::class, [
                'type'=>PasswordType::class,
                'first_options'=>[
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'label'=>'Mot de passe',
                    'label_attr'=>[
                        'class'=>'from-label mt-4'
                    ]
                    ],
                    'second_options'=>[
                        'attr'=>[
                            "class"=>'from-control'
                        ],
                        'label'=>'confirmation du mot de passe',
                        'label_attr'=>[
                            'class'=>'form-label mt4'
                        ]
                        ],
                        'invalid_message'=>'les mots de passe ne correspond pas',
                        
                        
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'veuillez remplir ce champ.',
                    ]),
                   

                ],
                'label' => 'Mot de passe'
            ])
                ->add('newPassword',PasswordType::class,[
                    'attr'=>['class'=>'from-control'],
                    'label'=> 'Nouveau mot de passe',
                    'label_attr'=>['class'=>'form-label mt-4'],
                    'constraints'=>[new Assert\NotBlank()]

                ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4',
                ],
                'label' => 'Envoyer',

            ]);
    }

    
}
