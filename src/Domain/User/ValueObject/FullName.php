<?php

declare(strict_types=1);

namespace App\Domain\User\ValueObject;

/**
 * @todo removed readonly because it doesn't get hydrated correctly
 *
 * @see App\Infrastructure\Doctrine\Subscriber\ValueObjectLifeCycleSubscriber::checkObject
 */
final class FullName
{
    private function __construct(
        private FirstName $firstName,
        private MiddleName|null $middleName,
        private LastName $lastName
    ) {
    }

    public static function fromNames(
        FirstName $firstName,
        MiddleName|null $middleName,
        LastName $lastName
    ): self {
        return new self($firstName, $middleName, $lastName);
    }

    public function toString(): string
    {
        return implode(
            ' ',
            array_filter([
                $this->firstName->toString(),
                $this->middleName?->toString(),
                $this->lastName->toString(),
            ], static function (string|null $value): bool {
                return $value !== null;
            })
        );
    }
}
