<?php

namespace App\Form;

use App\Entity\Address;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,['label'=>"quel nom souhaitez donner à votre adresse",
                'attr'=>['placeholder'=>"nommez votre adresse"]])
            ->add('firstname',TextType::class,['label'=>"votre prenom",
                'attr'=>['placeholder'=>"entrez votre prenom"]])
            ->add('lastname',TextType::class,['label'=>"votre nom",
        'attr'=>['placeholder'=>"entrez votre nom"]])
            ->add('company',TextType::class,['label'=>"le nom de votre societé",
            'required'=>false,
        'attr'=>['placeholder'=>"optionnel"]])
            ->add('address',CKEditorType::class,['label'=>"quel nom souhaitez donner à votre adresse",
                'attr'=>['placeholder'=>"nommez votre adresse"]])  // Ce champ sera remplacé par un éditeur WYSIWYG
            ->add('postal',TextType::class,['label'=>"votre code postale",
        'attr'=>['placeholder'=>"entrez votre code postale"]])
            ->add('city',TextType::class,['label'=>"votre ville",
        'attr'=>['placeholder'=>"entrez votre ville"]])
            ->add('country',CountryType::class,['label'=>"votre country",
        'attr'=>['placeholder'=>"entrez le nom de votre country"]])
            ->add('phone',TelType::class,['label'=>"votre telephone",
        'attr'=>['placeholder'=>"entrez votre telephone"]])
            ->add('submit',SubmitType::class,['label'=>"valider une adresse " , 'attr'=>['class'=>'btn-block btn-info']])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
