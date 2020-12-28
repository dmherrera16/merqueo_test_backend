<?php

namespace App\Repositories;

use App\Models\Movements;

/**
 * Interface MovementsRepositoryInterface
 * @package App\Repositories
 */
interface CreateMovementsRepositoryInterface
{
    /**
     * @param array $data
     * @return Movements
     */
    public function create(array $data):Movements;

    /**
     * @param string $date
     * @return int
     */
    public function getAmountMovementsByDate(string $date): int;

    /**
     * @return array
     */
    public function getAllMovements(): array;
}
