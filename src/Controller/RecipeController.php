<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\RecipeIngredient;
use App\Form\RecipeIngredientType;
use App\Repository\IngredientRepository;
use App\Service\RecipeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly IngredientRepository $ingredientRepository,
        private readonly RecipeService $recipeService,
    ) {
    }

    #[Route('/recipe/{id}', name: 'recipe_show', methods: ['GET', 'POST'])]
    public function show(Recipe $recipe, Request $request): Response
    {
        $recipeIngredient = new RecipeIngredient($recipe, $this->ingredientRepository->find(1), 0.0); // Beispielhaft eine Zutat laden

        $form = $this->createForm(RecipeIngredientType::class, $recipeIngredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($recipeIngredient);
            $this->em->flush();

            return $this->redirectToRoute('recipe_show', ['id' => $recipe->getId()]);
        }

        return $this->render('recipe/show.html.twig', [
            'recipe'            => $recipe,
            'form'              => $form->createView(),
            'nutritionalValues' => $this->recipeService->calculateNutritionalValues($recipe),
        ]);
    }

    #[Route('/recipe/{id}/ingredient/{ingredientId}/edit', name: 'recipe_ingredient_edit')]
    public function editIngredient(int $id, int $ingredientId, Request $request): Response
    {
        $recipeIngredient = $this->em->getRepository(RecipeIngredient::class)->find($ingredientId);

        if (!$recipeIngredient) {
            throw $this->createNotFoundException('Die Zutat wurde nicht gefunden.');
        }

        $form = $this->createForm(RecipeIngredientType::class, $recipeIngredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            return $this->redirectToRoute('recipe_show', ['id' => $id]);
        }

        return $this->render('recipe/edit_ingredient.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/recipe/{id}/ingredient/{ingredientId}/delete', name: 'recipe_ingredient_delete', methods: ['POST'])]
    public function deleteIngredient(int $id, int $ingredientId, Request $request): Response
    {
        $recipeIngredient = $this->em->getRepository(RecipeIngredient::class)->find($ingredientId);

        if (!$recipeIngredient) {
            throw $this->createNotFoundException('Die Zutat wurde nicht gefunden.');
        }

        if ($this->isCsrfTokenValid('delete' . $recipeIngredient->getId(), $request->request->get('_token'))) {
            $this->em->remove($recipeIngredient);
            $this->em->flush();
        }

        return $this->redirectToRoute('recipe_show', ['id' => $id]);
    }
}
