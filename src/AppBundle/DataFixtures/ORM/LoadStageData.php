<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker\Factory;
use AppBundle\Entity\Stage;
use AppBundle\Entity\Prestataire;

class LoadStageData extends AbstractFixture implements OrderedFixtureInterface {

    private $nb = 2;

    public function load(ObjectManager $manager) {
    $faker = Factory::create();
        for ($i = 0; $i < $this->nb; $i++) {
            
            $stage = new Stage();
            $stage->setNom($faker->colorName);
            $stage->setDescription($faker->sentence($nbWords = 6, $variableNbWords = false));
            $stage->setTarif(100);
            $stage->setDateDebut(new \DateTime());
            $stage->setDateFin(new \DateTime());
            $stage->setAffichageDebut(new \DateTime());
            $stage->setAffichageFin(new \DateTime());
            
            $stage->setPrestataire($this->getReference('prestataire' . $i));       
          
            $manager->persist($stage);
          
        }
        $manager->flush();
    }

    public function getOrder() {
        // l'ordre ds lequel les fixtures seront chargées         
        return 16;
    }

}
