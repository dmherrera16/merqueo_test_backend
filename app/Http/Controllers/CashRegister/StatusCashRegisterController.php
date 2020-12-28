<?php

namespace App\Http\Controllers\CashRegister;

use App\Http\Controllers\Controller;
use App\Services\StatusCashRegisterServiceInterface;
use Illuminate\Http\Request;

/**
 * Class StatusCashRegisterController
 * @package App\Http\Controllers\CashRegister
 */
class StatusCashRegisterController extends Controller
{
    /**
     * @var StatusCashRegisterServiceInterface
     */
    protected $statusCashRegisterService;

    /**
     * StatusCashRegisterController constructor.
     * @param StatusCashRegisterServiceInterface $statusCashRegisterService
     */
    public function __construct(StatusCashRegisterServiceInterface $statusCashRegisterService)
    {
        $this->statusCashRegisterService = $statusCashRegisterService;
    }

    public function __invoke()
    {
        try {
            return response()->json([
                'cashRegister' => $this->statusCashRegisterService->statusCashRegister()
            ], 200);
        }catch (\Exception $exception) {
            return response()->json([$exception->getMessage()], 500);
        }
    }
}
