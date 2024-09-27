<?php

namespace App\Repository;

use App\Entity\Snippet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Error;

/**
 * @extends ServiceEntityRepository<Snippet>
 */
class SnippetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Snippet::class);
    }

    public function createOne(string $title, string $code = null): Snippet
    {
        $snippet = new Snippet();
        $snippet->setTitle($title);
        $snippet->setCode($code);
        $em = $this->getEntityManager();

        $em->persist($snippet);
        $em->flush();

        return $snippet;
    }

    public function update(int $id, string $title = null, string $code = null): Snippet
    {
        /** @var Snippet $snippet */
        $snippet = $this->find($id);
        if (is_null($snippet)) throw new Error('Entity not found');

        // Update properties dynamically
        // foreach ($data as $key => $value) {
        //     $setter = 'set' . ucfirst($key);

        //     // Check if the setter exists and call it
        //     if (method_exists($snippet, $setter)) {
        //         $snippet->$setter($value);
        //     }
        // }

        $snippet->setTitle($title);
        $snippet->setCode($code);

        $em = $this->getEntityManager();
        $em->persist($snippet);
        $em->flush();

        return $snippet;
    }

    public function delete(int $id): Snippet
    {
        $snippet = $this->find($id);

        if (!$snippet) {
            return new Snippet();
        }

        $em = $this->getEntityManager();
        $em->remove($snippet);
        $em->flush();
        return $snippet;
    }

    // /**
    //  * @return Snippet[] Returns an array of Snippet objects
    //  */
    // public function findByExampleField($value): array
    // {
    //     return $this->createQueryBuilder('s')
    //         ->andWhere('s.exampleField = :val')
    //         ->setParameter('val', $value)
    //         ->orderBy('s.id', 'ASC')
    //         ->setMaxResults(10)
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }

    // public function findOneBySomeField($value): ?Snippet
    // {
    //     return $this->createQueryBuilder('s')
    //         ->andWhere('s.exampleField = :val')
    //         ->setParameter('val', $value)
    //         ->getQuery()
    //         ->getOneOrNullResult()
    //     ;
    // }
}
