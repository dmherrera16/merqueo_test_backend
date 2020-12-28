<?php

namespace App\Repositories;

use App\Models\Movements;
use phpDocumentor\Reflection\Types\Integer;

/**
 * Class MovementsRepository
 * @package App\Repositories
 */
class CreateMovementsRepository implements CreateMovementsRepositoryInterface
{
    /**
     * @var Movements
     */
    protected $movementModel;

    /**
     * MovementsRepository constructor.
     * @param Movements $movementModel
     */
    public function __construct(Movements $movementModel)
    {
        $this->movementModel = $movementModel;
    }

    /**
     * @param array $data
     * @return Movements
     */
    public function create(array $data): Movements
    {
        return $this->movementModel->create($data);
    }

    /**
     * @param string $date
     * @return int
     */
    public function getAmountMovementsByDate(string $date): int
    {
        $movements = $this->movementModel->where('created_at', '<=', $date)->get();
        if (empty($movements)){
            return 0;
        }

        return $movements->sum('amount');
    }

    /**
     * @return array
     */
    public function getAllMovements(): array
    {
        $movements = $this->movementModel->orderBy('id', 'desc')->get();
        if (empty($movements)){
            return [];
        }

        return $movements->toArray();
    }
}
