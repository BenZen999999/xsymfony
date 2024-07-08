<?php

declare(strict_types = 1);

namespace App\Service;

use App\Entity\Recipe;

class RecipeService
{
    /**
     * @return float[]|int[]
     */
    public function calculateNutritionalValues(Recipe $recipe): array
    {
        $totalCalories = 0.0;
        $totalProtein = 0.0;
        $totalFat = 0.0;
        $totalCarbohydrates = 0.0;

        foreach ($recipe->getRecipeIngredients() as $recipeIngredient) {
            $ingredient = $recipeIngredient->getIngredient();
            $nutritionalValue = $ingredient->getNutritionalValue();
            $quantity = $recipeIngredient->getQuantity();

            $totalCalories += $nutritionalValue->getCalories() * $quantity;
            $totalProtein += $nutritionalValue->getProtein() * $quantity;
            $totalFat += $nutritionalValue->getFat() * $quantity;
            $totalCarbohydrates += $nutritionalValue->getCarbohydrates() * $quantity;
        }

        return [
            'calories'      => $totalCalories,
            'protein'       => $totalProtein,
            'fat'           => $totalFat,
            'carbohydrates' => $totalCarbohydrates,
        ];
    }
}
