<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Movements
 * @package App\Models
 */
class Movements extends Model
{
    protected $fillable = ['type', 'amount'];
}
