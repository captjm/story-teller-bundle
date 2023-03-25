<?php

namespace CaptJM\Bundle\StoryTellerBundle\Controller\Admin;

use CaptJM\Bundle\StoryTellerBundle\Entity\Font;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FontCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Font::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $uploadDir = 'public/' . $this->getParameter('app.fonts_directory');
        return [
            IdField::new('id')
                ->setDisabled(),
            TextField::new('name'),
            SlugField::new('slug')
                ->setTargetFieldName('name'),
            ImageField::new('ttf', 'TTF')
                ->hideOnIndex()
                ->setUploadDir($uploadDir)
                ->setFormTypeOption('attr', [
                    'accept' => 'font/ttf'
                ]),
            ImageField::new('eot', 'EOT')
                ->hideOnIndex()
                ->setUploadDir($uploadDir)
                ->setFormTypeOption('attr', [
                    'accept' => 'application/vnd.ms-fontobject'
                ]),
            ImageField::new('otf', 'OTF')
                ->hideOnIndex()
                ->setUploadDir($uploadDir)
                ->setFormTypeOption('attr', [
                    'accept' => 'font/otf',
                ]),
            ImageField::new('woff', 'WOFF')
                ->hideOnIndex()
                ->setUploadDir($uploadDir)
                ->setFormTypeOption('attr', [
                    'accept' => 'font/woff',
                ]),
            ImageField::new('woff2', 'WOFF2')
                ->hideOnIndex()
                ->setUploadDir($uploadDir)
                ->setFormTypeOption('attr', [
                    'accept' => 'font/woff2',
                ]),
            ImageField::new('svg', 'SVG')
                ->hideOnIndex()
                ->setUploadDir($uploadDir)
                ->setFormTypeOption('attr', [
                    'accept' => 'image/svg+xml'
                ]),
        ];
    }
}