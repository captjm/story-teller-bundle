<?php

namespace CaptJM\Bundle\StorytellerBundle\Repository;

use CaptJM\Bundle\StorytellerBundle\Entity\EntityTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EntityTranslation>
 *
 * @method EntityTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method EntityTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method EntityTranslation[]    findAll()
 * @method EntityTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntityTranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EntityTranslation::class);
    }

    public function save(EntityTranslation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EntityTranslation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
