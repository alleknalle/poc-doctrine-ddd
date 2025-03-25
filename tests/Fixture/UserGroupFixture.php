<?php

declare(strict_types=1);

namespace App\Tests\Fixture;

use App\Domain\Shared\ValueObject\UserGroupId;
use App\Domain\User\Entity\UserGroup;
use App\Domain\User\ValueObject\Name;
use App\Domain\User\ValueObject\Slug;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

final class UserGroupFixture extends AbstractFixture
{
	public const string ADMIN = 'group1';
	public const string MANAGER = 'group2';

	public function load(ObjectManager $manager): void
	{
		$adminUserGroup = new UserGroup(
			UserGroupId::fromString(self::ADMIN),
			Slug::fromString('admin'),
			Name::fromString('Administrator')
		);

		$manager->persist($adminUserGroup);

		$managerUserGroup = new UserGroup(
			UserGroupId::fromString(self::MANAGER),
			Slug::fromString('manager'),
			Name::fromString('Manager')
		);

		$manager->persist($managerUserGroup);
		$manager->flush();

		$this->addReference(self::ADMIN, $adminUserGroup);
		$this->addReference(self::MANAGER, $managerUserGroup);
	}
}
