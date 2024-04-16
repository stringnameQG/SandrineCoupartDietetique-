<?php

namespace App\Form;

use App\Entity\Allergens;
use App\Entity\Diet;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class)
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ]
            ])  
            ->add('Allergens', EntityType::class, [
                'class' => Allergens::class,
                'choice_label' => 'name',
                'placeholder' => 'allergens',
                'required' => false,
                'multiple' => true,
            ])
            ->add('Diet',  EntityType::class, [
                'class' => Diet::class,
                'choice_label' => 'name',
                'placeholder' => 'allergens',
                'required' => false,
                'multiple' => true
            ])   
            //  Si besoin de modification de l'attribution des roles décommenter les lignes suivantes
            //  et commenter le Registration controller
            /*
            ->add('Roles', ChoiceType::class, [
                'choices' => array(
                    'Admin' => 'ROLE_ADMIN',
                    'User' => 'ROLE_USER',
                ),
                'multiple'  => true, // choix multiple
            ])  */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
