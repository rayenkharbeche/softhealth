<?php

namespace App\Repository;

use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Users|null find($id, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Users::class);
    }
    /**
     * Requete QueryBuilder
     */

    public function Recherche($userM)
    {
          return $this->createQueryBuilder('u')
          ->where('u.userM LIKE :userM')
          ->setParameter('userM',"%".userM."%" )
              ->getQuery()->execute();
    }

    public function ListeUparMail()
    {
        return $this->createQueryBuilder('x')
        ->orderBy('x.email' , 'ASC')
        ->getQuery()
        ->getResult();
    }
    public function trie(){
        return $this->createQueryBuilder('u')->orderBy('u.cin','ASC')->getQuery()
            ->getResult();
    }
    public function trieN(){
        return $this->createQueryBuilder('u')
        ->orderBy('u.username','ASC')
        ->getQuery()
        ->getResult();
    }
    public function rechercheC($userN)
    {
        return $this->createQueryBuilder('u')
            ->where('u.cin LIKE :cin')
            ->setParameter('cin',"%".userN."%")
            ->getQuery() ->execute();
    }
    public function rechercheN($nom)
    {
        return $this->createQueryBuilder('u')
            ->where('u.nom LIKE :nom')
            ->setParameter('nom',"%".$nom."%")
            ->getQuery() ->execute();
    }

    

   


    // /**
    //  * @return Users[] Returns an array of Users objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Users
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
