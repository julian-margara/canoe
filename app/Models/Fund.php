<?php

namespace App\Models;

use App\Events\FundCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fund extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saved(function (Fund $fund) {
            FundCreated::dispatch($fund);
        });
    }

    // Relationship
    /**
     * @return BelongsTo
     */
    public function fundManager(): BelongsTo
    {
        return $this->belongsTo(FundManager::class);
    }

    /**
     * @return BelongsToMany
     */
    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class)->withTimestamps();
    }

    /**
     * @return HasMany
     */
    public function aliases(): HasMany
    {
        return $this->hasMany(FundAlias::class);
    }
}
