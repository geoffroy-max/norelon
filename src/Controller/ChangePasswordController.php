<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ChangePasswordController extends AbstractController
{
    /**
     * cette fonction me permet de modifier le mdp
     * @Route("/modifier-mon-mdp", name="change_password")
     */
    public function index(Request $request, UserPasswordHasherInterface $encoder, EntityManagerInterface $manager): Response
    {
        $notification = null;
        $user= $this->getUser();

        $form= $this->createForm(ChangePasswordType::class ,$user);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $old_pwd= $form->get('old_password')->getData();

            if($encoder->isPasswordValid($user,$old_pwd)) {
                $new_pwd = $form->get('new_password')->getData();
                $password = $encoder->hashPassword($user, $new_pwd);

                $user->setPassword($password);
                $manager->flush();
                $notification = "votre mpd a été modifier";
            }else{
                $notification= "votre mpd n'a pas été modifier";
            }
        }

        return $this->render('account/password.html.twig',[
            'form'=>$form->createView(),
                'notification'=>$notification
            ]
        );
    }
}
