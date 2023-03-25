<?php

namespace CaptJM\Bundle\StoryTellerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;

class SectionType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fqcn', TextType::class, ['disabled' => true])
            ->add('id', TextType::class, ['disabled' => true])
            ->add('title', HiddenType::class)
            ->add('weight', HiddenType::class, ['empty_data' => 0]);
    }
}