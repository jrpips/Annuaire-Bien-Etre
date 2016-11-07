<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Warrior;
use AppBundle\Entity\Personnage;
use AppBundle\Entity\Magicien;
use AppBundle\Form\PersonnageType;
use AppBundle\Form\WarriorType;
use AppBundle\Form\MagicienType;

class RPGController extends Controller {

    /**
     * @Route("/warrior", name="warrior")
     */
    public function warriorAction(Request $request) {
        $warrior = new Personnage();
        $form = $this->get('form.factory')->create(PersonnageType::class, $warrior)->add('magicien', MagicienType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                dump($warrior);
                $em = $this->getDoctrine()->getManager();
                $em->persist($warrior);

                $em->flush();

                return $this->redirectToRoute('warrior');
            }
        }
        return $this->render('form.personnage.html.twig', array(
                    'form' => $form->createView(),
                    'warrior' => $warrior
        ));
    }

    /**
     * @Route("/magicien",name="magicien")
     */
    public function magicienAction(Request $request) {
        $magicien = new Personnage();
        $form = $this->get('form.factory')->create(PersonnageType::class, $magicien)->add('warrior', WarriorType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                dump($magicien);
                $em = $this->getDoctrine()->getManager();
                $em->persist($magicien);

                $em->flush();

                return $this->redirectToRoute('magicien');
            }
        }
        return $this->render('form.personnage.html.twig', array(
                    'form' => $form->createView(),
                    'magicien' => $magicien
        ));
    }

}
