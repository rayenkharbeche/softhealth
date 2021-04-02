<?php

namespace App\Repository;

use App\Entity\Patient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Patient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Patient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Patient[]    findAll()
 * @method Patient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Patient::class);
    }
 /**
  * Requete QueryBuilder
  */
   public function trieCIN(){
        return $this->createQueryBuilder('p')
            ->orderBy('p.cin','ASC')
            ->getQuery()
            ->getResult();
    }


    public function RechercheC($patientC)
    {
        return $this->createQueryBuilder('u')
            ->where('u.patientC LIKE :patientC')
            ->setParameter('patientC',"%".patientC."%" )
            ->getQuery()->execute();
    }

    public function trieEmail(){
        return $this->createQueryBuilder('p')
            ->orderBy('p.email','ASC')
            ->getQuery()
            ->getResult();
    }


    public function RechercheE($patientM)
    {
        return $this->createQueryBuilder('u')
            ->where('u.patientM LIKE :patientM')
            ->setParameter('patientM',"%".patientM."%" )
            ->getQuery()->execute();
    }


    // /**
    //  * @return Patient[] Returns an array of Patient objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Patient
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    } */
}
