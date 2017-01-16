<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * InternauteRepository
 *
 */
class InternauteRepository extends \Doctrine\ORM\EntityRepository
{

    public function findInternaute($id)
    {//recherche Internaute via son Id

        $qb = $this->createQueryBuilder('i')->leftJoin('i.utilisateur', 'u')->addSelect('u');

        $qb->where('i.id=:id')->setParameter('id', $id);

        return $qb->getQuery()->getResult();
    }

    public function getMyInternaute($fk)
    {//recherche Internaute via son FK utilisateur

        $qb = $this->createQueryBuilder('i')->leftJoin('i.utilisateur', 'u')->addSelect('u');

        $qb->andWhere('i.utilisateur=:id')->setParameter('id', $fk);

        return $qb->getQuery()->getResult();
    }

    public function getPrestatairesFavoris($id)
    {//recherche les Prestataires Favoris d'un Internaute

        $qb = $this->createQueryBuilder('i')
            ->leftJoin('i.favoris', 'f')->addSelect('f')
            //->leftJoin('i.image', 'ii')->addSelect('ii')
            ->leftJoin('i.utilisateur', 'u')->addSelect('u')
            ->leftJoin('u.prestataire', 'up')->addSelect('up');

        $qb->where('i.id = :internaute_id')->setParameter('internaute_id', $id);

        return $qb->getQuery()->getResult();
    }

    public function countInternautes($newsletter = null)
    {//compte le nombre d'Internautes inscrits et/où inscrits à la newsletter

        $qb = $this->createQueryBuilder('i')->select('COUNT(i)');
        if ($newsletter) {
            $qb->andWhere('i.newsletter =:bool')->setParameter('bool', true);
        }
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getAllInternautes()
    {//retourne liste des Internautes

        $qb = $this->createQueryBuilder('i')
            ->leftJoin('i.utilisateur', 'u')->addSelect('u');
        return $qb->getQuery()->getResult();
    }

    public function findUtilisateurs()
    {
        $qb = $this->createQueryBuilder('i')->leftJoin('i.utilisateur', 'u')->addSelect('u');
        /* $qb=$this->createQueryBuilder('u')
             ->from('AppBundle:Utilisateur','i')
             ->where('i.id = ?6')
            ;*/
        return $qb->getQuery()->getResult();
    }
}
