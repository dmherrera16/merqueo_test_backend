<?php

namespace App\Services;

/**
 * Interface CreateCashRegisterServiceInterface
 * @package App\Services\Interfaces
 */
interface CreateCashRegisterServiceInterface
{
    /**
     * @param array $data
     * @return array
     */
    public function create(array $data): array;
}
