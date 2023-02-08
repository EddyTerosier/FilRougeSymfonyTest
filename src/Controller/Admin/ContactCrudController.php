<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ContactCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contact::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('lastName', 'Nom'),
            TextField::new('firstName', 'Prénom'),
            TextField::new('email')->setFormTypeOption('disabled','disabled'),
            TextField::new('subject', 'Objet'),
            TextEditorField::new('message'),
            DateTimeField::new('createdAt', 'Créer à')->hideOnForm()
        ];
    }
}
