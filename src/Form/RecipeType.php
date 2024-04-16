<?php

namespace App\Form;

use App\Entity\Allergens;
use App\Entity\Diet;
use App\Entity\Recipe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'input__title'
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'input__description',
                    'resize' => 'none'
                ]
            ])
            ->add('breakTime', TimeType::class, [
                'input'  => 'datetime',
                'widget' => 'choice'
            ])
            ->add('cookingTime', TimeType::class, [
                'input'  => 'datetime',
                'widget' => 'choice'
            ])
            ->add('ingredients', TextareaType::class, [
                'attr' => [
                    'class' => 'input__ingredients',
                    'resize' => 'none'
                ]
            ])
            ->add('public')
            ->add('allergens', EntityType::class, array(
                'class' => Allergens::class,
                'choice_label' => 'name',
                'placeholder' => 'allergens',
                'required' => false,
                'multiple' => true,
            ))
            ->add('diet',  EntityType::class, [
                'class' => Diet::class,
                'choice_label' => 'name',
                'placeholder' => 'allergens',
                'required' => false,
                'multiple' => true
            ])
            ->add('step', TextareaType::class, [
                'attr' => [
                    'class' => 'input__step',
                    'resize' => 'none'
                ]
            ])
            
            // On ajoute le champ "image" dans le formulaire
            // le champ n'est pas lié a la bdd (mapped false)
            ->add('pictures', FileType::class, [
                'attr' => [
                    'class' => 'input__pictures',
                    'accept' => 'image/*'
                ],
                'label' => 'Images',
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}