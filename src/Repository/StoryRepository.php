<?php

namespace CaptJM\Bundle\StorytellerBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use CaptJM\Bundle\StorytellerBundle\Entity\Story;

/**
 * @extends ServiceEntityRepository<Story>
 *
 * @method Story|null findOneBy(array $criteria, array $orderBy = null)
 * @method Story[]    findAll()
 * @method Story[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Story::class);
    }

    public function find($id, $lockMode = null, $lockVersion = null)
    {
        return parent::find($id, $lockMode, $lockVersion);
    }

    public function save(Story $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Story $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findOneBySlug($locale, $slug): ?Story
    {
        $story = null;
        try {
            /** @var Story $story */
            $story = $this->createQueryBuilder('s')
                ->where('s.visible = 1 AND s.locale = :locale AND s.slug = :slug')
                ->setParameters([
                    'slug' => $slug,
                    'locale' => $locale,
                ])
                ->getQuery()
                ->getOneOrNullResult();
            if ($story) {
                foreach ($story->getSections() as $item) {
                    $story->loadedSections[] = $this->getEntityManager()->getRepository($item['class'])->find($item['id']);
                }
            }
        } catch (NonUniqueResultException $e) {
        }
        return $story;
    }
}
