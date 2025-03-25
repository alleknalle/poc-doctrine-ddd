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
		$userGroup = $this->findOneBy(['user_group_id' => $userGroupId->toString()]);
		if (!$userGroup instanceof UserGroup) {
			throw new UserGroupNotFoundException('user group id', $userGroupId->toString());
		}

		return $userGroup;
	}

	public function getBySlug(Slug $slug): UserGroup
	{
		$userGroup = $this->findOneBy(['slug' => $slug->toString()]);
		if (!$userGroup instanceof UserGroup) {
			throw new UserGroupNotFoundException('slug', $slug->toString());
		}

		return $userGroup;
	}

	public function store(UserGroup $userGroup): void
	{
		$this->getEntityManager()->persist($userGroup);
		$this->getEntityManager()->flush(); // TODO : transactions via application?
	}
}
