<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker\Factory;
use AppBundle\Entity\Image;
use AppBundle\Entity\Prestataire;

class LoadImageData extends AbstractFixture implements OrderedFixtureInterface
{

    private $nb = 19;

    public function load(ObjectManager $manager)
    {

        //$j = 0;
        $faker = Factory::create('fr_BE');

        for ($i = 0; $i < $this->nb; $i++) {

            $img = new Image();

            $img->setPath($faker->imageUrl());
            if ($i < 10) {

                //$img->setCover($this->getReference('prestataire' . $j));
                if ($i % 2 !== 0) {
                    $img->setPath('prestataire.png');
                    //$j++;
                } /*else {
                    $img->setType('cover');
                }*/
            }
            $img->setName('img' . $i);
            if ($i > 9 && $i < 13) {
                $img->setPath('user.png');

            }
            if ($i > 13) {
                //$img->setType('service');
            }
            if ($i == 13) {
                $img->setPath('admin.png');
            }
            $manager->persist($img);

            $this->addReference('img' . $i, $img);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        // l'ordre ds lequel les fixtures seront chargées         
        return 5;
    }

}
