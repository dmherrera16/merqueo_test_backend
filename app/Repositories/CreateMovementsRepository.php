<?php

namespace App\Repositories;

use App\Models\Movements;

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
}
