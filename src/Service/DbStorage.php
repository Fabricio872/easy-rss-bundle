<?php

declare(strict_types=1);

namespace Fabricio872\EasyRssBundle\Service;

use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Fabricio872\EasyRssBundle\DTO\Feed;
use Fabricio872\EasyRssBundle\DTO\FeedInterface;
use Fabricio872\EasyRssBundle\Entity\RssFeed;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Uid\Uuid;

class DbStorage implements RssStorageInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly DenormalizerInterface $denormalizer,
        private readonly NormalizerInterface $normalizer
    ) {
    }

    public function add(FeedInterface $feed, ?Uuid $id = null): Feed
    {
        if (! $id) {
            $feedEntity = new RssFeed();
            $feedEntity->setCreatedAt(new DateTimeImmutable());
        } else {
            $feedEntity = $this->em->getRepository(RssFeed::class)->find($id);
            if (! $feedEntity) {
                throw new EntityNotFoundException(sprintf('Uuid "%s" not found', $id));
            }
        }
        $feedEntity
            ->setTitle($feed->getTitle())
            ->setDescription($feed->getDescription())
            ->setChannel($feed->getChannel() ?? 'default')
            ->setAuthor($feed->getAuthor())
            ->setLink($feed->getLink())
            ->setUpdatedAt(new DateTimeImmutable());

        $this->em->persist($feedEntity);

        return $this->denormalizer->denormalize($this->normalizer->normalize($feedEntity), Feed::class);
    }

    public function clean(?string $channel, ?int $maxFeeds): void
    {
        if (! $maxFeeds) {
            return;
        }

        $qb = $this->em->createQueryBuilder()
            ->select('r')
            ->from(RssFeed::class, 'r')
            ->orderBy('r.updatedAt', 'DESC')
            ->andWhere('r.channel = :channel')
            ->setParameter('channel', $channel ?? 'default')
            ->setFirstResult($maxFeeds);

        foreach ($qb->getQuery()->getResult() as $feedToDelete) {
            $this->em->remove($feedToDelete);
        }
        $this->em->flush();
    }

    /**
     * @return array<int, Feed>
     */
    public function all(): array
    {
        $entities = $this->em->getRepository(RssFeed::class)->findAll();
        return $this->denormalizer->denormalize($this->normalizer->normalize($entities), Feed::class . '[]');
    }

    public function getById(Uuid $id): ?FeedInterface
    {
        $entity = $this->em->getRepository(RssFeed::class)->find($id);
        return $this->denormalizer->denormalize($this->normalizer->normalize($entity), Feed::class);
    }
}
