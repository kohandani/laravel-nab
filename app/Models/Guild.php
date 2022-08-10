<?php

namespace App\Models;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guild extends Model
{
    use HasFactory;

    protected $guarded = [];
    

    public function shops(): HasMany
    {
        return $this->hasMany(Shop::class);
    }
}
