<?php

namespace CaptJM\Bundle\StorytellerBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use CaptJM\Bundle\StorytellerBundle\Repository\StoryRepository;

#[ORM\Entity(repositoryClass: StoryRepository::class)]
class Story
{
    public array $loadedSections = [];
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(length: 255)]
    private ?string $title = null;
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $extract = null;
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;
    #[ORM\Column]
    private ?bool $visible = null;
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $published = null;
    #[ORM\Column(length: 255)]
    private ?string $slug = null;
    #[ORM\Column(length: 2)]
    private ?string $locale = null;
    #[ORM\ManyToOne(inversedBy: 'stories')]
    private ?EntityTranslation $translation = null;
    #[ORM\Column(type: Types::JSON)]
    private array $sections = [];

    public static function new(): self
    {
        return new Story();
    }

    public function addSection(SectionInterface|array $section): self
    {
        if ($section instanceof SectionInterface) $section = $section->getSectionData();
        if ($section['id']) {
            $index = count($this->sections);
            foreach ($this->sections as $i => $item) {
                if ($item['id'] === $section['id'] and $item['fqcn'] === $section['fqcn']) $index = $i;
            }
            $this->sections [$index] = $section;
            $this->sortSections();
        }
        return $this;
    }

    public function sortSections(): self
    {
        uasort($this->sections, function (array $a, array $b) {
            return $a['weight'] <=> $b['weight'];
        });
        $this->sections = array_values($this->sections);
        return $this;
    }

    public function removeSection(SectionInterface|array $section): self
    {
        if ($section instanceof SectionInterface) $section = $section->getSectionData();
        $this->sections = array_filter($this->sections, function (array $item) use ($section) {
            return $item['id'] !== $section['id'] or $item['fqcn'] !== $section['fqcn'];
        });
        return $this->sortSections();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSections(): array
    {
        return $this->sections;
    }

    public function getExtract(): ?string
    {
        return $this->extract;
    }

    public function setExtract(?string $extract): self
    {
        $this->extract = $extract;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function isVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }

    public function getPublished(): ?\DateTimeInterface
    {
        return $this->published;
    }

    public function setPublished(\DateTimeInterface $published): self
    {
        $this->published = $published;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    public function getTranslation(): ?EntityTranslation
    {
        return $this->translation;
    }

    public function setTranslation(?EntityTranslation $translation): self
    {
        $this->translation = $translation;

        return $this;
    }

    public function __toString(): string
    {
        return $this->title;
    }
}
