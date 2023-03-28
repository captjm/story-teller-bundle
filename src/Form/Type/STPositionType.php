<?php

namespace CaptJM\Bundle\StorytellerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class STPositionType extends AbstractType
{
    public function getParent(): string
    {
        return FormType::class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setCompound(true)
            ->add('h_pos', ChoiceType::class, [
                'choices' => $options['horizontal_positions'],
                'label' => false,
            ])
            ->add('v_pos', ChoiceType::class, [
                'choices' => $options['vertical_positions'],
                'label' => false,
            ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'horizontal_positions' => [
                    'Left' => 'left',
                    'Center' => 'center',
                    'Right' => 'right',
                ],
                'vertical_positions' => [
                    'Top' => 'top',
                    'Center' => 'center',
                    'Bottom' => 'bottom',
                ],
            ])
            ->setAllowedTypes('horizontal_positions', ['null', 'array'])
            ->setAllowedTypes('vertical_positions', ['null', 'array']);
    }
}