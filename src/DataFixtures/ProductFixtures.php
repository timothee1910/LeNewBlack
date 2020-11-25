<?php


namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Collections;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        // Creation de 3 category faker
        for ($i=1; $i<=3; $i++) {
            $category = new Category();
            $category->setName($faker->sentence());
            $collections = new Collections();
            $collections->setName($faker->name());
            $manager->persist($category);
            $manager->persist($collections);
            // Pour chaque catégory et collection crées On crée entre 4 et 6 produits
            for ($j = 1; $j <= mt_rand(4,6); $j++) {
                $product = new Product();
                $product->setName($faker->sentence())
                        ->setModel($faker->numberBetween($min=0,$max=21))
                    ->setSize($faker->randomLetter)
                    ->setPrice($faker->numberBetween($min=3,$max=210))
                    ->setVariants($faker->numberBetween($min=1,$max=3))
                        ->setCategory($category)
                        ->setCollection($collections);
                $manager->persist($product);
            }
        }
        //permet l'insertion dans la bdd après le persist
        $manager->flush();
    }

}