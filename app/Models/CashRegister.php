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
}
