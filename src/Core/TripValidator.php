<?php

declare(strict_types=1);

namespace App\Core;

use DateTimeImmutable;

/**
 * Validateur metier d'un trajet.
 * Je centralise les regles de coherence avant ecriture en base.
 */
final class TripValidator
{
    /**
     * @param array<string, mixed> $payload
     * @return string[]
     */
    public function validate(array $payload): array
    {
        $errors = [];

        // Regle 1: depart et arrivee ne peuvent pas etre identiques.
        if ((int) $payload['departure_agency_id'] === (int) $payload['arrival_agency_id']) {
            $errors[] = 'Les agences de depart et arrivee doivent etre differentes.';
        }

        // Regle 2: bornes de places coherentes.
        $totalSeats = (int) $payload['total_seats'];
        $availableSeats = (int) $payload['available_seats'];
        if ($totalSeats <= 0 || $availableSeats < 0 || $availableSeats > $totalSeats) {
            $errors[] = 'Le nombre de places est incoherent.';
        }

        // Regle 3: date d'arrivee strictement apres date de depart.
        try {
            $departure = new DateTimeImmutable((string) $payload['departure_at']);
            $arrival = new DateTimeImmutable((string) $payload['arrival_at']);
            if ($arrival <= $departure) {
                $errors[] = 'La date d arrivee doit etre superieure a la date de depart.';
            }
        } catch (\Exception) {
            $errors[] = 'Le format de date est invalide.';
        }

        return $errors;
    }
}
