<?php

namespace CaptJM\Bundle\StoryTellerBundle\Entity;

use CaptJM\Bundle\StoryTellerBundle\Repository\EntityTranslationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntityTranslationRepository::class)]
class EntityTranslation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
