<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker\Factory;
use AppBundle\Entity\Prestataire;
use AppBundle\Entity\Image;
use AppBundle\Entity\Utilisateur;

class LoadPrestataireData extends AbstractFixture implements OrderedFixtureInterface {

    private $nb = 5;

    public function load(ObjectManager $manager) {
        $faker = Factory::create('fr_BE');
        for ($i = 0; $i < $this->nb; $i++) {

            $prestataire = new Prestataire();
            $prestataire->setNom($faker->company);
            $prestataire->setSiteInternet($faker->domainName);
         
            $prestataire->setTelephone($faker->phoneNumber);
            $prestataire->setTva($faker->ean8);

            $manager->persist($prestataire);

            $this->addReference('prestataire' . $i, $prestataire);
        }
        $manager->flush();
    }

    public function getOrder() {
          
        return 5;
    }

}
