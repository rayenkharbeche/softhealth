<?php

namespace App\Repository;

use App\Entity\Consultation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Consultation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Consultation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Consultation[]    findAll()
 * @method Consultation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConsultationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Consultation::class);
    }

    /**
     * Requete QueryBuilder
     */
    public function trieDate(){
        return $this->createQueryBuilder('c')
            ->orderBy('c.dateC','ASC')
            ->getQuery()
            ->getResult();
    }


    public function RechercheC($consultationD)
    {
        return $this->createQueryBuilder('u')
            ->where('u.consultationD LIKE :consultationD' )
            ->setParameter('consultationD',"%".consultationD."%" )
            ->getQuery()->execute();
    }

    public function trieNum(){
        return $this->createQueryBuilder('c')
            ->orderBy('c.numC','ASC')
            ->getQuery()
            ->getResult();
    }


    public function RechercheN($consultationN)
    {
        return $this->createQueryBuilder('u')
            ->where('u.consultationN LIKE :consultationN' )
            ->setParameter('consultationN',"%".consultationN."%" )
            ->getQuery()->execute();
    }
    // /**
    //  * @return Consultation[] Returns an array of Consultation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Consultation
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
