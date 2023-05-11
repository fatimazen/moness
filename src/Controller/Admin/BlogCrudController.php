<?php

namespace App\Controller\Admin;

use App\Entity\Blog;
use App\Entity\Image;
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
            
            TextField::new('title'),
            TextField::new('author'),
            TextField::new('imageFile')->setFormType(VichImageType::class),
            ImageField::new('image')->setBasePath('/uploads/blog')->onlyOnIndex(),
            TextEditorField::new('content')
            ->setFormType(CKEditorType::class),
          
        ];
    }
}
