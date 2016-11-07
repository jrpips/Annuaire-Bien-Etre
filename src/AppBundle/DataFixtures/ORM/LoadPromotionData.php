<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker\Factory;
use AppBundle\Entity\Promotion;
use AppBundle\Entity\CategService;
use AppBundle\Entity\Prestataire;

class LoadPromotionData extends AbstractFixture implements OrderedFixtureInterface {

    private $nb = 3;

    public function load(ObjectManager $manager) {
       $faker = Factory::create();
        for ($i = 0; $i < $this->nb; $i++) {
         
            $promo = new Promotion();
            $promo->setNom($faker->colorName);
            $promo->setDescription($faker->sentence($nbWords = 6, $variableNbWords = false));
            $promo->setPdf('pdf');
            $promo->setDateDebut(new \DateTime());
            $promo->setDateFin(new \DateTime());
            $promo->setAffichageDebut(new \DateTime());
            $promo->setAffichageFin(new \DateTime());
            $promo->setPrestataire($this->getReference('prestataire' . $i));       
            $promo->setCategService($this->getReference('categ' . $i));

            $manager->persist($promo);
          
        }
        $manager->flush();
    }

    public function getOrder() {
        // l'ordre ds lequel les fixtures seront chargées         
        return 14;
    }

}
