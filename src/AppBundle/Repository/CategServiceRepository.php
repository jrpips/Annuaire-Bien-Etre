<?php

namespace AppBundle\Repository;

/**
 * CategServiceRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategServiceRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     *   Sélection des services validés par l'admin Bien-Etre
     **/
    public function myFindValideServices($bool=true)
    {
        $qb = $this->createQueryBuilder('cs')
            ->andWhere('cs.valide like :boolean')
            ->setParameter('boolean', $bool);

        return $qb->getQuery()->getResult();
    }

    /**
     *   Sélection des Services proposés par le Prestataire reçu en paramêtre
     **/
    public function findServicesByNomPrestataire($nom)
    {
        $qb = $this->createQueryBuilder('cs')
            ->leftJoin('cs.prestataires', 'p')->addSelect('p')
            ->andWhere("p.nom like :nom")
            ->setParameter('nom', $nom);

        return $qb->getQuery()->getResult();
    }

    /**
     *   Sélection des Services non-proposés par le Prestataire reçu en paramêtre
     **/
    public function findNotServicesByNomPrestataire($nom)
    {
        $qb = $this->createQueryBuilder('cs')
            ->leftJoin('cs.prestataires', 'p')->addSelect('p')
            ->andWhere("p.nom not like :nom")
            ->setParameter('nom', $nom);

        return $qb->getQuery()->getResult();
    }

    /**
     *  Sélection des demandes de nouveaux servives
     */
    public function findNewService()
    {

    }

    /**
     *  Retourne le nombre de Commentaires publiés
     */
    public function countServices()
    {
        $qb = $this->createQueryBuilder('cs')->select('COUNT(cs)')->andWhere('cs.valide like :bool')->setParameter('bool', false);
        return $qb->getQuery()->getSingleScalarResult();
    }

}
