<?php

namespace App\Services;

/**
 * Interface CreateMovementServiceInterface
 * @package App\Services
 */
interface CreateMovementServiceInterface
{
    /**
     * @param array $data
     * @return array
     */
    public function create(array $data): array;
}
