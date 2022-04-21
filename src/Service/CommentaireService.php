<?php
namespace App\Service;


use App\Entity\Commentaire;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class CommentaireService
{
   private $em;
   private $flash;
   public function __construct(EntityManagerInterface $em, FlashBagInterface $flash){
        $this->em= $em;
        $this->flash= $flash;
   }
   // cette fonction permet de persist le commentaire
    public function persistComentaire($commentaire, $product){
       
       $commentaire->setCreatedAt(new \DateTime('now'))
                   ->setIsPublished(false)
                    ->setProduct($product);
       $this->em->persist($commentaire);
       $this->em->flush();
       $this->flash->add('success', "votre commentaire est envoyé :il sera affiché apres  validation ");
    }
}