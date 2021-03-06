<?php

namespace AppBundle\Repository;

/**
 * CommentaireRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentaireRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     *  Retourne le nombre de Commentaires publiés
     */
    public function countCommentaires() {

        $qb = $this->createQueryBuilder('c')->select('COUNT(c)');

        return $qb->getQuery()->getSingleScalarResult();
    }
    /**
     *  Retourne les Commentaires avec les liaisons Internaute & Prestataire
     */
    public function getAllCommentaires(){
        $qb = $this->createQueryBuilder('c')
            ->leftJoin('c.internaute', 'i')->addSelect('i')
            ->leftJoin('c.prestataire', 'p')->addSelect('p');

        return $qb->getQuery()->getResult();
    }

}
