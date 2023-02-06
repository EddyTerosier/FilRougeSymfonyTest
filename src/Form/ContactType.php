<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints as Assert;

class ContactType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder
            ->add("firstName", TextType::class, [
                "attr" => [
                    "class" => "form-control",
                ],
                "label" => "Prénom",
                "label_attr" => [
                    "class" => "form-label mt-4",
                ],
            ])
            ->add("lastName", TextType::class, [
                "attr" => [
                    "class" => "form-control",
                ],
                "label" => "Nom",
                "label_attr" => [
                    "class" => "form-label mt-4",
                ],
            ])
            ->add("email", EmailType::class, [
                "attr" => [
                    "class" => "form-control",
                    "placeholder" => "Email@Dreamgym.com",
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
            ->add("subject", TextType::class, [
                "attr" => [
                    "class" => "form-control",
                ],
                "label" => "Sujet",
                "label_attr" => [
                    "class" => "form-label mt-4",
                ],
            ])
            ->add("message", TextareaType::class, [
                "attr" => [
                    "class" => "form-control",
                ],
                "label" => "Message",
                "label_attr" => [
                    "class" => "form-label mt-4",
                ],
                "constraints" => [new Assert\NotBlank()],
            ])
            ->add("submit", SubmitType::class, [
                "attr" => [
                    "class" => "btn btn-secondary",
                ],
                "label" => "Envoyer",
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class" => Contact::class,
        ]);
    }
}
