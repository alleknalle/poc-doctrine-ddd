<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\User\Repository;

use App\Domain\Shared\ValueObject\UserGroupId;
use App\Domain\User\Entity\UserGroup as DomainUserGroup;
use App\Domain\User\Exception\UserGroupNotFoundException;
use App\Domain\User\Repository\UserGroupRepository as DomainUserGroupRepository;
use App\Domain\User\ValueObject\Slug;
use App\Infrastructure\Doctrine\User\Entity\UserGroup;
use App\Infrastructure\Doctrine\User\Mapper\UserGroupMapper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class UserGroupRepository extends ServiceEntityRepository implements DomainUserGroupRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private UserGroupMapper $userGroupMapper
    ) {
        parent::__construct($registry, UserGroup::class);
    }

    public function getByUserGroupId(UserGroupId $userGroupId): DomainUserGroup
    {
        $userGroup = $this->getDoctrineByUserGroupId($userGroupId->getUserGroupId());

        return $this->userGroupMapper->toDomain($userGroup);
    }

    public function getBySlug(Slug $slug): DomainUserGroup
    {
        $userGroup = $this->getDoctrineBySlug($slug->getSlug());

        return $this->userGroupMapper->toDomain($userGroup);
    }

    public function store(DomainUserGroup $userGroup): void
    {
        $doctrineUserGroup = $this->userGroupMapper->fromDomain($userGroup);

        $this->getEntityManager()->persist($doctrineUserGroup);
        $this->getEntityManager()->flush(); // TODO : transactions via application?
    }

    public function getDoctrineByUserGroupId(string $userGroupId): UserGroup
    {
        $userGroup = $this->findOneBy(['id' => $userGroupId]);
        if (!$userGroup instanceof UserGroup) {
            throw new UserGroupNotFoundException('id', $userGroupId);
        }

        return $userGroup;
    }

    public function getDoctrineBySlug(string $slug): UserGroup
    {
        $userGroup = $this->findOneBy(['slug' => $slug]);
        if (!$userGroup instanceof UserGroup) {
            throw new UserGroupNotFoundException('slug', $slug);
        }

        return $userGroup;
    }
}
