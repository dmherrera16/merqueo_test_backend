<?php

namespace App\Http\Controllers\Movement;

use App\Http\Controllers\Controller;
use App\Services\CreateMovementServiceInterface;
use Illuminate\Http\Request;

/**
 * Class CreateMovementController
 * @package App\Http\Controllers\Movement
 */
class CreateMovementController extends Controller
{
    /**
     * @var CreateMovementServiceInterface
     */
    protected $createMovementServiceRepository;

    /**
     * CreateMovementController constructor.
     * @param CreateMovementServiceInterface $createMovementServiceRepository
     */
    public function __construct(CreateMovementServiceInterface $createMovementServiceRepository)
    {
        $this->createMovementServiceRepository = $createMovementServiceRepository;
    }

    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'type' => ['required', 'in:ingreso,egreso'],
            'amount' => ['required', 'integer'],
            'transactions' => ['array'],
            'transactions.*.denomination' => ['required'],
            'transactions.*.value' => ['required'],
            'transactions.*.quantity' => ['required'],
        ]);

        try {

            $response = $this->createMovementServiceRepository->create($validated);

            return response()->json($response, 201);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }

    }
}
