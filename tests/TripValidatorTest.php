<?php

declare(strict_types=1);

namespace Tests;

use App\Core\TripValidator;
use PHPUnit\Framework\TestCase;

final class TripValidatorTest extends TestCase
{
    public function testValidateAcceptsConsistentTripPayload(): void
    {
        $validator = new TripValidator();
        $errors = $validator->validate([
            'departure_agency_id' => 1,
            'arrival_agency_id' => 2,
            'departure_at' => '2030-01-01 08:00:00',
            'arrival_at' => '2030-01-01 10:00:00',
            'total_seats' => 4,
            'available_seats' => 2,
        ]);

        self::assertSame([], $errors);
    }

    public function testValidateReturnsErrorsOnInvalidWritePayload(): void
    {
        $validator = new TripValidator();
        $errors = $validator->validate([
            'departure_agency_id' => 1,
            'arrival_agency_id' => 1,
            'departure_at' => '2030-01-01 10:00:00',
            'arrival_at' => '2030-01-01 09:00:00',
            'total_seats' => 2,
            'available_seats' => 3,
        ]);

        self::assertNotEmpty($errors);
    }
}
