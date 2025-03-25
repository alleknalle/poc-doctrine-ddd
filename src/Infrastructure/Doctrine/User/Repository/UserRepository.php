<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\User\Repository;

use App\Domain\Shared\ValueObject\UserId;
use App\Domain\User\Entity\User;
use App\Domain\User\Entity\UserGroup;
use App\Domain\User\Exception\UserNotFoundException;
use App\Domain\User\Repository\UserRepository as DomainUserRepository;
use App\Domain\User\ValueObject\Username;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class UserRepository extends ServiceEntityRepository implements DomainUserRepository
{
	public function __construct(
		ManagerRegistry $registry,
	) {
		parent::__construct($registry, User::class);
	}

	public function getByUserId(UserId $userId): User
	{
		$user = $this->findOneBy(['columnUserId' => $userId->toString()]);
		if (!$user instanceof User) {
			throw new UserNotFoundException('user_id', $userId->toString());
		}

		return $user;
	}

	public function getByUsername(Username $username): User
	{
		$user = $this->findOneBy(['columnUsername' => $username->toString()]);
		if (!$user instanceof User) {
			throw new UserNotFoundException('username', $username);
		}

		return $user;
	}

	public function getByUserGroup(UserGroup $userGroup): array
	{
		return $this->findBy(['userGroup' => $userGroup]);
	}

	public function store(User $user): void
	{
		$this->getEntityManager()->persist($user);
		$this->getEntityManager()->flush(); // TODO : transactions via application?
	}
}
