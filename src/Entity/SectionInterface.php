<?php

namespace CaptJM\Bundle\StorytellerBundle\Entity;
interface SectionInterface
{
    public function getStory(): ?Story;

    public function setStory(?Story $story): self;

    public function getId(): ?int;

    public function getTitle(): ?string;

    public function setTitle(string $title): self;

    public function getLocale(): ?string;


    public function setLocale(string $locale): self;


    public function getWeight(): ?int;


    public function setWeight(int $weight): self;

    public function getHeadline(): ?string;


    public function setHeadline(?string $headline): self;


    public function getBgImage(): ?string;


    public function setBgImage(?string $bgImage): self;


    public function getBgColor(): ?string;


    public function setBgColor(?string $bgColor): self;

    public function isVisible(): ?bool;


    public function setVisible(bool $visible): self;

    public function getSectionData(): array;

    public function getFqcn(): string;

    public function getOptions(): array;
}