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
        foreach ($mot_cle as $k => $v) {
            $mot = '%' . $v['nom'] . '%';
        }

        $qb = $this->createQueryBuilder('p')
            ->leftJoin('p.utilisateur', 'u')->addSelect('u')
            ->leftJoin('p.stages', 'st')->addSelect('st')
            ->leftJoin('p.categServices', 's')->addSelect('s')
            ->leftJoin('p.promotions', 'pr')->addSelect('pr')
            ->leftJoin('u.adresseUtilisateur', 'adr')->addSelect('adr');

        $qb->orWhere("p.nom like :mot")
            ->orWhere("adr.commune like :mot")
            ->orWhere("adr.localite like :mot")
            ->orWhere("pr.nom like :mot")
            ->orWhere("s.nom like :mot")
            ->orWhere("st.nom like :mot")
            ->orWhere("s.nom like :mot");

        $qb->setParameter('mot', $mot);

        return $qb->getQuery()->getResult();

    }

    /**
     *   Sélection de Prestataire(s) via les arguments du moteur de recherche
     **/
    public function advancedSearchPrestataire($criteria)
    {

        foreach ($criteria as $k => $v) {
            $nom = $v['nom'] != '' ? '%' . trim($v['nom']) . '%' : '%';
            $commune = $v['commune'] != '' ? trim($v['commune']) : '%';
            $service = $v['service'] != '' ? '%' . trim($v['service']) . '%' : '%';
        }
        //$nom=$criteria['nom'];$commune=$criteria['commune'];$service=$criteria['service'];
        //echo $nom;
        $qb = $this->createQueryBuilder('p')
            ->leftJoin('p.utilisateur', 'u')->addSelect('u')
            ->leftJoin('p.images', 'i')->addSelect('i')
            ->leftJoin('p.categServices', 's')->addSelect('s')
            ->leftJoin('u.adresseUtilisateur', 'adr')->addSelect('adr');

        $qb->andWhere("p.nom like :nom")
            ->andWhere("adr.commune like :commune")
            ->andWhere("s.nom like :service");

        $qb->setParameters(array(
            'nom' => $nom,
            'commune' => $commune,
            'service' => $service
        ));

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
            ->leftJoin('p.images', 'i')->addSelect('i')
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
    public function findLastPrestataires($first=0,$nb=5)
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
    public function countPrestataires() {

        $qb = $this->createQueryBuilder('p')->select('COUNT(p)');

        return $qb->getQuery()->getSingleScalarResult();
    }
}
