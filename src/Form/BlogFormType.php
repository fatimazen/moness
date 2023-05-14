<?php

namespace App\Form;

use App\Entity\Blog;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class BlogFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextTypeText::class, [
                'label' => 'titre de article'
            ])
            ->add('slug')
            ->add('author', TextTypeText::class, [
                'label' => 'auteur de articles'
            ])
            ->add('imageFile', VichFileType::class, [
                'required' => false,
                'allow_delete' => true,
                'asset_helper' => true,
            ])
            // ->add('image', CollectionType::class, [
            //     'entry_type' => ImageFormType::class,
            //     // 'entry_options' => ['label' => false],
            //     // 'allow_add' => true,
            //     // 'allow_delete' => true,
            //     // 'by_reference' => false,
            // ])
            // ->add('imageName')
            ->add('content', TextareaType::class, [
                'label' => 'description',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Blog::class,
        ]);
    }
}
