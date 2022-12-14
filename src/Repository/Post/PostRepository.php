<?php

namespace App\Repository\Post;

use App\Entity\Post\Tag;
use App\Entity\Post\Post;
use App\Model\SearchData;
use App\Entity\Post\Category;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Post>
 *
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginatorInterface)
    {
        parent::__construct($registry, Post::class);
    }

    // Get published posts
    public function findPublished(int $page, ?Category $category = null, ?Tag $tag = null): PaginationInterface
    {
        $data = $this->createQueryBuilder('p')
            ->where('p.state LIKE :state')
            ->setParameter('state', '%STATE_PUBLISHED%')
            ->addOrderBy('p.createdAt', 'DESC');

        if (isset($category)) {
            $data = $data
                ->join('p.categories', 'c')
                ->andWhere(':category IN (c)')
                ->setParameter('category', $category);
        }

        if (isset($tag)) {
            $data = $data
                ->join('p.tags', 't')
                ->andWhere(':tag IN (t)')
                ->setParameter('tag', $tag);
        }

        $data->getQuery()
            ->getResult();

        // Pagination
        $posts = $this->paginatorInterface->paginate(
            $data,
            $page,
            9
        );

        return $posts;
    }

    public function findBySearch(SearchData $searchData): PaginationInterface
    {
        $data = $this->createQueryBuilder('p')
            ->where('p.state LIKE :state')
            ->setParameter('state', '%STATE_PUBLISHED%')
            ->addOrderBy('p.createdAt', 'DESC');

         // Search on posts titles
        if (!empty($searchData->q)) {
            $data = $data
                ->join('p.tags', 't')
                ->andWhere('p.title LIKE :q')
                ->orWhere('t.name LIKE :q')
                ->setParameter('q', "%{$searchData->q}%");
        }
        
        $data = $data
            ->getQuery()
            ->getResult();

        $posts = $this->paginatorInterface->paginate($data, $searchData->page, 9);

        return $posts;
    }
}
