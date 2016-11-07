<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker\Factory;
use AppBundle\Entity\Image;
use AppBundle\Entity\Prestataire;

class LoadImageData extends AbstractFixture implements OrderedFixtureInterface {

    private $nb = 19;

    public function load(ObjectManager $manager) {
        
        $j = 0;
        $faker = Factory::create('fr_BE');
        
        for ($i = 0; $i < $this->nb; $i++) {

            $img = new Image();
            $img->setOrdre($i);
            $img->setUrl($faker->imageUrl(40, 40, 'business'));
            if ($i < 10) {
                $img->setPrestataire($this->getReference('prestataire' . $j));
                if ($i % 2 !== 0) {
                    $j++;
                }
            }
            $img->setName($faker->firstName($gender = null | 'male' | 'female'));
            $manager->persist($img);

            $this->addReference('img' . $i, $img);
        }
        $manager->flush();
    }

    public function getOrder() {
        // l'ordre ds lequel les fixtures seront chargées         
        return 6;
    }

}
