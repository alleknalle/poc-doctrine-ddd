<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\User\Repository;

use App\Domain\Shared\ValueObject\UserId;
use App\Domain\User\Entity\User as DomainUser;
use App\Domain\User\Entity\UserGroup;
use App\Domain\User\Exception\UserNotFoundException;
use App\Domain\User\Repository\UserRepository as DomainUserRepository;
use App\Domain\User\ValueObject\Username;
use App\Infrastructure\Doctrine\User\Entity\User;
use App\Infrastructure\Doctrine\User\Mapper\UserMapper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class UserRepository extends ServiceEntityRepository implements DomainUserRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private UserMapper $userMapper,
        private UserGroupRepository $userGroupRepository,
    ) {
        parent::__construct($registry, User::class);
    }

    public function getByUserId(UserId $userId): DomainUser
    {
        $user = $this->findOneBy(['id' => $userId->getUserId()]);
        if (!$user instanceof User) {
            throw new UserNotFoundException('id', $userId->getUserId());
        }

        return $this->userMapper->toDomain($user);
    }

    public function getByUsername(Username $username): DomainUser
    {
        $user = $this->findOneBy(['username' => $username->getUsername()]);
        if (!$user instanceof User) {
            throw new UserNotFoundException('username', $username);
        }

        return $this->userMapper->toDomain($user);
    }

    public function getByUserGroup(UserGroup $userGroup): array
    {
        $doctrineUserGroup = $this->userGroupRepository->getDoctrineByUserGroupId($userGroup->getUserGroupId()->getUserGroupId());

        $users = $this->findBy(['userGroup' => $doctrineUserGroup]);

        return array_map([$this->userMapper, 'toDomain'], $users);
    }

    public function store(DomainUser $user): void
    {
        $doctrineUser = $this->userMapper->fromDomain($user);

        $this->getEntityManager()->persist($doctrineUser);
        $this->getEntityManager()->flush(); // TODO : transactions via application?
    }
}
