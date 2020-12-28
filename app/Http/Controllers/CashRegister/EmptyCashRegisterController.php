<?php

namespace App\Http\Controllers\CashRegister;

use App\Http\Controllers\Controller;
use App\Services\EmptyCashRegisterServiceInterface;
use Illuminate\Http\Request;

/**
 * Class EmptyCashRegisterController
 * @package App\Http\Controllers\CashRegister
 */
class EmptyCashRegisterController extends Controller
{
    /**
     * @var EmptyCashRegisterServiceInterface
     */
    protected $emptyCashRegisterService;

    /**
     * EmptyCashRegisterController constructor.
     * @param EmptyCashRegisterServiceInterface $emptyCashRegisterService
     */
    public function __construct(EmptyCashRegisterServiceInterface $emptyCashRegisterService)
    {
        $this->emptyCashRegisterService = $emptyCashRegisterService;
    }

    public function __invoke()
    {
        try {
            $response = $this->emptyCashRegisterService->emptyCashRegister();

            return response()->json($response, 200);
        }catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
