<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CashRegister
 * @package App\Models
 */
class CashRegister extends Model
{
    /**
     * @var string
     */
    protected $table = 'cash_register';

    /**
     * @var string[]
     */
    protected $fillable = ['denomination', 'value', 'quantity'];

    /**
     * @param array $data
     * @return array
     */
    public function validateMoneyBack(array $data): array
    {
        $amount = $data['amount'];
        $totalPaid = 0;

        foreach ($data["transactions"] as $transaction) {
            $totalPaid += $transaction['value'] * $transaction['quantity'];
        }

        $amountBack = $totalPaid - $amount;

        if ($amountBack < 0) {
            return ["ok" => false, "transactions" => []];
        }

        if ($amountBack == 0) {
            return ["ok" => true, "transactions" => []];
        }

        $availableCash = CashRegister::where('quantity', '>', 0)->orderBy('value', 'desc')->get()->toArray();

        $money_back = [];
        foreach ($availableCash as $available) {
            $money_need = (int)($amountBack / $available['value']);

            if ($money_need == 0) {
                continue;
            }

            if ($available['quantity'] >= $money_need) {
                $money_back[] = [
                    'denomination' => $available['denomination'],
                    'value' => $available['value'],
                    'quantity' => -$money_need,
                ];
                $amountBack -= $available['value'] * $money_need;
                continue;
            }

            $money_back[] = [
                'denomination' => $available['denomination'],
                'value' => $available['value'],
                'quantity' => -$available['quantity'],
            ];

            $amountBack -= $available['value'] * $available['quantity'];

        }

        if ($amountBack == 0) {
            return ["ok" => true, "transactions" => $money_back];
        }

        return ["ok" => false, "transactions" => []];
    }
}
