<?php

namespace CaptJM\Bundle\StorytellerBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\MappedSuperclass;

#[MappedSuperclass]
class BasicSection implements SectionInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;
    #[ORM\Column(length: 255)]
    protected ?string $title = null;
    #[ORM\Column(length: 2)]
    protected ?string $locale = null;
    #[ORM\Column]
    protected ?int $weight = null;
    #[ORM\ManyToOne]
    protected ?Story $story = null;
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    protected ?string $headline = null;
    #[ORM\Column(length: 255, nullable: true)]
    protected ?string $bgImage = null;
    #[ORM\Column(length: 32, nullable: true)]
    protected ?string $bgColor = null;
    #[ORM\Column(length: 255, nullable: true)]
    protected ?string $audio = null;
    #[ORM\Column]
    protected ?bool $visible = null;
    #[ORM\Column(name: 'hdl_pos', type: Types::JSON, length: 16, nullable: true)]
    protected ?array $headlinePosition = null;
    #[ORM\Column(name: 'hdl_pads', length: 24, nullable: true)]
    protected ?array $headlinePaddings = null;
    #[ORM\Column(nullable: true)]
    protected ?array $options = [];
    protected $fqcn;

    public function __construct()
    {
        $this->fqcn = get_class($this);
    }

    public function getAudio(): ?string
    {
        return $this->audio;
    }

    public function setAudio(?string $audio): self
    {
        $this->audio = $audio;
        return $this;
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

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getStory(): ?Story
    {
        return $this->story;
    }

    public function setStory(?Story $story): self
    {
        if ($this->story !== $story) {
            $this->story?->removeSection($this);
        }
        $story?->addSection($this);
        $this->story = $story;
        return $this;
    }

    public function getHeadline(): ?string
    {
        return $this->headline;
    }

    public function setHeadline(?string $headline): self
    {
        $this->headline = $headline;

        return $this;
    }

    public function getBgImage(): ?string
    {
        return $this->bgImage;
    }

    public function setBgImage(?string $bgImage): self
    {
        $this->bgImage = $bgImage;

        return $this;
    }

    public function getBgColor(): ?string
    {
        return $this->bgColor;
    }

    public function setBgColor(?string $bgColor): self
    {
        $this->bgColor = $bgColor;

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

    public function getFqcn(): string
    {
        return get_class($this);
    }

    public function getHeadlinePosition(): ?array
    {
        return $this->headlinePosition;
    }

    public function setHeadlinePosition(?array $headlinePosition): self
    {
        $this->headlinePosition = $headlinePosition;

        return $this;
    }

    public function getHeadlinePaddings(): ?array
    {
        return $this->headlinePaddings;
    }

    public function setHeadlinePaddings(?array $headlinePaddings): self
    {
        $this->headlinePaddings = $headlinePaddings;

        return $this;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function setOptions(?array $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function __toString(): string
    {
        return $this->title;
    }

    public function getSectionData(): array
    {
        return [
            'title' => $this->title,
            'weight' => $this->weight,
            'id' => $this->id,
            'fqcn' => get_class($this),
        ];
    }

    public static function new(): self
    {
        return new self();
    }
}
