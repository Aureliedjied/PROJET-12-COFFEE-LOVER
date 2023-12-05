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

    public function findRandomQuestionByQuiz($quiz, $limit = 10)
    {
        $conn = $this->getEntityManager()->getConnection();

        // récupère les films, range dans le désordre et retournes en qu'un
        $sql = '
         SELECT *, quiz.title AS,quiz_title FROM question 
         JOIN quiz_question ON question.id = quiz_question.question_id 
         JOIN quiz ON quiz_question.quiz_id = quiz.id
         WHERE quiz_question.quiz_id = :quiz
         ORDER BY RAND ( )
         LIMIT :limit
             ';


        $stmt = $conn->prepare($sql);
        $stmt->bindValue('quiz', $quiz);
        $stmt->bindValue('limit', $limit, \PDO::PARAM_INT);

        $resultSet = $stmt->executeQuery();

        // returns the result
        return $resultSet->fetchAllAssociative();
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
