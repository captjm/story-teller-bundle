<?php

namespace CaptJM\Bundle\StoryTellerBundle\Admin\Field;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;

class TranslationsField implements FieldInterface
{
    use FieldTrait;

    public const LOCALES = 'locales';
    public const ENTITY_CLASS_NAME = 'entityClassName';
    public static function new(string $propertyName, ?string $label = "Translations"): self
    {
        return (new self())
            ->setLabel($label)
            ->setProperty($propertyName)
            ->setTemplatePath('admin/field/translations.html.twig');
    }

    public function setLocales($locales): self
    {
        $this->setCustomOption(self::LOCALES, $locales);

        return $this;
    }

    public function setEntityClassName($entityClassName): self
    {
        $this->setCustomOption(self::ENTITY_CLASS_NAME, $entityClassName);
        return $this;
    }
}