<?php

declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: "App\Repository\IngredientRepository")]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    public function __construct(
        #[ORM\Column(type: 'string', length: 255)]
        private string $name,
        #[ORM\OneToOne(targetEntity: "App\Entity\NutritionalValue", mappedBy: 'ingredient', cascade: ['persist', 'remove'])]
        private ?NutritionalValue $nutritionalValue = null
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getNutritionalValue(): ?NutritionalValue
    {
        return $this->nutritionalValue;
    }

    public function setNutritionalValue(NutritionalValue $nutritionalValue): self
    {
        $this->nutritionalValue = $nutritionalValue;

        return $this;
    }
}
