<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\ORM\Doctrine\Populator;


/**
 * Class AppFixtures
 * NE PAS OUBLIER DE RELANCER LA COMMANDE SUIVANTE APRES CHAQUE CHANGEMENT DU FICHIER
 *
 *      php bin/console doctrine:fixtures:load
 *
 */
class AppFixtures extends Fixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $generator = \Faker\Factory::create();
        $populator = new Populator($generator, $manager);
        $populator->addEntity(Category::class, 10);
        $populator->addEntity(Product::class, 150, [
            "price" => function() use ($generator) {
                return $generator->randomFloat(2, 0, 99999999.99);
            },
            "imageName" => function() { return 'hamac.jpg'; }
        ]);

        $populator->execute();

        // Enregistrement du produit ainsi que sa catégorie
        //$manager->flush();
    }
}