<?php

namespace App\Controller\Admin;

use App\Classe\Mail;
use App\Entity\Order;
use App\Entity\Order3;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
class Order3CrudController extends AbstractCrudController
{

    private $em;
    private $crudUrlGenerator;
    private $adminUrlGenerator;


    public function __construct(EntityManagerInterface $em,CrudUrlGenerator $crudUrlGenerator, AdminUrlGenerator $adminUrlGenerator){

        $this->em= $em;
        $this->crudUrlGenerator= $crudUrlGenerator;
        $this->adminUrlGenerator=$adminUrlGenerator;

    }
    public static function getEntityFqcn(): string
    {
        return Order3::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            // probleme d'affichege au niveau de easy admin revnir apres pr traiter le pb
            IdField::new('id'),
            DateTimeField::new('createdAt','passé le'),
            TextField::new('user.getfullName',"nom d'utilisateur"),
            //BooleanField::new('isBest'),
            TextEditorField::new('delivery',"adresse de livraison")->onlyOnDetail(),
            MoneyField::new('carrierPrice', 'frais de transport')->setCurrency('EUR'),
            MoneyField::new('total')->setCurrency('EUR'),
            //BooleanField::new('isPaid', 'payée'),
            ChoiceField::new('state')->setChoices([
                'non payé'=>0,
                    'payé'=>1,
                    'prepation en cours'=>2,
                    'livraison en cours'=>3
                ]
                ),
            ArrayField::new('orderDetail3s','produits achetés')->hideOnIndex()

        ];
    }
    public function configureActions(Actions $actions): Actions
    {
        // on ajoute une action dans la page detail
        $courtPreparation = Action::new('updatePreparation', 'preparation en cours','fas fa-box-open')->linkToCrudAction('courtPreparation');
        $courtDelivery= Action::new('courtDelivery','livraison en cours','fas fa-truck')->linkToCrudAction('courtDelivery');
        return $actions
            ->add('detail',$courtDelivery)
            ->add('detail', $courtPreparation)
            ->add(Crud::PAGE_INDEX, 'detail');
    }
    // cette methode  permet d'afficher le status de la cmd dans la page index
    //AdminContext dns easyadmin permet de recuperer l'entité et le modifier
    public function courtPreparation(AdminContext $context)
    {
        $mail= new Mail();
        $order3= $context->getEntity()->getInstance();
        $order3->setState(2);
        $this->em->flush();

        $this->addFlash('notice'," <span style='color:orange;'> <strong>la commande ".$order3->getReference()." est bien en <u>cours de préparation</u></strong></span>");
        $url=$this->adminUrlGenerator
            ->setController(Order3CrudController::class)
             ->setAction('index')
            ->generateUrl();
        //$content= "Bonjour".$order3->getUser()->getFirstname()."<br/> Merci pour votre commande";
        //$mail->send($order3->getUser()->getEmail(),$order3->getUser()->getFirstname(),'bienvenue sur la boutique francaise de geoffroy', $content);

        return $this->redirect($url);

    }

    public function courtDelivery(AdminContext $context){
      $order3= $context->getEntity()->getInstance();
      $order3->setState(3);
      $this->em->flush();
      $this->addFlash('notice', " <span style='color: #a3e635'> <strong> la commande ".$order3->getReference()."  est en  <u>cours de livraison</u></strong> </span>");
      $url2= $this->adminUrlGenerator
          ->setController(Order3CrudController::class)
          ->setAction('index')
          ->generateUrl();
          return $this->redirect($url2);
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['id'=>'DESC']);
    }

}
