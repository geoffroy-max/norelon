<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\User;
use App\Form\RegisterType;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{

    private $manager;

    public function __construct( EntityManagerInterface $manager){
        $this->manager= $manager;
}
    /**
     * permet de creer un form d'inscription
     * @Route("/inscription", name="inscription")
     */
    public function index(Request $request, UserPasswordHasherInterface $encoder): Response
    {     $mail= new Mail();
        $user = new User();
        $notification= null;
        $form= $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $user= $form->getData();
            // on verifier si l'user est deja connecté ou pas

            $search_email= $this->manager->getRepository(User::class)->findOneByEmail($user->getEmail());
            //$password= $user->getpassword();
            if (!$search_email){
                $password= $encoder->hashPassword($user,$user->getpassword());
                $user->setPassword($password);
                $this->manager->persist($user);
                $this->manager->flush();
                $notification="creer votre compte et connectez vous";
                $content= "bonjour".$user->getFirstname()."<br/> bienvenue sur la premiere boutique de jojo";
                $mail->send($user->getEmail(),$user->getFirstname(),'bienvenue sur la bouutique francaise de geoffroy', $content);
            }else{
                $notification= "email  que vous avez renseignez existe deja";
            }


        }
        return $this->render('inscription/index.html.twig',[
            'form'=>$form->createView(),
            'notification'=>$notification
        ]);
    }
}
