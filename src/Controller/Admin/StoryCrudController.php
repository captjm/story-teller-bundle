<?php

namespace CaptJM\Bundle\StorytellerBundle\Controller\Admin;

use CaptJM\Bundle\StorytellerBundle\Admin\Field\CKEditorField;
use CaptJM\Bundle\StorytellerBundle\Admin\Field\TranslationsField;
use CaptJM\Bundle\StorytellerBundle\Entity\Font;
use CaptJM\Bundle\StorytellerBundle\Form\Type\SectionType;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use CaptJM\Bundle\StorytellerBundle\Entity\Story;

class StoryCrudController extends AbstractCrudController
{
    private ObjectManager $em;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->em = $doctrine->getManager();
    }

    public static function getEntityFqcn(): string
    {
        return Story::class;
    }

    public function createEntity(string $entityFqcn)
    {
        return Story::new()
            ->setPublished(new \DateTime())
            ->setLocale($this->getContext()->getRequest()->getLocale());
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->addFormTheme('form/story_theme.html.twig')
            ->showEntityActionsInlined();
    }

    public function configureFields(string $pageName): iterable
    {
        yield FormField::addTab('General');
        yield IdField::new('id')->setDisabled();

        $locales = $this->getParameter("app.fallbacks");
        yield ChoiceField::new('locale')
            ->setChoices(array_combine(array_map("strtoupper", $locales), $locales));

        yield TextField::new('title');
        yield SlugField::new("slug")->setTargetFieldName("title");

        yield CKEditorField::new('content')
            ->addContentCss($this->getParameter('app.fonts_css_url'))
            ->addFontNames($this->em->getRepository(Font::class)->getFontNames())
            ->setConfigName('content_config');

        yield DateTimeField::new("published")->renderAsChoice();
        yield BooleanField::new('visible');

        if ($pageName === "edit" or $pageName === "new") {
            yield FormField::addTab('Sections');

            $storytellerConfig = $this->getParameter('story_teller');

            yield CollectionField::new('sections')
                ->onlyOnForms()
                ->addHtmlContentsToBody($this->renderView("form/select_section_modal.html.twig", [
                    'sectionTypes' => array_column($storytellerConfig['sections'], 'fqcn'),
                ]))
                ->setEntryType(SectionType::class)
                ->setColumns(12)
                ->renderExpanded(false)
                ->setFormTypeOption('attr', ['class' => 'ordered-collection story-sections row'])
                ->setCssClass('w-100 story-sections-field')
                ->setEntryIsComplex(false)
                ->showEntryLabel(false)
                ->allowAdd(false)
                ->onlyOnForms();
        } else {
            yield TranslationsField::new('translation')
                ->hideOnForm()
                ->setEntityClassName('story')
                ->setLocales($this->getParameter("app.fallbacks"));
        }
    }

    public function createIndexQueryBuilder(
        SearchDto        $searchDto,
        EntityDto        $entityDto,
        FieldCollection  $fields,
        FilterCollection $filters
    ): QueryBuilder
    {
        return parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters)
            ->andWhere('entity.locale = :locale')
            ->setParameter('locale', $this->getContext()->getI18n()->getLocale());
    }

    public function configureActions(Actions $actions): Actions
    {
        $previewAction = Action::new('preview')
            ->linkToUrl(
                function (Story $entity) {
                    return '/' . $entity->getLocale() . '/story/' . $entity->getSlug();
                })
            ->setHtmlAttributes(['target' => '_blank']);
        return $actions
            ->add(Crud::PAGE_INDEX, $previewAction);
    }

    public function configureAssets(Assets $assets): Assets
    {
        return parent::configureAssets($assets)
            ->addWebpackEncoreEntry('crud_story_styles')
            ->addWebpackEncoreEntry('ordered_collection');
    }
}
