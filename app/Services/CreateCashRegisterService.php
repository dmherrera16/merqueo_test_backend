<?php

namespace App\Services;

use App\Repositories\CashRegisterRepositoryInterface;

/**
 * Class CreateCashRegisterService
 * @package App\Services
 */
class CreateCashRegisterService implements CreateCashRegisterServiceInterface
{
    /**
     * @var CashRegisterRepositoryInterface
     */
    protected $cashRegisterRepository;

    /**
     * CreateCashRegisterService constructor.
     * @param CashRegisterRepositoryInterface $cashRegisterRepository
     */
    public function __construct(CashRegisterRepositoryInterface $cashRegisterRepository)
    {
        $this->cashRegisterRepository = $cashRegisterRepository;
    }

    /**
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function create(array $data): array
    {
        try {
            $cashRegister = $this
                ->cashRegisterRepository
                ->findByValueAndDenomination($data['denomination'], $data['value']);

            if (empty($cashRegister->value)) {
                $cashRegister = $this->cashRegisterRepository->create($data);
                return ['message' => __('cash_register.create_success')];
            }

            $cashRegister->quantity = $this->addQuantity($cashRegister->quantity, $data['quantity']);
            $saved = $cashRegister->save();

            if (!$saved) {
                throw new \Exception(__('cash_register.create_failed'));
            }

            return ['message' => __('cash_register.create_success')];
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), 500);
        }

    }

    /**
     * @param int $originalQuantity
     * @param int $quantity
     * @return int
     */
    private function addQuantity(int $originalQuantity, int $quantity): int
    {
        return $originalQuantity + $quantity;
    }
}
