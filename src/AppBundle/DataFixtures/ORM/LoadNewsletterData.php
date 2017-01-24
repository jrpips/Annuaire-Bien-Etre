<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker\Factory;

use AppBundle\Entity\Newsletter;

class LoadNewsletterData extends AbstractFixture implements OrderedFixtureInterface
{

    private $nb = 1;


    public function load(ObjectManager $manager)
    {

        //for ($i = 0; $i < $this->nb; $i++) {

        $news = new Newsletter();
        $news->setTitre('Newsletter 1');
        $news->setContenu('PDF content - Annuaire Bien-être');
        $news->setPath('01-2017/490fba976d59e3b767824eac8549d7a7a36a37f2.pdf');
        $news->setPublication(new \DateTime('2017-01-24'));

        $manager->persist($news);

        //$this->addReference('news' . $i, $news);
        // }
        $manager->flush();
    }

    public function getOrder()
    {

        return 70;
    }

}
