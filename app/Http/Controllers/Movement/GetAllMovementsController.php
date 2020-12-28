<?php

namespace App\Http\Controllers\Movement;

use App\Http\Controllers\Controller;
use App\Services\GetAllMovementsServiceInterface;
use http\Env\Response;
use Illuminate\Http\Request;

/**
 * Class GetAllMovementsController
 * @package App\Http\Controllers\Movement
 */
class GetAllMovementsController extends Controller
{
    /**
     * @var GetAllMovementsServiceInterface
     */
    protected $getAllMovementsService;

    /**
     * GetAllMovementsController constructor.
     * @param GetAllMovementsServiceInterface $getAllMovementsService
     */
    public function __construct(GetAllMovementsServiceInterface $getAllMovementsService)
    {
        $this->getAllMovementsService = $getAllMovementsService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke()
    {
        try {
            $movements = $this->getAllMovementsService->getAllMovements();

            return response()->json(['movements' => $movements]);
        }catch (\Exception $exception){
            return response()->json($exception->getMessage(), 500);
        }
    }
}
