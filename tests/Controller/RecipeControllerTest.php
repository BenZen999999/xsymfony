<?php
declare(strict_types=1);

namespace App\Tests\Controller;

use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Recipe;
use App\Service\RecipeService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;

class RecipeControllerTest extends WebTestCase
{
    private Recipe $recipe;
    private RecipeService $recipeService;
    private RecipeRepository $recipeRepository;
    private EntityManagerInterface $entityManager;
    private ContainerInterface $container;
    private KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        // Initialize client and container
        $this->client = static::createClient();
        $this->container = $this->client->getContainer();

        // Mocking Recipe entity
        $this->recipe = new Recipe('test recipe');
        // Set other necessary properties...

        // Mocking RecipeService
        $this->recipeService = $this->createMock(RecipeService::class);
        $this->recipeService->method('calculateNutritionalValues')
            ->willReturn(['calories' => 200, 'protein' => 10, 'carbs' => 30, 'fat' => 5]);

        // Mocking the repository to return the mocked recipe
        $this->recipeRepository = $this->createMock(RecipeRepository::class);
        $this->recipeRepository->method('find')
            ->willReturn($this->recipe);

        // Mocking EntityManager to return the mocked repository
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->entityManager->method('getRepository')
            ->willReturn($this->recipeRepository);

        // Overriding the services in the container
        $this->container->set('App\Service\RecipeService', $this->recipeService);
    }

    public function testShow(): void
    {

        // Requesting the show route
        $this->client->request('GET', '/recipe/1');

        $this->assertSelectorTextContains('h1', 'test recipe');
        $this->assertSelectorTextContains('.nutritional-values', 'Calories: 200');
        $this->assertSelectorTextContains('.nutritional-values', 'Protein: 10');
        $this->assertSelectorTextContains('.nutritional-values', 'Carbs: 30');
        $this->assertSelectorTextContains('.nutritional-values', 'Fat: 5');
    }
}
