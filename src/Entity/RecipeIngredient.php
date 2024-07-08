<?php

declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: "App\Repository\RecipeIngredientRepository")]
class RecipeIngredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    public function __construct(
        #[ORM\ManyToOne(targetEntity: "App\Entity\Recipe", inversedBy: 'recipeIngredients')]
        #[ORM\JoinColumn(nullable: false)]
        private Recipe $recipe,
        #[ORM\ManyToOne(targetEntity: "App\Entity\Ingredient")]
        #[ORM\JoinColumn(nullable: false)]
        private Ingredient $ingredient,
        #[ORM\Column(type: 'float')]
        private float $quantity
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getRecipe(): Recipe
    {
        return $this->recipe;
    }

    public function getIngredient(): Ingredient
    {
        return $this->ingredient;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }
}
