<?php

namespace App\Http\Controllers\Movement;

use App\Http\Controllers\Controller;
use App\Services\GetMovementsServiceInterface;
use Illuminate\Http\Request;

/**
 * Class GetMovementsController
 * @package App\Http\Controllers\Movement
 */
class GetMovementsController extends Controller
{
    /**
     * @var GetMovementsServiceInterface
     */
    protected $getMovementsService;

    /**
     * GetMovementsController constructor.
     * @param GetMovementsServiceInterface $getMovementsService
     */
    public function __construct(GetMovementsServiceInterface $getMovementsService)
    {
        $this->getMovementsService = $getMovementsService;
    }

    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date'
        ]);

        try {
            $amount = $this->getMovementsService->getAmountMovementsByDate($validated);

            return response()->json([
                'amount' => $amount
            ], 200);
        }catch (\Exception $exception){
            return response()->json(['message' => $exception->getMessage()], 500);
        }

    }
}
