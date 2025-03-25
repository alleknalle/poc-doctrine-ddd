<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\User\Repository;

use App\Domain\Shared\ValueObject\UserGroupId;
use App\Domain\User\Entity\UserGroup;
use App\Domain\User\Exception\UserGroupNotFoundException;
use App\Domain\User\Repository\UserGroupRepository as DomainUserGroupRepository;
use App\Domain\User\ValueObject\Slug;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class UserGroupRepository extends ServiceEntityRepository implements DomainUserGroupRepository
{
    public function __construct(
        ManagerRegistry $registry,
    ) {
        parent::__construct($registry, UserGroup::class);
    }

    public function getByUserGroupId(UserGroupId $userGroupId): UserGroup
    {
        $userGroup = $this->findOneBy(['id' => $userGroupId]);
        if (!$userGroup instanceof UserGroup) {
            throw new UserGroupNotFoundException('id', $userGroupId);
        }

        return $userGroup;
    }

    public function getBySlug(Slug $slug): UserGroup
    {
        $userGroup = $this->findOneBy(['slug' => $slug]);
        if (!$userGroup instanceof UserGroup) {
            throw new UserGroupNotFoundException('slug', $slug);
        }

        return $userGroup;
    }

    public function store(UserGroup $userGroup): void
    {
        $this->getEntityManager()->persist($userGroup);
        $this->getEntityManager()->flush(); // TODO : transactions via application?
    }
}
