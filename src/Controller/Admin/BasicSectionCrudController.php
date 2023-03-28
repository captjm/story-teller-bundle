<?php

namespace CaptJM\Bundle\StorytellerBundle\Controller\Admin;

use CaptJM\Bundle\StorytellerBundle\Admin\Field\CKEditorField;
use CaptJM\Bundle\StorytellerBundle\Admin\Field\STPositionField;
use CaptJM\Bundle\StorytellerBundle\Entity\Font;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use FM\ElfinderBundle\Form\Type\ElFinderType;
use CaptJM\Bundle\StorytellerBundle\Entity\BasicSection;
use CaptJM\Bundle\StorytellerBundle\Entity\SectionInterface;

class BasicSectionCrudController extends AbstractCrudController
{
    protected ObjectManager $em;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->em = $doctrine->getManager();
    }

    public static function getEntityFqcn(): string
    {
        return BasicSection::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield FormField::addTab('General');
        yield IdField::new('id')->setDisabled();
        yield TextField::new('locale', 'Language')->setDisabled();
        yield AssociationField::new('story');
        yield TextField::new('title');
        yield IntegerField::new('weight');
        yield TextField::new('audio')
            ->setFormType(ElFinderType::class)
            ->setFormTypeOptions(['instance' => 'audios', 'enable' => true])
            ->onlyOnForms();
        yield CKEditorField::new('headline')
            ->addContentCss($this->getParameter('app.fonts_css_url'))
            ->addFontNames($this->em->getRepository(Font::class)->getFontNames())
            ->setConfigName('headline_config');
        yield STPositionField::new('headlinePosition');
        yield ColorField::new('bgColor', 'Background Color');
        yield TextField::new('bgImage', 'Background Image')
            ->setFormType(ElFinderType::class)
            ->setFormTypeOptions(['instance' => 'images', 'enable' => true])
            ->onlyOnForms();
        yield ImageField::new('bgImage', 'Background Image')
            ->setBasePath('/')
            ->hideOnForm();
        yield BooleanField::new('visible');
    }

    public function createEntity(string $entityFqcn): SectionInterface
    {
        /** @var SectionInterface $entity */
        $entity = new $entityFqcn();
        $entity
            ->setLocale($this->getContext()->getRequest()->getLocale())
            ->setWeight(0);
        return $entity;
    }

    public function configureActions(Actions $actions): Actions
    {
        $previewAction = Action::new('preview')
            ->linkToUrl(
                function (BasicSection $entity) {
                    $rc = new \ReflectionClass($entity);
                    $slug = strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0', lcfirst($rc->getShortName())));
                    return '/admin/preview/' . $slug . '/' . $entity->getId();
                })
            ->setHtmlAttributes(['target' => '_blank']);
        return $actions
            ->add(Crud::PAGE_INDEX, $previewAction);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->addFormTheme('form/section_theme.html.twig');
    }
}
