<?php

declare(strict_types=1);

namespace App\Tests\Fixture;

use App\Domain\Shared\ValueObject\UserId;
use App\Domain\User\Entity\User;
use App\Domain\User\Entity\UserGroup;
use App\Domain\User\Enum\CountryCode;
use App\Domain\User\ValueObject\Address;
use App\Domain\User\ValueObject\City;
use App\Domain\User\ValueObject\FirstName;
use App\Domain\User\ValueObject\FullName;
use App\Domain\User\ValueObject\HouseNumber;
use App\Domain\User\ValueObject\LastName;
use App\Domain\User\ValueObject\MiddleName;
use App\Domain\User\ValueObject\PostalCode;
use App\Domain\User\ValueObject\Street;
use App\Domain\User\ValueObject\Username;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class UserFixture extends AbstractFixture implements DependentFixtureInterface
{
	public function load(ObjectManager $manager): void
	{
		$scientaUser = new User(
			UserId::fromString('user1'),
			Username::fromString('scienta'),
			FullName::fromNames(
				FirstName::fromString('Scienta'),
				null,
				LastName::fromString('B.V.')
			),
			Address::fromAddressLines(
				Street::fromString('Stephensonstraat 31'),
				HouseNumber::fromString('31'),
				PostalCode::fromString('3846 AK'),
				City::fromString('Harderwijk'),
				CountryCode::NL
			),
			$this->getReference(UserGroupFixture::ADMIN, UserGroup::class),
		);

		$manager->persist($scientaUser);

		$jilleUser = new User(
			UserId::fromString('user2'),
			Username::fromString('alleknalle'),
			FullName::fromNames(
				FirstName::fromString('Jille'),
				MiddleName::fromString('van'),
				LastName::fromString('Behm')
			),
			Address::fromAddressLines(
				Street::fromString('Teststraat'),
				HouseNumber::fromString('2'),
				PostalCode::fromString('1111VG'),
				City::fromString('Drielanden'),
				CountryCode::NL
			),
			$this->getReference(UserGroupFixture::MANAGER, UserGroup::class),
		);

		$manager->persist($jilleUser);

		$malaysiaUser = new User(
			UserId::fromString('user3'),
			Username::fromString('malaysia'),
			FullName::fromNames(
				FirstName::fromString('Malaysia'),
				null,
				LastName::fromString('Office')
			),
			Address::fromAddressLines(
				Street::fromString('CoPlace'),
				HouseNumber::fromString('1'),
				PostalCode::fromString('2270'),
				City::fromString('Jalan Usahawan'),
				CountryCode::DE
			),
			$this->getReference(UserGroupFixture::MANAGER, UserGroup::class),
		);

		$manager->persist($malaysiaUser);

		$manager->flush();
	}

	public function getDependencies(): array
	{
		return [
			UserGroupFixture::class,
		];
	}
}
