<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            // probleme d'affichege au niveau de easy admin revnir apres pr traiter le pb
            IdField::new('id'),
            DateTimeField::new('createdAt','passé le'),
            TextField::new('user.getfullName',"nom d'utilisateur"),
            MoneyField::new('carrierPrice', 'frais de transport')->setCurrency('EUR'),
            MoneyField::new('total')->setCurrency('EUR'),
            BooleanField::new('isPaid', 'payée'),
            ArrayField::new('orderDetails','produits achetés')->hideOnIndex()

        ];
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, 'detail');

    }
    public function configureCrud(Crud $crud): Crud
    {
       return $crud
           ->setDefaultSort(['id'=>'DESC']);
    }

}
