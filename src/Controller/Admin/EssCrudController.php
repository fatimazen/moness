<?php

namespace App\Controller\Admin;

use DateTime;
use App\Entity\Ess;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;


class EssCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Ess::class;
    }

    public function configureCrud(Crud $crud): crud

    {
        return $crud
            ->setEntityLabelInPlural('structure des ess')
            ->setEntityLabelInSingular('ess')
            ->setPageTitle("index", "structure des ess -Administration des ess")
            ->setPaginatorPageSize(10);
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->hideOnForm(),
            TextField::new('nameStructure'),
            ChoiceField::new('sectorActivity'),
            TextEditorField::new('description'),
            TextField::new('siretNumber'),
            EmailField::new('email'),
            ChoiceField::new('label')->allowMultipleChoices(),
            ChoiceField::new('legalStatus'),
            TextField::new('city'),
            TextField::new('zipCode'),
            TextField::new('adress'),
            TextField::new('region'),
            TelephoneField::new('phoneNumber'),
            TextField::new('socialNetworks'),
            TextField::new('activity'),
            TextField::new('firstName'),
            TextField::new('lastName'),
            TextField::new('webSite'),
            DateTimeField::new('createdAt'),

        ];
    }
}
