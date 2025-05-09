<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\Entity\Group;
use App\Domain\Entity\Ids\GroupId;
use App\Domain\Entity\Ids\UserId;
use App\Domain\User\Exception\UserNotFoundException;
use App\Domain\User\Repository\UserRepository;
use App\Domain\ValueObject\Address;
use App\Domain\ValueObject\CountryCode;
use App\Domain\ValueObject\HouseNumber;
use App\Domain\ValueObject\PostalCode;
use App\Domain\Entity\User;
use App\Infrastructure\Model\User\User AS UserModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use function array_map;

final class UserRepositoryUsingDoctrine extends ServiceEntityRepository implements UserRepository
{

	public function __construct(
		ManagerRegistry $registry,
	) {
		parent::__construct($registry, UserModel::class);
	}

	public function getByUserId(UserId $userId): User
	{
		$user = $this->findBy(['id' => $userId->toString()]);

		if (!$user instanceof UserModel) {
			throw new UserNotFoundException('id', $userId->toString());
		}

		return new User(
			userId: UserId::fromString($user->getId()),
			username: $user->getUsername(),
			fullName: ':fullName:',
			address: Address::fromAddressLines(
				street: ':street:',
				houseNumber: HouseNumber::fromString(':houseNumber:'),
				postalCode: PostalCode::fromString(':postalCode:'),
				city: ':city:',
				countryCode: CountryCode::NL,
			),
			active: true,
			groupId: GroupId::fromInt($user->getGroupId()),
		);
	}

	public function getByGroupId(GroupId $groupId): array
	{
		$users = $this->findBy(['groupId' => $groupId->toInt()]);
		return array_map(static fn (UserModel $user) =>   new User(
			userId: UserId::fromString($user->getId()),
			username: $user->getUsername(),
			fullName: ':fullName:',
			address: Address::fromAddressLines(
				street: ':street:',
				houseNumber: HouseNumber::fromString(':houseNumber:'),
				postalCode: PostalCode::fromString(':postalCode:'),
				city: ':city:',
				countryCode: CountryCode::NL,
			),
			active: true,
			groupId: GroupId::fromInt($user->getGroupId()),
		), $users);
	}

	public function store(User $user): void
	{
		$userToSave = $this->findBy(['id' => $user->getUserId()->toString()]);
		if (!$userToSave instanceof UserModel) {
			throw new UserNotFoundException('id', $user->getUserId()->toString());
		}

		$userToSave->groupId = $user->getGroupId()->toInt();
		$userToSave->name = $user->getUsername();
		$this->getEntityManager()->persist($userToSave);
	}
}