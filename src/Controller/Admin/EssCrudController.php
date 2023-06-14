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
            TextField::new('nameStructure','nom de la structure'),
            ChoiceField::new('sectorActivity','secteur activité'),
            TextEditorField::new('description'),
            TextField::new('siretNumber','numero de siret'),
            EmailField::new('email'),
            ChoiceField::new('label')->allowMultipleChoices(),
            ChoiceField::new('legalStatus','statut juridique'),
            TextField::new('city','ville'),
            TextField::new('zipCode','code postal'),
            TextField::new('adress','adresse'),
            TelephoneField::new('phoneNumber','numéro de télèphone'),
            TextField::new('socialNetworks','reseaux sociaux'),
            TextField::new('activity','activité'),
            TextField::new('firstName','Nom'),
            TextField::new('lastName',"Prénom"),
            TextField::new('webSite','site web'),
            DateTimeField::new('createdAt','ajouter le '),

        ];
    }
}
