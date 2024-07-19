<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Post;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PostFixures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        
        for ($i=0; $i <= 30 ; $i++) { 

            $post = new Post();

            $post->setTitle($faker->word())
                ->setContent($faker->paragraphs(2, true));
        
            $manager->persist($post);

            $this->addReference('POST'. $i, $post);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
