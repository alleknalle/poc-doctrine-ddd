<?php

declare(strict_types=1);

namespace App\Tests\Integration;

use App\Domain\Shared\ValueObject\UserGroupId;
use App\Domain\Shared\ValueObject\UserId;
use App\Domain\User\Entity\User;
use App\Domain\User\Entity\UserGroup;
use App\Domain\User\Enum\CountryCode;
use App\Domain\User\Repository\UserGroupRepository;
use App\Domain\User\Repository\UserRepository;
use App\Domain\User\ValueObject\Address;
use App\Domain\User\ValueObject\City;
use App\Domain\User\ValueObject\FirstName;
use App\Domain\User\ValueObject\FullName;
use App\Domain\User\ValueObject\HouseNumber;
use App\Domain\User\ValueObject\LastName;
use App\Domain\User\ValueObject\MiddleName;
use App\Domain\User\ValueObject\Name;
use App\Domain\User\ValueObject\PostalCode;
use App\Domain\User\ValueObject\Slug;
use App\Domain\User\ValueObject\Street;
use App\Domain\User\ValueObject\Username;
use App\Tests\Fixture\UserFixture;
use App\Tests\Fixture\UserGroupFixture;
use Doctrine\ORM\EntityManager;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class UserTest extends KernelTestCase
{
	protected AbstractDatabaseTool $databaseTool;

	public function setUp(): void
	{
		parent::setUp();

		$this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
	}

	protected function tearDown(): void
	{
		parent::tearDown();
		unset($this->databaseTool);
	}

	public function testStoreUsersAndGroups(): void
	{
		$this->databaseTool->loadFixtures([]);

		/** @var UserGroupRepository $userGroupRepo */
		$userGroupRepo = self::getContainer()->get(UserGroupRepository::class);

		$adminUserGroup = new UserGroup(
			UserGroupId::fromString('group1'),
			Slug::fromString('admin'),
			Name::fromString('Administrator')
		);

		$userGroupRepo->store($adminUserGroup);

		/** @var UserRepository $userRepo */
		$userRepo = self::getContainer()->get(UserRepository::class);

		$user = new User(
			UserId::fromString('user1'),
			Username::fromString('alleknalle'),
			FullName::fromNames(
				FirstName::fromString('Jille'),
				MiddleName::fromString('van'),
				LastName::fromString('Behm')
			),
			Address::fromAddressLines(
				Street::fromString('Teststraat'),
				HouseNumber::fromString('2abc'),
				PostalCode::fromString('1111VG'),
				City::fromString('Drielanden'),
				CountryCode::NL
			),
			true,
			$adminUserGroup
		);
		$userRepo->store($user);

		$user2 = new User(
			UserId::fromString('user2'),
			Username::fromString('scienta'),
			FullName::fromNames(
				FirstName::fromString('Scienta'),
				null,
				LastName::fromString('B.V.')
			),
			Address::fromAddressLines(
				Street::fromString('Stephensonstraat'),
				HouseNumber::fromString('31'),
				PostalCode::fromString('3846 AK'),
				City::fromString('Harderwijk'),
				CountryCode::NL
			),
			false,
			$adminUserGroup,
		);
		$userRepo->store($user2);

		/** @var EntityManager $erm */
		$erm = self::getContainer()->get('doctrine.orm.entity_manager');
		$erm->clear();

		$storedAdminUserGroup = $userGroupRepo->getByUserGroupId(UserGroupId::fromString('group1'));

		self::assertSame('group1', $storedAdminUserGroup->getUserGroupId()->toString());
		self::assertSame('admin', $storedAdminUserGroup->getSlug()->toString());
		self::assertSame('Administrator', $storedAdminUserGroup->getName()->toString());

		$storedUser = $userRepo->getByUserId(UserId::fromString('user1'));

		self::assertSame('user1', $storedUser->getUserId()->toString());
		self::assertSame('alleknalle', $storedUser->getUsername()->toString());
		self::assertSame('Jille van Behm', $storedUser->getFullName()->toString());
		self::assertSame('Teststraat 2abc, 1111VG Drielanden, NL', $storedUser->getAddress()->toString());
		self::assertSame(true, $storedUser->isActive());
		self::assertSame($storedAdminUserGroup, $storedUser->getUserGroup());

		$storedUser2 = $userRepo->getByUserId(UserId::fromString('user2'));

		self::assertSame('user2', $storedUser2->getUserId()->toString());
		self::assertSame('scienta', $storedUser2->getUsername()->toString());
		self::assertSame('Scienta B.V.', $storedUser2->getFullName()->toString());
		self::assertSame('Stephensonstraat 31, 3846 AK Harderwijk, NL', $storedUser2->getAddress()->toString());
		self::assertSame(false, $storedUser2->isActive());
		self::assertSame($storedAdminUserGroup, $storedUser2->getUserGroup());
	}

	public function testGetUsersAndGroups(): void
	{
		$this->databaseTool->loadFixtures([UserFixture::class]);

		/** @var UserRepository $userRepo */
		$userRepo = self::getContainer()->get(UserRepository::class);

		$adminUser = $userRepo->getByUserId(UserId::fromString('user1'));

		self::assertInstanceOf(User::class, $adminUser);
		self::assertSame('user1', $adminUser->getUserId()->toString());
		self::assertSame('scienta', $adminUser->getUsername()->toString());
		self::assertSame('Scienta B.V.', $adminUser->getFullName()->toString());
		self::assertSame('Stephensonstraat 31, 3846 AK Harderwijk, NL', $adminUser->getAddress()->toString());
		self::assertSame(true, $adminUser->isActive());

		self::assertSame('group1', $adminUser->getUserGroup()->getUserGroupId()->toString());
		self::assertSame('admin', $adminUser->getUserGroup()->getSlug()->toString());
		self::assertSame('Administrator', $adminUser->getUserGroup()->getName()->toString());

		/** @var UserGroupRepository $userGroupRepo */
		$userGroupRepo = self::getContainer()->get(UserGroupRepository::class);

		$managerGroup = $userGroupRepo->getByUserGroupId(UserGroupId::fromString(UserGroupFixture::MANAGER));

		$users = $userRepo->getByUserGroup($managerGroup);

		self::assertCount(2, $users);
	}

	public function testUpdateUser(): void
	{
		$this->databaseTool->loadFixtures([UserFixture::class]);

		/** @var UserRepository $userRepo */
		$userRepo = self::getContainer()->get(UserRepository::class);

		$adminUser = $userRepo->getByUserId(UserId::fromString('user1'));

		$adminUser->update(
			Username::fromString('nieuwe-naam'),
			FullName::fromNames(
				FirstName::fromString('nieuwe'),
				null,
				LastName::fromString('naam'),
			),
		);

		$userRepo->store($adminUser);

		/** @var EntityManager $erm */
		$erm = self::getContainer()->get('doctrine.orm.entity_manager');
		$erm->clear();

		$updatedAdminUser = $userRepo->getByUserId(UserId::fromString('user1'));

		self::assertSame('nieuwe-naam', $updatedAdminUser->getUsername()->toString());
	}
}
