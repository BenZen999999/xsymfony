<?php

namespace App\Tests\Service;

use App\Entity\Ingredient;
use App\Entity\NutritionalValue;
use App\Entity\Recipe;
use App\Entity\RecipeIngredient;
use App\Service\RecipeService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RecipeServiceTest extends WebTestCase
{
    private RecipeService $recipeService;
    public function setUp(): void
    {
        $this->recipeService = new RecipeService();
    }

    public function testCalculateNutritionValues(): void
    {
        $recipe = $this->createTestData();
        var_dump($recipe);
        $result = $this->recipeService->calculateNutritionalValues($recipe);
        $this->assertEquals(85.0, $result['calories']);
        $this->assertEquals(1.4000000000000001, $result['protein']);
        $this->assertEquals(0.5, $result['fat']);
        $this->assertEquals(21.0, $result['carbohydrates']);
    }

    private function createTestData(): Recipe
    {
        $recipe = new Recipe('Karottensalat');

        $ingredient1 = new Ingredient('Apfel');
        $nutritionalValue1 = new NutritionalValue(52.0, 0.3, 0.2, 14.0, 'g', $ingredient1);
        $ingredient1->setNutritionalValue($nutritionalValue1);

        $ingredient2 = new Ingredient('Karotte');
        $nutritionalValue2 = new NutritionalValue(33.0, 1.1, 0.3, 7.0, 'g', $ingredient2);
        $ingredient2->setNutritionalValue($nutritionalValue2);

        $recipeIngredient1 = new RecipeIngredient($recipe, $ingredient1, 1);
        $recipeIngredient2 = new RecipeIngredient($recipe, $ingredient2, 1);

        $recipe->addRecipeIngredient($recipeIngredient1);
        $recipe->addRecipeIngredient($recipeIngredient2);

        return $recipe;
    }
}
