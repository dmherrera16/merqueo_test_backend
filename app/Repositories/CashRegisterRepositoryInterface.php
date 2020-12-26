<?php

namespace App\Repositories;

use App\Models\CashRegister;

/**
 * Interface CashRegisterRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface CashRegisterRepositoryInterface
{
    /**
     * Esta función crea un registro en la tabla cash_register
     *
     * @param array $data
     * @return CashRegister
     */
    public function create(array $data): CashRegister;

    /**
     * @param string $denomination
     * @param int $value
     * @return CashRegister|null
     */
    public function findByValueAndDenomination(string $denomination, int $value);

    /**
     * @return array
     */
    public function getAvailableCash(): array;
}
