<?php

declare(strict_types=1);

namespace Tests;

use App\Repository\AgencyRepository;
use App\Repository\TripRepository;
use PDO;
use PHPUnit\Framework\TestCase;

final class RepositoryWriteTest extends TestCase
{
    private PDO $pdo;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec('PRAGMA foreign_keys = ON');

        $this->createSchema();
        $this->seedBaseData();
    }

    public function testAgencyRepositoryCanCreateUpdateAndDeleteAgency(): void
    {
        $repository = new AgencyRepository($this->pdo);

        $repository->create('Brest');
        $createdQuery = $this->pdo->query("SELECT id, name FROM agencies WHERE name = 'Brest'");
        self::assertNotFalse($createdQuery);
        $created = $createdQuery->fetch();
        self::assertIsArray($created);
        self::assertSame('Brest', $created['name']);

        $agencyId = (int) $created['id'];
        $repository->update($agencyId, 'Brest Centre');
        $updated = $repository->findById($agencyId);
        self::assertIsArray($updated);
        self::assertSame('Brest Centre', $updated['name']);

        $repository->delete($agencyId);
        self::assertNull($repository->findById($agencyId));
    }

    public function testTripRepositoryCanCreateUpdateAndDeleteTrip(): void
    {
        $repository = new TripRepository($this->pdo);

        $repository->create([
            'departure_agency_id' => 1,
            'arrival_agency_id' => 2,
            'departure_at' => '2030-01-10 08:00:00',
            'arrival_at' => '2030-01-10 10:00:00',
            'total_seats' => 4,
            'available_seats' => 3,
            'user_id' => 1,
        ]);

        $createdQuery = $this->pdo->query("SELECT id FROM trips WHERE departure_at = '2030-01-10 08:00:00'");
        self::assertNotFalse($createdQuery);
        $created = $createdQuery->fetch();
        self::assertIsArray($created);
        $tripId = (int) $created['id'];

        $repository->update($tripId, [
            'departure_agency_id' => 1,
            'arrival_agency_id' => 2,
            'departure_at' => '2030-01-10 09:00:00',
            'arrival_at' => '2030-01-10 11:00:00',
            'total_seats' => 5,
            'available_seats' => 4,
        ]);

        $updated = $repository->findById($tripId);
        self::assertIsArray($updated);
        self::assertSame('2030-01-10 09:00:00', $updated['departure_at']);
        self::assertSame(5, (int) $updated['total_seats']);

        $repository->delete($tripId);
        self::assertNull($repository->findById($tripId));
    }

    private function createSchema(): void
    {
        $this->pdo->exec(
            'CREATE TABLE agencies (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL UNIQUE
            )'
        );

        $this->pdo->exec(
            'CREATE TABLE users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                last_name TEXT NOT NULL,
                first_name TEXT NOT NULL,
                phone TEXT NOT NULL,
                email TEXT NOT NULL UNIQUE,
                password_hash TEXT NOT NULL,
                role TEXT NOT NULL
            )'
        );

        $this->pdo->exec(
            'CREATE TABLE trips (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                departure_agency_id INTEGER NOT NULL,
                arrival_agency_id INTEGER NOT NULL,
                departure_at TEXT NOT NULL,
                arrival_at TEXT NOT NULL,
                total_seats INTEGER NOT NULL,
                available_seats INTEGER NOT NULL,
                user_id INTEGER NOT NULL,
                FOREIGN KEY (departure_agency_id) REFERENCES agencies(id),
                FOREIGN KEY (arrival_agency_id) REFERENCES agencies(id),
                FOREIGN KEY (user_id) REFERENCES users(id)
            )'
        );
    }

    private function seedBaseData(): void
    {
        $this->pdo->exec("INSERT INTO agencies (name) VALUES ('Paris'), ('Lyon')");
        $this->pdo->exec(
            "INSERT INTO users (last_name, first_name, phone, email, password_hash, role)
             VALUES ('Martin', 'Alexandre', '0612345678', 'alexandre.martin@email.fr', 'hash', 'admin')"
        );
    }
}
