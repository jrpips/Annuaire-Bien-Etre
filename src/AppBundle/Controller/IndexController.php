<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;

class IndexController extends Controller {

    /**
     * @Route("/", name="home")
     */
    public function indexAction() {
        $prestataires = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prestataire')->findAll();
        $promos = $this->getDoctrine()->getManager()->getRepository('AppBundle:Promotion')->findAll();
        $stages = $this->getDoctrine()->getManager()->getRepository('AppBundle:Stage')->findAll();
        $services = $this->getDoctrine()->getManager()->getRepository('AppBundle:CategService')->findAll();
        dump($prestataires);
        return $this->render('accueil/index.html.twig', array(
                    'p' => $prestataires,
                    'promos' => $promos,
                    'stages' => $stages,
                    'services' => $services
        ));
    }

    /**
     * @Route("/about",name="about")
     */
    public function aboutAction() {
        
    }

    /**
     * @Route("/contact",name="contact")
     */
    public function contactAction() {
        
    }

    /**
     * @Route("/login",name="login")
     */
    public function loginAction() {
        return $this->render('accueil/login.html.twig');
    }

    /**
     * @Route("/subscribe/user",name="subscribeUser")
     */
    public function subscribeUserAction(Request $request) {
        $user = new Utilisateur();
        $form = $this->createFormBuilder($user, ['action' => $this->generateUrl('subscribeUser')]);

        $form = $form
                ->add('email', TextType::class, array('required' => false))
                ->add('pwd', TextType::class, array('required' => false))
                ->add('adresseRue', TextType::class, array('required' => false))
                ->add('adresseNumero', TextType::class, array('required' => false))
                ->add('Envoyer', SubmitType::class)
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            return $this->redirectToRoute('home');
        }
        return $this->render('accueil/login.html.twig', array(
                    'form' => $form->createView(),
                    'user' => $user
        ));
    }

}
