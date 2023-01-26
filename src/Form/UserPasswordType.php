<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;


use Symfony\Component\Validator\Constraints as Assert;

class UserPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //-------------- PASSWORD --------------

            ->add("plainPassword", RepeatedType::class, [
                'type'=> PasswordType::class,
                'first_options'=>[
                    'label'=>'Mot de passe',
                    'attr' => [
                        "class"=>"form-control",
                        "placeholder"=>"Veuillez saisir un mot de passe",
                    ]
                ],
                'second_options'=>[
                    'label'=>'Confirmation du mot de passe',
                    'attr' => [
                        "class"=>"form-control",
                        "placeholder"=>"Confirmez votre mot de passe",
                    ]
                ],
                'invalid_message'=>'Les mots de passe saisis ne correspondent pas'
            ])
            ->add('newPassword', PasswordType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Nouveau mot de passe',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                ]
            ])
            //-------------- SUBMIT --------------
            ->add("submit", SubmitType::class, [
                'label' => 'Confirmer',
                'attr' => [
                    'class'=>'btn btn-success'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
