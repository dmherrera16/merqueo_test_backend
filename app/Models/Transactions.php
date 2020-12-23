<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Transactions
 * @package App\Models
 */
class Transactions extends Model
{
    /**
     * @return BelongsTo
     */
    public function movement(): BelongsTo
    {
        return $this->belongsTo(Movements::class);
    }
}
