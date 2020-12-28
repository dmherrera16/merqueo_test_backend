<?php

namespace App\Services;

use App\Repositories\CashRegisterRepositoryInterface;

/**
 * Class StatusCashRegisterService
 * @package App\Services
 */
class StatusCashRegisterService implements StatusCashRegisterServiceInterface
{
    /**
     * @var CashRegisterRepositoryInterface
     */
    protected $cashRegisterRepository;

    /**
     * StatusCashRegisterService constructor.
     * @param CashRegisterRepositoryInterface $cashRegisterRepository
     */
    public function __construct(CashRegisterRepositoryInterface $cashRegisterRepository)
    {
        $this->cashRegisterRepository = $cashRegisterRepository;
    }

    /**
     * @return array
     */
    public function statusCashRegister(): array
    {
        $statusCashRegister = $this->cashRegisterRepository->getStatusCashRegister();

        $response = [];

        foreach ($statusCashRegister as $cashRegister){
            $response[] = [
                'denomination' => $cashRegister['denomination'],
                'value' => $cashRegister['value'],
                'quantity' => $cashRegister['quantity'],
            ];
        }

        return $response;
    }
}
