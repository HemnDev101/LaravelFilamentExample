<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Treatment extends Model
{
    protected $casts = [
        'price' => MoneyCast::class,
    ];

    use HasFactory;
    public function patient(): BelongsTo
    {

        return $this->belongsTo(Patient::class);
    }

}

