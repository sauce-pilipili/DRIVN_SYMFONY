<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'required'=>true,
                'label'=> false,
                'attr'=>[
                    'class'=>'contactForm',
                    'placeholder'=>'Ecrivez votre prénom',
                ]
            ])
            ->add('email',EmailType::class,[
                'label'=>false,
                'attr'=>[
                    'class'=>'contactForm',
                    'placeholder'=>' Indiquez votre email']
            ])
            ->add('message',TextareaType::class,[
                'required'=>true,
                'label'=> false,
                'attr'=>[
                    'class'=>'contactForm',
                    'cols'=>30,
                    'rows'=>10,
                    'placeholder'=>'Vous avez des questions?',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
