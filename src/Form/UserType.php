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

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                "attr" => [
                    "class" => "form-control",
                    "placeholder"=>"Prénom",
                    "minlength" => "2",
                    "maxlength" => "50",
                ],
                "label" => "Prénom",
                "label_attr" => [
                    "class" => "form-label",
                ],
                "constraints" => [
                    new Assert\Length(["min" => 2, "max" => 50]),
                    new Assert\NotBlank(),
                ],
            ])
            ->add('lastName',TextType::class, [
                "attr" => [
                    "class" => "form-control",
                    "placeholder"=>"Nom",
                    "minlength" => "2",
                    "maxlength" => "50",
                ],
                "label" => "Nom",
                "label_attr" => [
                    "class" => "form-label",
                ],
                "constraints" => [
                    new Assert\Length(["min" => 2, "max" => 50]),
                    new Assert\NotBlank(),
                ],
            ])

            //-------------- PASSWORD --------------

            ->add("plainPassword", PasswordType::class, [
                    'label'=>'Mot de passe',
                    'attr' => [
                        "class"=>"form-control",
                        "placeholder"=>"Mot de passe",
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
