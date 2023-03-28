<?php

namespace CaptJM\Bundle\StorytellerBundle\Admin\Field;

use CaptJM\Bundle\StorytellerBundle\Form\Type\STPositionType;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;

class STPositionField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = null): self
    {
        return (new self())
            ->setLabel($label)
            ->setProperty($propertyName)
            ->setFormType(STPositionType::class)
            ->setTemplatePath('admin/field/st_position.html.twig')
            ;
    }
}