<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function add(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }



    // public function findHomeArticle($saviezVous)
    // {
    //     //  which retrieves article " Le saviez vous ? " from article table in database 
    //     return $this->createQueryBuilder('a')
    //         ->where('a.tag = :saviezvous')
    //         ->setParameter('saviezvous', $saviezVous)
    //         ->getQuery()
    //         ->getResult();
    // }

    public function findRandomArticles()
    {
        // Méthod which retrieves 2 random articles from database
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT article.*, 
        category.title AS category_title, 
        category.slug AS category_slug
        FROM article
        LEFT JOIN category ON article.category_id = category.id
        ORDER BY RAND()
        LIMIT 3;
    ';

        $stmt = $conn->executeQuery($sql);
        $ids = $stmt->fetchAllAssociative();

        $articleRepository = $this->getEntityManager()->getRepository(Article::class);
        $articles = [];

        foreach ($ids as $id) {
        $article = $articleRepository->find($id['id']);
        if ($article) {
            $articles[] = $article;
        }
    }

    return $articles;
    }

    // Méthode pour la recherche d'articles :
    public function searchArticle(?string $keyword)
    {
        // Gérer les espaces :
        $keyword = trim($keyword);

        return $this->createQueryBuilder('a')
            ->where('LOWER(a.title) LIKE :keyword')
            ->setParameter('keyword', '%' . strtolower($keyword) . '%')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Article[] Returns an array of Article objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Article
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
