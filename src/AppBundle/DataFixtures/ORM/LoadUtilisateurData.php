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

        $listRoles = array('ROLE_ADMIN', 'ROLE_INTERNAUTE', 'ROLE_PRESTATAIRE');

        for ($i = 0; $i < $this->nb; $i++) {
            $faker = Factory::create('fr_BE');
            $user = new Utilisateur();
            $user->setEmail($faker->email);

            $user->setPassword('1234');
            $user->setUsername($faker->firstName($gender = null | 'male' | 'female'));          
            $user->setSalt('');

            $user->setAdresseNumero($faker->buildingNumber);
            $user->setAdresseRue($faker->streetName);
            $user->setInscription(new \DateTime());

            $user->setEssaiPwd(0);
            $user->setBanni(false);
            $user->setInscriptionConf(true);
            if ($i < 5) {
                $user->setPrestataire($this->getReference('prestataire' . $i));
                $user->setRoles(array($listRoles[2]));
            }
            if ($i > 4 && $i < 8) {
                $j = $i - 5;
                $user->setInternaute($this->getReference('internaute' . $j));
                $user->setRoles(array($listRoles[1]));
            }
            else{
                $user->setRoles(array($listRoles[0]));
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
