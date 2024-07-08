<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Recipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recipe>
 */
class RecipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recipe::class);
    }

    public function save(Recipe $recipe): void
    {
        $this->_em->persist($recipe);
        $this->_em->flush();
    }

    public function remove(Recipe $recipe): void
    {
        $this->_em->remove($recipe);
        $this->_em->flush();
    }
}
