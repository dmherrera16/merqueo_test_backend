<?php

namespace App\Services;

use App\Repositories\CashRegisterRepositoryInterface;
use Illuminate\Support\Facades\DB;

class EmptyCashRegisterService implements EmptyCashRegisterServiceInterface
{
    /**
     * @var CashRegisterRepositoryInterface
     */
    protected $cashRegisterRepository;

    /**
     * @var CreateMovementServiceInterface
     */
    protected $createMovementService;

    /**
     * EmptyCashRegisterService constructor.
     * @param CashRegisterRepositoryInterface $cashRegisterRepository
     * @param CreateMovementServiceInterface $createMovementService
     */
    public function __construct(
        CashRegisterRepositoryInterface $cashRegisterRepository,
        CreateMovementServiceInterface $createMovementService
    )
    {
        $this->cashRegisterRepository = $cashRegisterRepository;
        $this->createMovementService = $createMovementService;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function emptyCashRegister(): array
    {
        try {
            DB::beginTransaction();
            $statusCashRegister = $this->cashRegisterRepository->getAvailableCash();

            if (empty($statusCashRegister)){
                throw new \Exception(__('movement.money_back_failed'));
            }
            foreach ($statusCashRegister as $cashRegister){
                $dataMovement = [
                    'type' => 'egreso',
                    'amount' => ($cashRegister['value']*$cashRegister['quantity'])*-1,
                    'transactions' => [
                        [
                            'denomination' => $cashRegister['denomination'],
                            'value' => $cashRegister['value'],
                            'quantity' => -$cashRegister['quantity']
                        ]
                    ]
                ];

                $this->createMovementService->create($dataMovement);
            }
            DB::commit();

            return ['message' => __('cash_register.empty_successful')];
        }catch (\Exception $exception) {
            Db::rollBack();
            throw new \Exception($exception->getMessage(), 500);
        }

    }
}
