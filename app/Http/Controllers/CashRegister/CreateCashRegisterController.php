<?php

namespace App\Http\Controllers\CashRegister;

use App\Http\Controllers\Controller;
use App\Services\CreateCashRegisterServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class CashRegisterController
 * @package App\Http\Controllers
 */
class CreateCashRegisterController extends Controller
{
    /**
     * @var CreateCashRegisterServiceInterface
     */
    protected $createCashRegisterService;

    /**
     * CashRegisterController constructor.
     * @param CreateCashRegisterServiceInterface $createCashRegisterService
     */
    public function __construct(CreateCashRegisterServiceInterface $createCashRegisterService)
    {
        $this->createCashRegisterService = $createCashRegisterService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request):JsonResponse
    {
        $validated = $request->validate([
            "denomination" => ['required', 'in:billete,moneda'],
            "value" => ['required', 'integer', 'in:50,100,200,500,1000,5000,10000,20000,50000,100000'],
            'quantity' => ['required', 'integer', 'min:1']
        ]);

        try {
            $created = $this->createCashRegisterService->create($validated);

            return response()->json([
                'message' => $created['message']
            ], 201);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}
