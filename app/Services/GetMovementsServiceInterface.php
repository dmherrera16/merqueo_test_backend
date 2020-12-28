<?php

namespace App\Services;

/**
 * Interface GetMovementsServiceInterface
 * @package App\Services
 */
interface GetMovementsServiceInterface
{
    /**
     * @param array $data
     * @return int
     */
    public function getAmountMovementsByDate(array $data): int;
}
