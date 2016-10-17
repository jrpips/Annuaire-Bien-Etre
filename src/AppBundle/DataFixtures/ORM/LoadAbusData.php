<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker\Factory;
use AppBundle\Entity\Abus;
use AppBundle\Entity\Commentaire;
use AppBundle\Entity\Internaute;

class LoadAbusData extends AbstractFixture implements OrderedFixtureInterface {

    public function load(ObjectManager $manager) {

        $faker = Factory::create();
        $abus = new Abus();
               
        $abus->setDescription($faker->sentence($nbWords = 6, $variableNbWords = false));
        $abus->setEncodage(new \DateTime());

        $abus->setInternaute($this->getReference('internaute1'));
        $abus->setCommentaire($this->getReference('commentaire0'));

        $manager->persist($abus);

        $manager->flush();
    }

    public function getOrder() {
        // l'ordre ds lequel les fixtures seront chargées         
        return 11;
    }

}
