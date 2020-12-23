<?php

namespace App\Repositories;

use App\Models\CashRegister;

/**
 * Class CashRegisterRepository
 * @package App\Repositories
 */
class CashRegisterRepository implements CashRegisterRepositoryInterface
{
    /**
     * @var CashRegister
     */
    protected $cashRegisterModel;

    /**
     * CashRegisterRepository constructor.
     * @param CashRegister $cashRegisterModel
     */
    public function __construct(CashRegister $cashRegisterModel)
    {
        $this->cashRegisterModel = $cashRegisterModel;
    }

    /**
     * @param array $data
     * @return CashRegister
     */
    public function create(array $data): CashRegister
    {
        return $this->cashRegisterModel->create($data);
    }

    /**
     * @param string $denomination
     * @param int $value
     * @return CashRegister|null
     */
    public function findByValueAndDenomination(string $denomination, int $value)
    {
        return $this->cashRegisterModel->where(['denomination' => $denomination, 'value' => $value])->first();
    }
}
