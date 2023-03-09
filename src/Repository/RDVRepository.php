<?php

namespace App\Repository;

use App\Entity\RDV;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RDV>
 *
 * @method RDV|null find($id, $lockMode = null, $lockVersion = null)
 * @method RDV|null findOneBy(array $criteria, array $orderBy = null)
 * @method RDV[]    findAll()
 * @method RDV[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RDVRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RDV::class);
    }

    public function save(RDV $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RDV $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function findByDate($date,$order,$medecin): array
    {
        if(!isset($date)){
            $date = new \DateTime("2022-11-18");
        }
        if(!isset($order)){
            $order = 'r.duree';
            $ascdesc = "DESC";
        }else{
            $ascdesc = "ASC";
        }
        return $this->createQueryBuilder('a')
            ->select(array('p.nom','s.libelle','r.duree','r.date','r.heure', 'r.id'))
            ->from(RDV::class,'r')
            ->innerjoin('r.patient','p')
            ->innerjoin('r.statut','s')
            ->innerjoin('r.medecin','m')
            #->where('r.date = :date','m.id = :medecin_id')
            #->setParameter('date',$date)
            #->setParameter('medecin_id',$medecin)
            ->orderBy($order,$ascdesc)
            ->getQuery()
            ->getResult();
        
    }

}
