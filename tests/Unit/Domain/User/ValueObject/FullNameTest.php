<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\User\ValueObject;

use App\Domain\User\ValueObject\FirstName;
use App\Domain\User\ValueObject\FullName;
use App\Domain\User\ValueObject\LastName;
use PHPUnit\Framework\TestCase;

final class FullNameTest extends TestCase
{
    public function testFullNameCanBeCreated(): void
    {
        $fullName = FullName::fromNames(
            FirstName::fromString('Henry'),
            null,
            LastName::fromString('Schut')
        );

        $this->assertSame('Henry Schut', $fullName->toString());
    }
}
