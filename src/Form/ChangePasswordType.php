<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname',TextType::class,['label'=>'votre prénom','disabled'=>true])
            ->add('lastname',TextType::class,['label'=>'votre prénom','disabled'=>true])
            ->add('email',EmailType::class,['label'=>'votre email','disabled'=>true])
            ->add('old_password',PasswordType::class, ['label'=>'mdp actuel','mapped'=>false,'attr'=>['placeholder'=>'saisir votre mdp actuel']])
            ->add('new_password',RepeatedType::class, ['type'=>PasswordType::class,'mapped'=>false ,'invalid_message'=>'le mdp de la confirmation 
            doivent etre identique', 'required'=>true, 'first_options'=>['label'=>'votre nouveau mdp','attr'=>['placeholder'=>'merci de saisir vtre  nouveau mdp']],
                'second_options'=>['label'=>'comfirme vtre nouveau mdp','attr'=>['placeholder'=>'merci de confirmé votre nouveau mdp']]])
            ->add('submit', SubmitType::class,['label'=>"Mettre à jour"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
