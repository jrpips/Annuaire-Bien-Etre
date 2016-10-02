<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker\Factory;
use AppBundle\Entity\Image;
use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\Internaute;

class LoadInternauteData extends AbstractFixture implements OrderedFixtureInterface {

    private $nb = 3;

    public function load(ObjectManager $manager) {
        $j;
        for ($i = 0; $i < $this->nb; $i++) {
            $faker = Factory::create('fr_BE');
            $internaute = new Internaute();
            $internaute->setNom($faker->name);
            $internaute->setPrenom($faker->firstName($gender = null | 'male' | 'female'));
            $internaute->setNewsletter(true);
            $j = $i + 5;
            $internaute->setUtilisateur($this->getReference('user' . $j));
            $j = $i + 10;
            $internaute->setImage($this->getReference('img' . $j));
            $random = rand(2, 4);
            for ($k = 0; $k < $random; $k++) {
               
                $internaute->addPrestataire($this->getReference('prestataire' . $k));
            }
            $manager->persist($internaute);

            $this->addReference('internaute' . $i, $internaute);
        }
        $manager->flush();
    }

    public function getOrder() {
        // l'ordre ds lequel les fixtures seront chargées         
        return 8;
    }

}
