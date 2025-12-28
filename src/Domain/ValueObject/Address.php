<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

final readonly class Address
{
    private function __construct(
        private string $street,
        private HouseNumber $houseNumber,
        private PostalCode $postalCode,
        private string $city,
        private CountryCode $countryCode,
    ) {
    }

    public static function fromAddressLines(
        string $street,
        HouseNumber $houseNumber,
        PostalCode $postalCode,
        string $city,
        CountryCode $countryCode,
    ): self {
        return new self($street, $houseNumber, $postalCode, $city, $countryCode);
    }

    public function getStreet(): string
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

    public function getCity(): string
    {
        return $this->city;
    }

    public function getCountryCode(): CountryCode
    {
        return $this->countryCode;
    }

}
