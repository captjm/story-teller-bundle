<?php

namespace CaptJM\Bundle\StoryTellerBundle\Entity;

use CaptJM\Bundle\StoryTellerBundle\Repository\FontRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FontRepository::class)]
class Font
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ttf = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $woff = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $woff2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $eot = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $otf = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $svg = null;

    private const FORMATS = [
        'eot' => 'embedded-opentype',
        'ttf' => 'truetype',
        'woff' => 'woff',
        'woff2' => 'woff2',
        'otf' => 'opentype',
        'svg' => 'svg',
    ];

    public function getId(): ?int
    {
        return $this->id;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTtf(): ?string
    {
        return $this->ttf;
    }

    public function setTtf(?string $ttf): self
    {
        $this->ttf = $ttf;

        return $this;
    }

    public function getWoff(): ?string
    {
        return $this->woff;
    }

    public function setWoff(?string $woff): self
    {
        $this->woff = $woff;

        return $this;
    }

    public function getWoff2(): ?string
    {
        return $this->woff2;
    }

    public function setWoff2(?string $woff2): self
    {
        $this->woff2 = $woff2;

        return $this;
    }

    public function getEot(): ?string
    {
        return $this->eot;
    }

    public function setEot(?string $eot): self
    {
        $this->eot = $eot;

        return $this;
    }

    public function getOtf(): ?string
    {
        return $this->otf;
    }

    public function setOtf(?string $otf): self
    {
        $this->otf = $otf;

        return $this;
    }

    public function getSvg(): ?string
    {
        return $this->svg;
    }

    public function setSvg(?string $svg): self
    {
        $this->svg = $svg;

        return $this;
    }

    public function getCSS(): string
    {
        $css = sprintf("@font-face {\n  font-family:'%s';\n  src:", $this->name);

        foreach (self::FORMATS as $key => $format) {
            if ($this->$key) $css .= sprintf("\n    url(\"%s\") format(\"%s\"),", $this->$key, $format);
        }
        return rtrim($css, ',') . ";\n}";
    }
}
