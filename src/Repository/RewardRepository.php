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

    /**
     *  $sql='Select r.id
     *        From reward r
     *        Left Join user_reward ur ON r.id = ur.reward_id AND  :userId = ur.user_id 
     *        
     * 
     */



    public function findReward($userId)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
             SELECT r.* FROM reward r
             LEFT JOIN user_reward ur ON r.id = ur.reward_id AND ur.user_id = :userId
             WHERE ur.user_id IS NULL
             ORDER BY RAND()
             LIMIT 1
         ';

        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery(['userId' => $userId])->fetchAssociative() ?: null;

        if ($result) {
            $rewardId = $result['id'];
            $reward = $this->find($rewardId);

            return $reward;
        }
        return null;
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
