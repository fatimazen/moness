<?php

namespace App\Controller\Admin;

use DateTime;
use App\Entity\Ess;
use App\Entity\Activity;
use App\Repository\ActivityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use Symfony\Component\Validator\Constraints\Choice;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EssCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Ess::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('structure des ess')
            ->setEntityLabelInSingular('ess')
            ->setPageTitle("index", "structure des ess - Administration des ess")
            ->setPaginatorPageSize(10);
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('nameStructure', 'nom de la structure');
        yield ChoiceField::new('sectorActivity', 'secteur activité');
        yield TextEditorField::new('description');
        yield TextField::new('siretNumber', 'numero de siret');
        yield EmailField::new('email');
        yield ChoiceField::new('label')->allowMultipleChoices();
        yield ChoiceField::new('legalStatus', 'statut juridique');
        yield TextField::new('city', 'ville');
        yield TextField::new('zipCode', 'code postal');
        yield TextField::new('adress', 'adresse');
        yield TelephoneField::new('phoneNumber', 'numéro de télèphone');
        yield TextField::new('socialNetworks', 'reseaux sociaux');
        yield TextField::new('jsonField', 'activité')->onlyOnDetail()
            ->setFormType(EntityType::class)
            ->setFormTypeOptions([
                'class' => Activity::class,
                'choice_label' => function ($activity) {
                    return $activity->getName();
                },
                'group_by' => 'parent.name',
                'query_builder' => function (ActivityRepository $cr) {
                    return $cr->createQueryBuilder('a')
                        ->where('a.parent IS NOT NULL')
                        ->orderBy('a.name', 'ASC');
                },
                'label' => 'Activité',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
            ]);
        yield TextField::new('firstName', 'Nom');
        yield TextField::new('lastName', "Prénom");
        yield TextField::new('webSite', 'site web');
        yield DateTimeField::new('createdAt', 'ajouter le');
    }
}
