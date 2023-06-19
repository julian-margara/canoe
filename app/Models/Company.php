<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $hidden = ['pivot'];

    /**
     * @return BelongsToMany
     */
    public function funds(): BelongsToMany
    {
        return $this->belongsToMany(Fund::class)->withTimestamps();
    }
//
//    /**
//     * @return HasOne
//     */
//    public function fundManager(): HasOne
//    {
//        return $this->hasMany(FundManager::class);
//    }
}
