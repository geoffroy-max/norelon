<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * cette fonction permet de contacter les admin
     * @Route("/contact", name="app_contact")
     */
    public function index(Request $request,EntityManagerInterface $em): Response
    {
   $contact= new Contact();


        $form= $this->createForm(ContactType::class);
         $form->handleRequest($request);
             if($form->isSubmitted()&&$form->isValid()){
                 $contact= $form->getData();
                 $mail= new Mail();


                 $content= " je voulais avoir plus inforlations concernant les collections d'hiver";
                 $mail->send('ndongogeoffroy10@yahoo.com','geoffroy','collection hiver',$content);
                 $this->addFlash('notice','vous  avez envoyé un message aux admin');

             }
        return $this->render('contact/index.html.twig',[
            'form'=>$form->createView()
            ]
        );
    }
}
