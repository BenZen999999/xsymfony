<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Entity\Recipe;
use App\Service\RecipeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{
    #[Route('/recipe/{id}', name: 'recipe_show')]
    public function show(Recipe $recipe, RecipeService $recipeService): Response
    {
        $nutritionalValues = $recipeService->calculateNutritionalValues($recipe);

        return $this->render('recipe/show.html.twig', [
            'recipe'            => $recipe,
            'nutritionalValues' => $nutritionalValues,
        ]);
    }
}
