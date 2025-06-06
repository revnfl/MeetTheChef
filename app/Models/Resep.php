<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resep extends Model
{
    protected $fillable = [
        'masakan',
        'bahan',
        'langkah',
        'user_id'
    ];

    #function untuk menangani hubungan dengan user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // public function reseps(): HasMany
    // {
    //     return $this->hasMany(Resep::class);
    // }

}
