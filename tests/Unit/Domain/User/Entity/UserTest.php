<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\User\Entity;

use App\Domain\Entity\Group;
use App\Domain\Entity\Ids\GroupId;
use App\Domain\Entity\Ids\UserId;
use App\Domain\Entity\User;
use App\Domain\User\ValueObject\City;
use App\Domain\User\ValueObject\FirstName;
use App\Domain\User\ValueObject\FullName;
use App\Domain\User\ValueObject\LastName;
use App\Domain\User\ValueObject\MiddleName;
use App\Domain\User\ValueObject\Name;
use App\Domain\User\ValueObject\Street;
use App\Domain\User\ValueObject\Username;
use App\Domain\ValueObject\Address;
use App\Domain\ValueObject\CountryCode;
use App\Domain\ValueObject\HouseNumber;
use App\Domain\ValueObject\PostalCode;
use App\Domain\ValueObject\Slug;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    public function testUserCanBeCreated(): void
    {
        $group = new Group(
            GroupId::fromInt('test'),
            Slug::fromString('cool'),
            Name::fromString('blaat'),
        );

        new User(
            UserId::fromString('random'),
            Username::fromString('my-username'),
            FullName::fromNames(
                FirstName::fromString('Sebas'),
                MiddleName::fromString('van der'),
                LastName::fromString('Gekte'),
            ),
            Address::fromAddressLines(
                Street::fromString('test street'),
                HouseNumber::fromString('14'),
                PostalCode::fromString('1111AA'),
                City::fromString('Harderwijk'),
                CountryCode::NL
            ),
            true,
            $group
        );

        $this->expectNotToPerformAssertions();
    }
}
