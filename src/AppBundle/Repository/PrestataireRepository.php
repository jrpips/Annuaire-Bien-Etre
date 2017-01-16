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
            $mot = '%' . $mot_cle/*['moteur_de_recherche']*/['nom'] . '%';
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
        $nom = $criteria['nom'] != '' ? '%' . trim($criteria['nom']) . '%' :false;
        $commune = $criteria['commune'] != '' ? trim($criteria['commune']) :false;
        $service = $criteria['service'] != '' ? trim($criteria['service']) :false;
        $cp = $criteria['cp'] != '' ?  trim($criteria['cp'])  :false;
        $localite = $criteria['localite'] != '' ?  trim($criteria['localite'])  :false;

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
    /**
     *  Récupération des images slider d'un Prestataire donné
     */
    public function findImagesSlider($idPrestataire){
        $qb = $this->createQueryBuilder('p')->leftJoin('p.slider', 'ps')->addSelect('ps');

        $qb->andWhere('ps.sliderItems=:id')->setParameter('id', $idPrestataire);

        return $qb->getQuery()->getResult();
    }
}
