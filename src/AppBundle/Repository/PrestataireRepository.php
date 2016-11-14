<?php

namespace AppBundle\Repository;

use Doctrine\ORM\Query\ResultSetMapping;

/*
 *  PrestataireRepository
 */

class PrestataireRepository extends \Doctrine\ORM\EntityRepository {

    public function findMyPrestataire($criteria) {

        foreach ($criteria as $k => $v) {
            $nom = $v['nom'] != '' ? '%' . trim($v['nom']) . '%' : '%';
            $commune = $v['commune'] != '' ? trim($v['commune']) : '%';
            $service = $v['service'] != '' ? '%'.trim($v['service']).'%' : '%';
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


    public function getCompleteProfilePrestataire($nom)
    {
        $qb = $this->createQueryBuilder('p')
            ->leftJoin('p.utilisateur', 'u')->addSelect('u')
            ->leftJoin('u.adresseUtilisateur', 'adr')->addSelect('adr')
            ->leftJoin('p.images', 'i')->addSelect('i')
            ->leftJoin('p.categServices', 's')->addSelect('s')
            //->leftJoin('stage.prestataire', 'sp')->addSelect('sp')
            ->leftJoin('p.stages', 'st')->addSelect('st')
            ;

        $qb->where('p.nom=:nom')->setParameter('nom', $nom);

        return $qb->getQuery()->getResult();
    }

    public function findPrestataire($nom) {

        $qb = $this->createQueryBuilder('p')->leftJoin('p.utilisateur', 'u')->addSelect('u');

        $qb->where('p.nom=:nom')->setParameter('nom', $nom);

        return $qb->getQuery()->getResult();
    }

}
