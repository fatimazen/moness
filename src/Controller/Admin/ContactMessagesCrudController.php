<?php

namespace App\Controller\Admin;

use App\Entity\ContactMessages;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ContactMessagesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ContactMessages::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Demande de contact')
            ->setEntityLabelInPlural('Demandes de contact')
            ->setPageTitle("index", "Moness.fr-Administration des demandes de  contact")
            ->setPaginatorPageSize(20)
            ->addformTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnIndex(),
            TextField::new('fullName', "Nom / Prènom"),
            TextField::new('email'),
            TextEditorField::new('message')
            ->hideOnIndex()
            ->setFormType(CKEditorType::class),
            DateTimeField::new('createdAt')
                ->hideOnForm()
        ];
    }
}
