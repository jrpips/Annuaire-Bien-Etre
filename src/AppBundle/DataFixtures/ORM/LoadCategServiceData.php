<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker\Factory;
use AppBundle\Entity\Image;
use AppBundle\Entity\Prestataire;
use AppBundle\Entity\CategService;

class LoadCategServiceData extends AbstractFixture implements OrderedFixtureInterface {

    private $nb = 5;

    public function load(ObjectManager $manager) {
        $j;
        $faker = Factory::create('fr_BE');
        for ($i = 0; $i < $this->nb; $i++) {
            
            $categ = new CategService();
            $categ->setNom($faker->colorName);
            $categ->setDescription($faker->sentence($nbWords = 6, $variableNbWords = false));
            $categ->setEnAvant(false);
            $categ->setValide(true);
            
            $random = rand(1, 4);
            for ($k = 0; $k < $random; $k++) {
                $categ->addPrestataire($this->getReference('prestataire' . $k));
            }
            
            $j = $i + 14;
            $categ->setImage($this->getReference('img' . $j));

            $manager->persist($categ);

            $this->addReference('categ' . $i, $categ);
        }
        $manager->flush();
    }

    public function getOrder() {
        // l'ordre ds lequel les fixtures seront chargées         
        return 12;
    }

}
