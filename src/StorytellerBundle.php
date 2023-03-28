<?php

namespace CaptJM\Bundle\StorytellerBundle;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use CaptJM\Bundle\StorytellerBundle\DependencyInjection\StorytellerExtension;

class StorytellerBundle extends AbstractBundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new StorytellerExtension();
    }
}