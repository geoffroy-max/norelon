<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,['label'=>" nom d'utilisateur"])
            ->add('prenom',TextType::class,['label'=>"prénom d'utilisateur"])
            ->add('email', EmailType::class,['label'=>"email d'utilisateur"])
            ->add('phone',TelType::class ,['label'=>"saisir le numero de téléphone"])
            ->add('content',TextareaType::class,['label'=>"description"] )
            ->add('submit', SubmitType::class,['label'=>"enregistre", 'attr'=>['class'=>'btn-block btn-info']]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
