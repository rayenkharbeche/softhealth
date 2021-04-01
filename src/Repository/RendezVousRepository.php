<?php

namespace App\Repository;

use App\Entity\Planning;
use App\Entity\RendezVous;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RendezVous|null find($id, $lockMode = null, $lockVersion = null)
 * @method RendezVous|null findOneBy(array $criteria, array $orderBy = null)
 * @method RendezVous[]    findAll()
 * @method RendezVous[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RendezVousRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RendezVous::class);
    }

    // /**
    //  * @return RendezVous[] Returns an array of RendezVous objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RendezVous
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * Requete QueryBuilder
     */

    public function Recherche($dateRDV)
    {
        return $this->createQueryBuilder('s')
            ->where('s.dateRDV LIKE :dateRDV')
            ->setParameter('dateRDV', '%'.$dateRDV.'%')
            ->getQuery()
            ->execute()
            ;
    }

    public function ListRendezVousOrderByDATE()
    {
        return $this->createQueryBuilder('x')
            ->orderBy('x.dateRDV','ASC')
            ->getQuery()
            ->getResult();
    }

    public function SearchName($nomRDV)
    {
        return $this->createQueryBuilder('s')
            ->where('s.nomRDV LIKE :nomRDV')
            ->setParameter('nomRDV', '%'.$nomRDV.'%')
            ->getQuery()
            ->execute()
            ;
    }

    public function FindByUSER($id){
        return $this->createQueryBuilder('s')
            ->join('s.user', 'u')
            ->join('u.plannings', 'p')
            ->addSelect('u')
            ->where('u.id=:id AND p.personnel=:id')
            ->setParameter('id',$id)
            ->addSelect('p')
            ->getQuery()
            ->getResult();

    }

    /**
     * @param $id
     * @return array
     */
    public function findPlannigsByUser($id): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Planning p
           INNER JOIN App\Entity\User u WITH p.personnel = u.id
           INNER JOIN App\Entity\RendezVous r WITH u.id = r.user
            WHERE u.id = :id'
        )->setParameter( 'id', $id );

//      returns an array of Produit objects
        return $query->getResult();
    }
    
    public function findRenders($email): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT r
            FROM App\Entity\RendezVous r
           INNER JOIN App\Entity\Users u WITH r.user = u.id 
            WHERE u.email = :email'
        )->setParameter( 'email', $email );

//      returns an array of Produit objects
        return $query->getResult();
    }

}
