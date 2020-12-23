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
    /**
     * @return HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transactions::class);
    }
}