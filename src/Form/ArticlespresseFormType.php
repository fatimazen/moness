<?php

namespace App\Form;

use App\Entity\Articlespresse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ArticlespresseFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextTypeText::class,[
                'label'=>'titre de l\'article'
            ])
            ->add('imageFile', VichFileType::class,[
                'required' => false,
                'allow_delete' => true,
                'asset_helper' => true,
            ])
            ->add('author', TextTypeText::class,[
                'label'=> 'auteur de \'article'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Articlespresse::class,
        ]);
    }
}
