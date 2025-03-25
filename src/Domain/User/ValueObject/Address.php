<?php

declare(strict_types=1);

namespace App\Domain\User\ValueObject;

use App\Domain\User\Enum\CountryCode;

final readonly class Address
{
    private function __construct(
        private Street $street,
        private HouseNumber $houseNumber,
        private PostalCode $postalCode,
        private City $city,
        private CountryCode $countryCode,
    ) {
    }

    public static function fromAddressLines(
        Street $street,
        HouseNumber $houseNumber,
        PostalCode $postalCode,
        City $city,
        CountryCode $countryCode,
    ): self {
        return new self($street, $houseNumber, $postalCode, $city, $countryCode);
    }

    public function getStreet(): Street
    {
        return $this->street;
    }

    public function getHouseNumber(): HouseNumber
    {
        return $this->houseNumber;
    }

    public function getPostalCode(): PostalCode
    {
        return $this->postalCode;
    }

    public function getCity(): City
    {
        return $this->city;
    }

    public function getCountryCode(): CountryCode
    {
        return $this->countryCode;
    }

}
