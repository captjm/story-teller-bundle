<?php

namespace CaptJM\Bundle\StoryTellerBundle\Repository;

use CaptJM\Bundle\StoryTellerBundle\Entity\Font;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * @extends ServiceEntityRepository<Font>
 *
 * @method Font|null find($id, $lockMode = null, $lockVersion = null)
 * @method Font|null findOneBy(array $criteria, array $orderBy = null)
 * @method Font[]    findAll()
 * @method Font[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FontRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Font::class);
    }

    public function save(Font $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Font $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getFontNames(): ?string
    {
        $cache = new FilesystemAdapter();
        try {
            $fontNames = $cache->get('font_names', function (ItemInterface $item) {
                $item->expiresAfter(null);
                return implode(';', array_map(function (Font $font) {
                    return $font->getName();
                }, $this->findAll()));
            });
        } catch (InvalidArgumentException $e) {
            $fontNames = null;
        }
        return $fontNames;
    }

    public function updateFontCSSFile($file)
    {
        $fonts = array_map(function (Font $font) {
            return $font->getCSS();
        }, $this->findAll());
        file_put_contents($file, implode(PHP_EOL, $fonts));
        try {
            (new FilesystemAdapter())->delete('font_names');
        } catch (InvalidArgumentException $e) {
        }
    }
}
