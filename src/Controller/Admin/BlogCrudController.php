<?php

namespace App\Controller\Admin;

use App\Entity\Blog;
use App\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;


class BlogCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Blog::class;
    }
    public function configureCrud(Crud $crud): crud

    {
        return $crud
            ->setEntityLabelInPlural('Blogs')
            ->setEntityLabelInSingular('Blog')
            ->setPageTitle("index", "Moness.fr-Administration des blogs")
            ->setPaginatorPageSize(10)
            ->addformTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }

    public function configureFields(string $pageName): iterable
    {
        return [

            TextField::new('title', 'titre'),
            TextField::new('author', 'auteur'),
            TextField::new('imageFile', 'photo')->setFormType(VichImageType::class)
                ->hideOnIndex(),
            ImageField::new('image')->setBasePath('/uploads/blog')->onlyOnIndex(),
            TextEditorField::new('content', 'contenu')
                ->setFormType(CKEditorType::class),
            TextField::new('slug', 'référencement')

        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Blog) {
            return;
        }

        $entityInstance
        ->setCreatedAt(new \DateTimeImmutable())
        ->setUsers($this->getUser());
    
    //je persiste et je flush en base de données et j'envoie un email
    parent::persistEntity($entityManager, $entityInstance);
    }
}
