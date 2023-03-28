<?php

namespace CaptJM\Bundle\StorytellerBundle\Controller\Admin;

use CaptJM\Bundle\StorytellerBundle\Entity\Font;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Filesystem\Filesystem;

class AbstractFontCrudController extends AbstractCrudController
{
    private string $uploadDir;

    public static function getEntityFqcn(): string
    {
        return Font::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $fs = new Filesystem();
        $this->uploadDir = 'public/' . $this->getParameter('storyteller.fonts_directory');
        $dir = $this->getParameter('kernel.project_dir') . "/" . $this->uploadDir;
        if(!$fs->exists($dir)) {
            $fs->mkdir($dir);
        }
        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->setDisabled(),
            TextField::new('name'),
            SlugField::new('slug')
                ->setTargetFieldName('name'),
            ImageField::new('ttf', 'TTF')
                ->hideOnIndex()
                ->setUploadDir($this->uploadDir)
                ->setFormTypeOption('attr', [
                    'accept' => 'font/ttf'
                ]),
            ImageField::new('eot', 'EOT')
                ->hideOnIndex()
                ->setUploadDir($this->uploadDir)
                ->setFormTypeOption('attr', [
                    'accept' => 'application/vnd.ms-fontobject'
                ]),
            ImageField::new('otf', 'OTF')
                ->hideOnIndex()
                ->setUploadDir($this->uploadDir)
                ->setFormTypeOption('attr', [
                    'accept' => 'font/otf',
                ]),
            ImageField::new('woff', 'WOFF')
                ->hideOnIndex()
                ->setUploadDir($this->uploadDir)
                ->setFormTypeOption('attr', [
                    'accept' => 'font/woff',
                ]),
            ImageField::new('woff2', 'WOFF2')
                ->hideOnIndex()
                ->setUploadDir($this->uploadDir)
                ->setFormTypeOption('attr', [
                    'accept' => 'font/woff2',
                ]),
            ImageField::new('svg', 'SVG')
                ->hideOnIndex()
                ->setUploadDir($this->uploadDir)
                ->setFormTypeOption('attr', [
                    'accept' => 'image/svg+xml'
                ]),
        ];
    }
}