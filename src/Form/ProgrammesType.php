<?php

namespace App\Form;

use App\Entity\Programmes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\File;

class ProgrammesType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder
            ->add("name", TextType::class, [
                "attr" => [
                    "class" => "form-control",
                    "minlength" => "2",
                ],
                "label" => "Nom",
                "label_attr" => [
                    "class" => "form-label mt-4",
                ],
                "constraints" => [
                    new Assert\Length(["min" => 2]),
                    new Assert\NotBlank(),
                ],
            ])
            ->add("description", TextareaType::class, [
                "attr" => [
                    "class" => "form-control",
                    "minlength" => "2",
                ],
                "label" => "Déscription",
                "label_attr" => [
                    "class" => "form-label mt-4",
                ],
                "constraints" => [new Assert\NotBlank()],
            ])
            ->add("image", FileType::class, [
                "mapped" => false,
                "required" => false,
                "attr" => [
                    "class" => "form-control"
                ],
                "label_attr" => [
                    "class" => "form-label mt-4 ",
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '50000k'
                    ])
                ]
            ])
            ->add("submit", SubmitType::class, [
                "label" => "Valider",
                "attr" => [
                    "class" => "btn btn-primary mt-4 mb-4",
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class" => Programmes::class,
        ]);
    }
}
