<?php

namespace AppBundle\Repository;

use Doctrine\ORM\Query\ResultSetMapping;

/*
 *  PrestataireRepository
 */

class PrestataireRepository extends \Doctrine\ORM\EntityRepository {

    public function findPrestataire($nom) {

        $qb = $this->createQueryBuilder('p')->leftJoin('p.utilisateur', 'u')->addSelect('u');

        $qb->where('p.nom=:nom')->setParameter('nom', $nom);

        return $qb->getQuery()->getResult();
    }

    public function findMyPrestataire($criteria) {

        foreach ($criteria as $k => $v) {
            $nom = $v['nom'] != '' ? '%' . trim($v['nom']) . '%' : '%';
            $commune = $v['commune'] != '' ? trim($v['commune']) : '%';
            $service = $v['service'] != '' ? trim($v['service']) : '%';
        }

        $qb = $this->createQueryBuilder('p')
                        ->innerJoin('p.utilisateur', 'u')->addSelect('u')
                        ->innerJoin('p.images', 'i')->addSelect('i')
                        ->innerJoin('p.categServices', 's')->addSelect('s')
                        ->innerJoin('u.adresseUtilisateur', 'adr')->addSelect('adr');

        $qb->where("p.nom like :nom")
                ->andWhere("adr.commune like :commune")
                ->andWhere("s.nom like :service");

        $qb->setParameters(array(
            'nom' => $nom,
            'commune' => $commune,
            'service' => $service
        ));

        return $qb->getQuery()->getResult();
    }

}
