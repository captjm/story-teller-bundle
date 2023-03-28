<?php

namespace CaptJM\Bundle\StorytellerBundle\DependencyInjection;

use Exception;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class StorytellerExtension extends Extension
{
    /**
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $config = ($container->hasParameter('story_teller')) ?
            $container->getParameter('story_teller') : [];
        $container->setParameter('story_teller',
            array_merge_recursive($config, [
                'sections' => []
            ]));
    }
}