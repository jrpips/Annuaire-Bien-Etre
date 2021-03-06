<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker\Factory;
use AppBundle\Entity\Utilisateur;

class LoadUtilisateurData extends AbstractFixture implements OrderedFixtureInterface {

    private $nb = 9;

    public function load(ObjectManager $manager) {

        //$listRoles = array('ROLE_ADMIN', 'ROLE_INTERNAUTE', 'ROLE_PRESTATAIRE');
        
        $faker = Factory::create('fr_BE');
                    
        for ($i = 0; $i < $this->nb; $i++) {

            $user = new Utilisateur();
            $user->setEmail($faker->email);

            $user->setPassword('$2y$12$AkpYQZ7Vyjd.ZyL1qFJI6uOzsXDc8zpx0v4E4BH2Cp66ovO4BM4H.');//plaintext password = 1234
            $user->setUsername('user'.$i);
            $user->setSalt('');

            $user->setAdresseNumero($faker->buildingNumber);
            $user->setAdresseRue($faker->streetName);
            $user->setInscription(new \DateTime());

            $user->setEssaiPwd(0);
            $user->setBanni(false);
            $user->setInscriptionConf(true);
            $this->addReference('utilisateur' . $i, $user);
            if ($i < 5) {
                $user->setPrestataire($this->getReference('prestataire' . $i));
                $user->setRoles('ROLE_PRESTATAIRE');
            } else {
                switch ($i) {
                    case 8: $user->setRoles('ROLE_ADMIN');
                        break;
                    default:
                        $j = $i - 5;
                        $user->setInternaute($this->getReference('internaute' . $j));
                        $user->setRoles('ROLE_INTERNAUTE');
                }
            }
            $user->setAdresseUtilisateur($this->getReference('addrUser' . $i));
            $manager->persist($user);

            $this->addReference('user' . $i, $user);
        }
        $manager->flush();
    }

    public function getOrder() {
        // l'ordre ds lequel les fixtures seront chargées         
        return 9;
    }

}
