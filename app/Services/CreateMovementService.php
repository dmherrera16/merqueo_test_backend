<?php

namespace App\Services;

use App\Repositories\CashRegisterRepositoryInterface;
use App\Repositories\CreateMovementsRepositoryInterface;
use Illuminate\Support\Facades\DB;

/**
 * Class CreateMovementService
 * @package App\Services
 */
class CreateMovementService implements CreateMovementServiceInterface
{
    /**
     * @var CashRegisterRepositoryInterface
     */
    protected $cashRegisterRepository;

    /**
     * @var CreateMovementsRepositoryInterface
     */
    protected $movementRepository;

    /**
     * @var CreateCashRegisterServiceInterface
     */
    protected $createCashRegisterService;

    /**
     * CreateMovementService constructor.
     * @param CashRegisterRepositoryInterface $cashRegisterRepository
     * @param CreateMovementsRepositoryInterface $movementRepository
     * @param CreateCashRegisterServiceInterface $createCashRegisterService
     */
    public function __construct(
        CashRegisterRepositoryInterface $cashRegisterRepository,
        CreateMovementsRepositoryInterface $movementRepository,
        CreateCashRegisterServiceInterface $createCashRegisterService
    )
    {
        $this->cashRegisterRepository = $cashRegisterRepository;
        $this->movementRepository = $movementRepository;
        $this->createCashRegisterService = $createCashRegisterService;
    }

    /**
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {
        try {
            DB::beginTransaction();
            $totalMoneyBack = $this->calculateMoneyBack($data);

            if ($totalMoneyBack < 0) {
                throw new \Exception(__('movement.money_back_failed'));
            }

            if ($totalMoneyBack == 0) {
                return ["message" => 'El pago es exacto, no hay necesidad de devuelta'];
            }

            $response = $this->getMoneyBack($totalMoneyBack);
            if (empty($response)) {
                throw new \Exception(__('movement.money_back_failed'));
            }

            $saveMovement = $this->movementRepository->create($data);
            if (!$saveMovement) {
                throw new \Exception(__('movement.create_failed'));
            }

            foreach ($data['transactions'] as $transaction) {
                $this->createCashRegisterService->create($transaction);
            }

            foreach ($response as $transaction) {
                $this->createCashRegisterService->create($transaction);
            }
            DB::commit();

            return [
                'totalMoneyBack' => $totalMoneyBack,
                'data' => $response,
                'message' => __('movement.create_success')
            ];

        }catch (\Exception $exception){
            DB::rollBack();
            throw new \Exception($exception->getMessage(), 500);
        }

    }

    /**
     * @param int $totalMoneyBack
     * @return array
     */
    private function getMoneyBack(int $totalMoneyBack): array
    {
        $availableCash = $this->cashRegisterRepository->getAvailableCash();
        if (empty($availableCash)) {
            return [];
        }

        $moneyBackList = [];
        foreach ($availableCash as $available) {
            $money_need = (int)($totalMoneyBack / $available['value']);

            if ($money_need == 0) {
                continue;
            }

            if ($available['quantity'] >= $money_need) {
                $moneyBackList[] = [
                    'denomination' => $available['denomination'],
                    'value' => $available['value'],
                    'quantity' => -$money_need,
                ];
                $totalMoneyBack -= $available['value'] * $money_need;
                continue;
            }

            $moneyBackList[] = [
                'denomination' => $available['denomination'],
                'value' => $available['value'],
                'quantity' => -$available['quantity'],
            ];

            $totalMoneyBack -= $available['value'] * $available['quantity'];

        }

        if ($totalMoneyBack == 0) {
            return $moneyBackList;
        }

        return [];
    }

    /**
     * @param array $data
     * @return int
     */
    private function calculateMoneyBack(array $data): int
    {
        $totalPaid = 0;

        foreach ($data["transactions"] as $transaction) {
            $totalPaid += $transaction['value'] * $transaction['quantity'];
        }

        return $totalPaid - $data['amount'];
    }
}
