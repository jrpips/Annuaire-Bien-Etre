<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker\Factory;
use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\AdresseUtilisateur;

class LoadAdresseUtilisateurData extends AbstractFixture implements OrderedFixtureInterface {

    private $nb = 9;
    private $cp = [];

    public function load(ObjectManager $manager) {
        for ($i = 0; $i < $this->nb; $i++) {

            $cPostal = LoadAdresseUtilisateurData::codePostalLoad(); //          1. tirage au sort d'un code postal
            $localite = LoadAdresseUtilisateurData::provinceLoad($cPostal); //   2. sélection de la province correspondante
            $commune = rand(0, (count($this->cp[$cPostal])) - 1);//              3. et d'une commune

            $addrUser = new AdresseUtilisateur();

            $addrUser->setCodePostal($cPostal);
            $addrUser->setLocalite($localite);
            $addrUser->setCommune($this->cp[$cPostal][$commune]);
            $addrUser->setUtilisateur($this->getReference('user' . $i));

            $manager->persist($addrUser);
        }
        $manager->flush();
    }

    public function __construct() {
        require './web/Outils/Localite/cp.php';
        $this->cp = $codes_postaux;

        return $this;
    }

    static function codePostalLoad() {
        require './web/Outils/Localite/cp.php';

        return array_rand($codes_postaux, 1);
    }

    static function provinceLoad($c) {
        require './web/Outils/Localite/provinces.php';

        return $provinces[floor($c / 1000) - 1];
    }

    public function getOrder() {

        return 20;
    }

}
