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
    public function findByValueAndDenomination(string $denomination, int $value): CashRegister
    {
        $cashRegister =  $this->cashRegisterModel->where(['denomination' => $denomination, 'value' => $value])->first();
        if (!$cashRegister){
            return new CashRegister();
        }

        return $cashRegister;
    }

    /**
     * @return array
     */
    public function getAvailableCash(): array
    {
        $availableCash = $this->cashRegisterModel->where('quantity', '>', 0)->orderBy('value', 'desc')->get();
        if (empty($availableCash)) {
            return [];
        }
        return $availableCash->toArray();
    }

    /**
     * @return array
     */
    public function getStatusCashRegister(): array
    {
        $statusCashRegister = $this->cashRegisterModel->orderBy('value', 'desc')->get();
        if (empty($statusCashRegister)) {
            return [];
        }

        return $statusCashRegister->toArray();
    }
}
