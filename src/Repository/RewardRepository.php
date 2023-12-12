<?php

namespace App\Repository;

use App\Entity\Reward;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reward>
 *
 * @method Reward|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reward|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reward[]    findAll()
 * @method Reward[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RewardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reward::class);
    }

    public function add(Reward $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Reward $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }





    public function findReward($userId)
    {

        $qb = $this->createQueryBuilder('u');

        $qb->select('count(r.id)')
            ->
            ->where()
            ->setParameter()
            ->orderBy();

        return $qb->getQuery()->getResult();
    }

    // 1 je recupére toutes les recompenses
    
    // 2 je boucle sur les rewards et les compares avec celle de la table user_reward


    // ou 

    // je regarde tout les reward_id associé à l'user_id dans la table user_reward
    // si un reward_id n'est pas associée à l'user le select .

    //!essaie avec dql
    public function findReward2($userId)
    {
          
        $em = $this->getEntityManager();
        
        $query = $em->createQuery(
            
            'SELECT count(reward.id) 
            FROM App\Entity\User AS u
            INNER JOIN u.id AS u
            INNER jOIN r.id AS r
            WHERE c.movie = :movie
            ORDER BY c.creditOrder ASC'
        )->setParameter('movie', $movie); // Ici je défini le parametre movie en disant qu'il est egale a $movie

        return $query->getResult();
    }

    //    /**
    //     * @return Reward[] Returns an array of Reward objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Reward
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
