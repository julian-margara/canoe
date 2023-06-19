<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FundAlias extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Disable mass assign protection.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * @return BelongsTo
     */
    public function fund(): BelongsTo
    {
        return $this->belongsTo(Fund::class);
    }
}
