<?php

namespace App\Controller\Admin;

use App\Entity\Commentaire;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use function Sodium\add;

class CommentaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commentaire::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('author', 'auteur'),
            EmailField::new('email'),
            TextareaField::new('content','contenu'),
            DateTimeField::new('createdAt')->onlyOnForms(),
            AssociationField::new('product','produit'),
            BooleanField::new('isPublished', 'est publié')

        ];
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add('index','detail')
            ->disable('new');

    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['id'=>'DESC']);
    }

}
