<?php

namespace App\Services;

use App\Repositories\CreateMovementsRepositoryInterface;

/**
 * Class GetMovementsService
 * @package App\Services
 */
class GetMovementsService implements GetMovementsServiceInterface
{
    /**
     * @var CreateMovementsRepositoryInterface
     */
    protected $movementRepository;

    /**
     * GetMovementsService constructor.
     * @param CreateMovementsRepositoryInterface $movementRepository
     */
    public function __construct(CreateMovementsRepositoryInterface $movementRepository)
    {
        $this->movementRepository = $movementRepository;
    }

    /**
     * @param array $data
     * @return int
     */
    public function getAmountMovementsByDate(array $data): int
    {
        return $this->movementRepository->getAmountMovementsByDate($data['date']);
    }
}
