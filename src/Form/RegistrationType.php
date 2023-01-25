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

use Symfony\Component\Validator\Constraints as Assert;

class RegistrationType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder
            //-------------- PRENOM --------------

            ->add("firstName", TextType::class, [
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
            //-------------- NOM --------------

            ->add("lastName", TextType::class, [
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
            //-------------- EMAIL --------------

            ->add("email", EmailType::class, [
                "attr" => [
                    "class" => "form-control",
                    "placeholder"=>"Email@Dreamgym.com",
                    "minlength" => "2",
                    "maxlength" => "180",
                ],
                "label" => "Email",
                "label_attr" => [
                    "class" => "form-label",
                ],
                "constraints" => [
                    new Assert\Length(["min" => 2, "max" => 180]),
                    new Assert\Email(),
                    new Assert\NotBlank(),
                ],
            ])
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
            //-------------- SUBMIT --------------

            ->add("submit", SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class'=>'btn btn-success'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class" => User::class,
        ]);
    }
}
