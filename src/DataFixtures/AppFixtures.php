<?php

declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Ingredient;
use App\Entity\NutritionalValue;
use App\Entity\Recipe;
use App\Entity\RecipeIngredient;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $ingredients = [];
        $nutritionalValues = [
            ['calories' => 52.0, 'protein' => 0.3, 'fat' => 0.2, 'carbohydrates' => 14.0, 'unit' => 'g'],
            ['calories' => 33.0, 'protein' => 1.1, 'fat' => 0.3, 'carbohydrates' => 7.0, 'unit' => 'g'],
        ];
        $ingredientNames = ['Apfel', 'Karotte', 'Banane', 'Tomate', 'Gurke', 'Hühnchen', 'Rindfleisch', 'Reis', 'Nudeln', 'Brot'];

        foreach ($ingredientNames as $index => $name) {
            $ingredient = new Ingredient($name);
            $nutritionalValueData = $nutritionalValues[$index % count($nutritionalValues)];
            $nutritionalValue = new NutritionalValue(
                $nutritionalValueData['calories'],
                $nutritionalValueData['protein'],
                $nutritionalValueData['fat'],
                $nutritionalValueData['carbohydrates'],
                $nutritionalValueData['unit'],
                $ingredient
            );

            $ingredient->setNutritionalValue($nutritionalValue);

            $manager->persist($ingredient);
            $manager->persist($nutritionalValue);

            $ingredients[] = $ingredient;
        }

        $recipes = [
            'Obstsalat',
            'Gemüsesuppe',
            'Hühnchenreis',
            'Rindfleischnudeln',
            'Brot mit Tomate',
            'Karottensalat',
            'Gurkensalat',
            'Bananenshake',
            'Tomatenreis',
            'Apfelkuchen',
        ];

        foreach ($recipes as $recipeName) {
            $recipe = new Recipe($recipeName);

            for ($i = 0; $i < 3; $i++) {
                $ingredient = $ingredients[array_rand($ingredients)];
                $quantity = rand(1, 100) / 10.0;

                $recipeIngredient = new RecipeIngredient($recipe, $ingredient, $quantity);

                $manager->persist($recipeIngredient);
            }

            $manager->persist($recipe);
        }

        $manager->flush();
    }
}
