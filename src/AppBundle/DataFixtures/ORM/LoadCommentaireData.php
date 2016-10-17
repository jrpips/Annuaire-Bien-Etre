<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker\Factory;
use AppBundle\Entity\Commentaire;
use AppBundle\Entity\Prestataire;
use AppBundle\Entity\Internaute;

class LoadCommentaireData extends AbstractFixture implements OrderedFixtureInterface {

    private $nb = 3;

    public function load(ObjectManager $manager) {
        $j;
        for ($i = 0; $i < $this->nb; $i++) {
            $faker = Factory::create();
            $commentaire = new Commentaire();
            $commentaire->setTitre($faker->word);
            $commentaire->setCote(4);
            $commentaire->setContenu($faker->sentence($nbWords = 6, $variableNbWords = false));
            $commentaire->setEncodage(new \DateTime());
            
            $commentaire->setInternaute($this->getReference('internaute'.$i));
            $commentaire->setPrestataire($this->getReference('prestataire'.$i));
                 
            $manager->persist($commentaire);

            $this->addReference('commentaire' . $i, $commentaire);
        }
        $manager->flush();
    }

    public function getOrder() {
        // l'ordre ds lequel les fixtures seront chargées         
        return 10;
    }

}
