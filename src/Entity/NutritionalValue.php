<?php

declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: "App\Repository\NutritionalValueRepository")]
class NutritionalValue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    public function __construct(
        #[ORM\Column(type: 'float')]
        private float $calories,
        #[ORM\Column(type: 'float')]
        private float $protein,
        #[ORM\Column(type: 'float')]
        private float $fat,
        #[ORM\Column(type: 'float')]
        private float $carbohydrates,
        #[ORM\Column(type: 'string', length: 10)]
        private string $unit,
        #[ORM\OneToOne(targetEntity: "App\Entity\Ingredient", inversedBy: 'nutritionalValue')]
        #[ORM\JoinColumn(nullable: false)]
        private Ingredient $ingredient
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCalories(): float
    {
        return $this->calories;
    }

    public function getProtein(): float
    {
        return $this->protein;
    }

    public function getFat(): float
    {
        return $this->fat;
    }

    public function getCarbohydrates(): float
    {
        return $this->carbohydrates;
    }

    public function getUnit(): string
    {
        return $this->unit;
    }

    public function getIngredient(): Ingredient
    {
        return $this->ingredient;
    }
}
