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
}
