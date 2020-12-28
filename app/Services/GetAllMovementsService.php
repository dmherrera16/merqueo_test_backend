<?php

namespace App\Services;

use App\Repositories\CreateMovementsRepositoryInterface;

/**
 * Class GetAllMovementsService
 * @package App\Services
 */
class GetAllMovementsService implements GetAllMovementsServiceInterface
{
    /**
     * @var CreateMovementsRepositoryInterface
     */
    protected $movementRepository;

    /**
     * GetAllMovementsService constructor.
     * @param CreateMovementsRepositoryInterface $movementRepository
     */
    public function __construct(CreateMovementsRepositoryInterface $movementRepository)
    {
        $this->movementRepository = $movementRepository;
    }

    /**
     * @return array
     */
    public function getAllMovements(): array
    {
        $movements = $this->movementRepository->getAllMovements();
        if (empty($movements)){
            return [];
        }

        $response = [];
        foreach ($movements as $movement) {
            $response[] = [
                'id' => $movement['id'],
                'date' => $movement['created_at'],
                'amount' => $movement['amount']
            ];
        }

        return $response;
    }
}
