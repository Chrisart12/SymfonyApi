<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Comment;
use App\DataFixtures\PostFixures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        
        for ($i=1; $i <= 30 ; $i++) { 

            $comment = new Comment();

            $comment->setUsername($faker->firstName())
                    ->setContent($faker->paragraphs(3, true))
                    ->setPost($this->getReference('POST'. $faker->numberBetween(1, 30)));
            $manager->persist($comment);
        }

        $manager->flush();
    }

    /**
     * C'est une fonction de DependentFixtureInterface
     * permet de exécuter les fictures dans l'ordre
     *
     * @return void
     */
    public function getDependencies()
    {
        return [
            PostFixures::class,
        ];
    }
}
