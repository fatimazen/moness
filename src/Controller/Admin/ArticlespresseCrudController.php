<?php

namespace App\Controller\Admin;

use App\Entity\Articlespresse;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ArticlespresseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Articlespresse::class;
    }

    public function configureCrud(Crud $crud): crud

    {
        return $crud
            ->setEntityLabelInPlural('Articlespresse')
            ->setEntityLabelInSingular(' un article de presse')
            ->setPageTitle("index", "Moness.fr-Administration des articles de presse")
            ->setPaginatorPageSize(10)
            ->addformTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('title', 'Titre'),
            TextField::new('author', 'Auteur'),
            TextField::new('imageFile', 'Photo')->setFormType(VichImageType::class)
                ->hideOnIndex(),
            ImageField::new('image')->setBasePath('/uploads/blog')->onlyOnIndex(),
            TextEditorField::new('content', 'Contenu')
                ->setFormType(CKEditorType::class),
            TextField::new('slug', 'Référencement')
        ];
    }
}
