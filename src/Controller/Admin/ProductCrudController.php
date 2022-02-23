<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }


    public function configureFields(string $pageName): iterable
    {
       return [
           TextField::new('name'),
           TextField::new('illustration')->hideOnIndex(),
           TextField::new('subtitle'),
           TextareaField::new('description'),
           MoneyField::new('price')->setCurrency('EUR'),
           AssociationField::new('category'),
           SlugField::new('slug')->setTargetFieldName('name'),
           TextField::new('imageFile')->setFormType(VichImageType::class)->onlyWhenCreating(),
           ImageField::new('file')->setBasePath('/product/images')->onlyOnIndex(),
           AssociationField::new('category')





       ];
    }

}
