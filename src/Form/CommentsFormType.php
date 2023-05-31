<?php

namespace App\Form;

use App\Entity\Comments;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CommentsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('comment',TextareaType::class,[
                'label'=>'Poster un nouveaux commentaire',
                'constraints'=>[new NotBlank()]
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success mt-4',
                    'style' => 'background-color: #25CCBF; border: none; border-radius: 15px;width: 300px;'
                ],
                'label' => 'Envoyer',

            ]);
        //     ->add('parentid',HiddenType::class,[
        //         'mapped'=>false,
        //     ])
        //     ->add('envoyer', SubmitType::class)
         ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comments::class,
        ]);
    }
}
