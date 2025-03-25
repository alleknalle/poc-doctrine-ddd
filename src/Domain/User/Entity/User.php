<?php

declare(strict_types=1);

namespace App\Domain\User\Entity;

use App\Domain\Shared\ValueObject\UserId;
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
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity()]
#[Table(name: 'users')]
#[ChangeTrackingPolicy('DEFERRED_EXPLICIT')]
class User
{
    #[Column(name: 'user_id', type: 'string', length: 32, nullable: false)]
    #[Id]
    private string $columnUserId;

    #[Column(name: 'username', type: 'string', nullable: false)]
    private string $columnUsername;

    #[Column(name: 'first_name', type: 'string', nullable: false)]
    private string $columnFirstName;

    #[Column(name: 'middle_name', type: 'string', nullable: true)]
    private string|null $columnMiddleName = null;

    #[Column(name: 'last_name', type: 'string', nullable: false)]
    private string $columnLastName;

    #[Column(name: 'street', type: 'string', nullable: false)]
    private string $columnStreet;

    #[Column(name: 'house_number', type: 'string', nullable: false)]
    private string $columnHouseNumber;

    #[Column(name: 'postal_code', type: 'string', nullable: false)]
    private string $columnPostalCode;

    #[Column(name: 'city', type: 'string', nullable: false)]
    private string $columnCity;

    #[Column(name: 'country_code', type: 'string', nullable: false)]
    private string $columnCountryCode;

    #[Column(name: 'active', type: 'boolean', nullable: false)]
    private bool $active;

    #[ManyToOne(targetEntity: UserGroup::class)]
    #[JoinColumn(name: 'user_group_id', referencedColumnName: 'user_group_id', nullable: false)]
    private UserGroup $userGroup;

    public function __construct(
        private UserId $userId {
            get => UserId::fromString($this->columnUserId);
            set (UserId $userId) {
                $this->columnUserId = $userId->toString();
            }
        },
        private Username $username {
            get => Username::fromString($this->columnUsername);
            set (Username $username) {
                $this->columnUsername = $username->toString();
            }
        },
        private FullName $fullName {
            get => FullName::fromNames(
                FirstName::fromString($this->columnFirstName),
                $this->columnMiddleName ? MiddleName::fromString($this->columnMiddleName) : null,
                LastName::fromString($this->columnLastName),
            );
            set (FullName $fullName) {
                $this->columnFirstName = $fullName->getFirstName()->toString();
                $this->columnMiddleName = $fullName->getMiddleName()?->toString();
                $this->columnLastName = $fullName->getLastName()->toString();
            }
        },
        private Address $address {
            get => Address::fromAddressLines(
                Street::fromString($this->columnStreet),
                HouseNumber::fromString($this->columnHouseNumber),
                PostalCode::fromString($this->columnPostalCode),
                City::fromString($this->columnCity),
                CountryCode::from($this->columnCountryCode),
            );
            set (Address $address) {
                $this->columnStreet = $address->getStreet()->toString();
                $this->columnHouseNumber = $address->getHouseNumber()->toString();
                $this->columnPostalCode = $address->getPostalCode()->toString();
                $this->columnCity = $address->getCity()->toString();
                $this->columnCountryCode = $address->getCountryCode()->value;
            }
        },
        bool $active,
        UserGroup $userGroup,
    ) {
        $this->active = $active;
        $this->userGroup = $userGroup;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getUsername(): Username
    {
        return $this->username;
    }

    public function getFullName(): FullName
    {
        return $this->fullName;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getUserGroup(): UserGroup
    {
        return $this->userGroup;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function update(
        Username $username,
        FullName $fullName,
    ): void {
        $this->username = $username;
        $this->fullName = $fullName;
    }

    public function updateAddress(Address $address): void
    {
        $this->address = $address;
    }

}
