<?php

namespace App\Form;

use App\Entity\Articles;
use App\Entity\Categories;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class,[
                'required'=>true,
                'label'=> false,
                'attr'=>[
                    'class'=>'inputForm',
                    'placeholder'=>'titre de l\'article',
                ]
            ])
            ->add('metaDescription',TextType::class,[
                'required'=>true,
                'label'=> false,
                'attr'=>[
                    'class'=>'inputForm',
                    'placeholder'=>'meta description',
                ]
            ])
            ->add('content',CKEditorType::class,[
                'required'=>true,
                'label'=> false,
            ])
            ->add('imageEnAvant',FileType::class,[
                'label' => false,
                'multiple' => false,
                'mapped' => false,
                'required' => true
            ])
            ->add('categorie',EntityType::class,[
                'required'=>true,
                'class'=> Categories::class,
                'label'=> false,
                'attr'=>[
                    'class'=>'inputForm',
                ]
            ])
            ->add('LegendeImageEnAvant',TextType::class,[
                'required'=>true,
                'label'=> false,
                'attr'=>[
                    'class'=>'inputForm',
                    'placeholder'=>'legende de l\'image principale',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
