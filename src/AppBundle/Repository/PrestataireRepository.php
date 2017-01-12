<?php

namespace AppBundle\Repository;

use Doctrine\ORM\Query\ResultSetMapping;

/*
 *  PrestataireRepository
 */

class PrestataireRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     *   Recherche de Prestataire(s) via un mot clé (où partie)
     **/
    public function simpleSearchPrestataire($mot_cle)
    {
        //foreach ($mot_cle as $k => $v) {
            $mot = '%' . $mot_cle['moteur_de_recherche']['nom'] . '%';
        //}

        $qb = $this->createQueryBuilder('p')
            ->leftJoin('p.utilisateur', 'u')->addSelect('u')
            ->leftJoin('p.stages', 'st')->addSelect('st')
            ->leftJoin('p.categServices', 's')->addSelect('s')
            ->leftJoin('p.promotions', 'pr')->addSelect('pr')
            ->leftJoin('u.adresseUtilisateur', 'adr')->addSelect('adr');

        $qb->orWhere("p.nom like :mot")/* ->orWhere("adr.commune like :mot")
            ->orWhere("adr.localite like :mot")
            ->orWhere("pr.nom like :mot")
            ->orWhere("s.nom like :mot")
            ->orWhere("st.nom like :mot")
            ->orWhere("s.nom like :mot")*/
        ;

        $qb->setParameter('mot', $mot);

        return $qb->getQuery()->getResult();

    }

    /**
     *   Sélection de Prestataire(s) via les arguments du moteur de recherche
     **/
    public function advancedSearchPrestataire($criteria)
    {
        //boucle Foreach PAS INUTILE au vu de la structure de $criteria ;)
        $nom = $criteria['moteur_de_recherche']['nom'] != '' ? '%' . trim($criteria['moteur_de_recherche']['nom']) . '%' :false;
        $commune = $criteria['moteur_de_recherche']['commune'] != '' ? trim($criteria['moteur_de_recherche']['commune']) :false;
        $service = $criteria['moteur_de_recherche']['service'] != '' ? trim($criteria['moteur_de_recherche']['service']) :false;
        $cp = $criteria['moteur_de_recherche']['cp'] != '' ?  trim($criteria['moteur_de_recherche']['cp'])  :false;
        $localite = $criteria['moteur_de_recherche']['localite'] != '' ?  trim($criteria['moteur_de_recherche']['localite'])  :false;

        $qb = $this->createQueryBuilder('p')
            ->leftJoin('p.utilisateur', 'u')->addSelect('u')
            ->leftJoin('p.logo', 'l')->addSelect('l')
            ->leftJoin('p.cover', 'c')->addSelect('c')
            ->leftJoin('p.categServices', 's')->addSelect('s')
            ->leftJoin('u.adresseUtilisateur', 'adr')->addSelect('adr')
        ;

        if ($nom) {
            $qb->andWhere("p.nom like :nom")->setParameter('nom', $nom);
        }
        if ($commune) {
            $qb->andWhere("adr.commune like :commune")->setParameter('commune', $commune);
        }
        if ($service) {
            $qb->andWhere("s.nom like :service")->setParameter('service', $service);
        }
        if ($cp) {
            $qb->andWhere("adr.codePostal like :cp")->setParameter('cp', $cp);
        }
        if ($localite) {
            $qb->andWhere("adr.localite like :localite")->setParameter('localite', $localite);
        }
        return $qb->getQuery()->getResult();
    }

    /**
     *   Sélection d'un Prestataire avec son nom en param
     **/
    public function getCompleteProfilePrestataire($nom)
    {
        $qb = $this->createQueryBuilder('p')
            ->leftJoin('p.utilisateur', 'u')->addSelect('u')
            ->leftJoin('u.adresseUtilisateur', 'adr')->addSelect('adr')
            ->leftJoin('p.logo', 'l')->addSelect('l')
            ->leftJoin('p.cover', 'c')->addSelect('c')
            ->leftJoin('p.categServices', 's')->addSelect('s')
            ->leftJoin('p.promotions', 'pr')->addSelect('pr')
            ->leftJoin('p.stages', 'st')->addSelect('st');

        $prestataire = $qb->where('p.nom=:nom')->setParameter('nom', $nom)->getQuery()->getResult();

        return $prestataire[0];
    }

    public function findPrestataire($nom)
    {
        $qb = $this->createQueryBuilder('p')->leftJoin('p.utilisateur', 'u')->addSelect('u');
        $qb->where('p.nom=:nom')->setParameter('nom', $nom);

        return $qb->getQuery()->getResult();
    }

    /**
     *   Sélection des Prestataires proposant le Service reçu en paramêtre
     **/
    public function findPrestatairesByService($service)
    {
        $qb = $this->createQueryBuilder('p')
            ->leftJoin('p.categServices', 'cs')->addSelect('cs')
            ->andWhere("cs.nom like :service")
            ->setParameter('service', $service);

        return $qb->getQuery()->getResult();
    }

    /**
     *   Sélection des x derniers Prestataires inscrits
     **/
    public function findLastPrestataires($first = 0, $nb = 5)
    {
        $qb = $this->createQueryBuilder('p')
            ->leftJoin('p.utilisateur', 'u')->addSelect('u')
            ->orderBy('u.inscription', 'DESC')
            ->setFirstResult($first)//offset
            ->setMaxResults($nb);//limit

        return $qb->getQuery()->getResult();
    }

    /**
     *   Sélection des Prestataires favoris d'un Internaute donné
     **/
    public function findPrestatairesFavoris($internaute)
    {
        $qb = $this->createQueryBuilder('p')
            ->leftJoin('p.utilisateur', 'u')
            ->leftJoin('p.abonnes', 'pa')
            ->andWhere('pa.nom like :internaute')
            ->setParameter('internaute', $internaute);

        return $qb->getQuery()->getResult();

    }

    /**
     *  Retourne le nombre de Prestataires inscrits
     */
    public function countPrestataires()
    {
        $qb = $this->createQueryBuilder('p')->select('COUNT(p)');

        return $qb->getQuery()->getSingleScalarResult();
    }
}
