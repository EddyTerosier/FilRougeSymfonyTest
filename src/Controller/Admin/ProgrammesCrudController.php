<?php

namespace App\Controller\Admin;

use App\Entity\Programmes;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProgrammesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Programmes::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom du programme'),
            ImageField::new('imageName', 'Image')
            ->setBasePath('upload/programmes/')
            ->setUploadDir('public/upload/programmes')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false),
            TextareaField::new('description','Description du programme')
            
        ];
    }
}
