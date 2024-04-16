<?php

namespace App\Form;

use App\Entity\View;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ViewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('score', IntegerType::class, [
                'attr' => [
                    'class' => 'input__score'
                ],
                'label' => 'Note'
            ])
            ->add('comment', TextareaType::class, [
                'attr' => [
                    'class' => 'input__comment',
                    'resize' => 'none'
                ],
                'label' => 'Commentaire'
            ])
            ->add('recipe', TextareaType::class)
            ->add('userId', IntegerType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => View::class,
        ]);
    }
}
