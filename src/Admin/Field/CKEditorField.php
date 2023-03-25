<?php

namespace CaptJM\Bundle\StoryTellerBundle\Admin\Field;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class CKEditorField implements FieldInterface
{
    use FieldTrait;
    public const CONTENT_CSS = 'contentCss';
    public static function new(string $propertyName, ?string $label = null): self
    {
        return (new self())
            ->setLabel($label)
            ->setProperty($propertyName)
            ->setFormType(CKEditorType::class)
            ->onlyOnForms()
            ;
    }

    public function setConfigName($configName): self
    {
        $this->setFormTypeOption('config_name', $configName);
        return $this;
    }

    public function addContentCss($url): self
    {
        return $this->addToConfig('contentsCss', $url, true);
    }

    public function addFontNames(string $fontNames): self{
        return $this->addToConfig('font_names', $fontNames);
    }

    public function addToConfig(string $key, mixed $value, bool $isArray = false): self
    {
        $config = $this->getAsDto()->getFormTypeOption('config');
        if (!$config) $config = [];

        if ($isArray) {
            if (!array_key_exists($key, $config)) $config[$key] = [];
            $config[$key][] = $value;
        } else {
            $config[$key] = $value;
        }
        return $this->setFormTypeOption('config', $config);
    }
}