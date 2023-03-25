<?php

namespace CaptJM\Bundle\StoryTellerBundle;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use CaptJM\Bundle\StoryTellerBundle\DependencyInjection\StoryTellerExtension;

class StoryTellerBundle extends AbstractBundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new StoryTellerExtension();
    }
}