<?php

namespace App\Repository;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Question>
 *
 * @method Question|null find($id, $lockMode = null, $lockVersion = null)
 * @method Question|null findOneBy(array $criteria, array $orderBy = null)
 * @method Question[]    findAll()
 * @method Question[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    public function add(Question $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Question $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findRandomQuestionByQuiz($quizId, $limit = 10)
    {
        $entityManager = $this->getEntityManager();

        // Step 1: Retrieve all question IDs for the specified quiz
        $ids = $entityManager->createQuery(
            'SELECT q.id FROM App\Entity\Question q 
         JOIN q.quizzes quiz
         WHERE quiz.id = :quizId'
        )->setParameter('quizId', $quizId)
            ->getResult();

        // Step 2: Shuffle and limit the IDs
        $ids = array_column($ids, 'id');
        shuffle($ids);
        $ids = array_slice($ids, 0, $limit);

        // Step 3: Load the questions and their corresponding responses
        return $entityManager->createQuery(
            'SELECT q, r FROM App\Entity\Question q
         LEFT JOIN q.responses r
         WHERE q.id IN (:ids)'
        )->setParameter('ids', $ids)
            ->getResult();
    }





    //    /**
    //     * @return Question[] Returns an array of Question objects
    //     */
    //    public function findByExampleField($value): array
    //    {

    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('q.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Question
    //    {
    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
