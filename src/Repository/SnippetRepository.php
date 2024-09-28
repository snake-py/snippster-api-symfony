<?php

namespace App\Repository;

use App\Entity\Snippet;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Error;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<Snippet>
 */
class SnippetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Snippet::class);
    }

    public function createOne(
        User $user,
        string $title,
        string $code = null,
        string $language = null,
        string $framework = null,
        bool $isPublic = false
    ): Snippet {
        $snippet = new Snippet();
        $snippet->setOwner($user);

        $snippet->setTitle($title);
        $snippet->setCode($code);
        $snippet->setLanguage($language);
        $snippet->setFramework($framework);
        $snippet->setPublic($isPublic);

        $em = $this->getEntityManager();

        $em->persist($snippet);
        $em->flush();

        return $snippet;
    }

    public function update(
        User $user,
        Uuid $id,
        string $title = null,
        string $code = null,
        string $language = null,
        string $framework = null,
        bool $isPublic = false
    ): Snippet {
        /** @var Snippet $snippet */
        $snippet = $this->findOneBy(['id' => $id, 'owner' => $user]);

        if (is_null($snippet)) throw new Error('Entity not found');

        $snippet->setTitle($title);
        $snippet->setCode($code);
        $snippet->setLanguage($language);
        $snippet->setFramework($framework);
        $snippet->setPublic($isPublic);

        $em = $this->getEntityManager();
        $em->persist($snippet);
        $em->flush();

        return $snippet;
    }

    public function delete(Uuid $id): Snippet
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
}
// not sure it something like this considered bad practice here.
// I guess if proper validation before hand it is fine
        // Update properties dynamically
        // foreach ($data as $key => $value) {
        //     $setter = 'set' . ucfirst($key);

        //     // Check if the setter exists and call it
        //     if (method_exists($snippet, $setter)) {
        //         $snippet->$setter($value);
        //     }
        // }